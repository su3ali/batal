<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Bll\ControlCart;
use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\CartResource;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\ContractPackage;
use App\Models\ContractPackagesUser;
use App\Models\Group;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Visit;
use App\Support\Api\ApiResponse;
use App\Traits\imageTrait;
use App\Traits\schedulesTrait;
use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    use ApiResponse, schedulesTrait, imageTrait;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function add_to_cart(Request $request): JsonResponse
    {
        if ($request->type == 'package') {
            $package = ContractPackage::where('id', $request->package_id)->first();
            if ($package && $package->active === 1) {
                $cart = Cart::query()->where('user_id', auth()->user()->id)
                    ->first();
                if ($cart) {
                    return self::apiResponse(400, __('api.finish current order first or clear the cart'), $this->body);
                }
                for ($i = 0; $i < $package->visit_number; $i++) {
                    Cart::query()->create([
                        'user_id' => auth()->user()->id,
                        'contract_package_id' => $package->id,
                        'price' => $package->price,
                        'quantity' => $package->visit_number,
                        'type' => 'package'
                    ]);
                }
                //                $carts = Cart::query()->where('user_id', auth()->user()->id)->count();
                //                $this->body['total_items_in_cart'] = $carts;
                $this->body['total_items_in_cart'] = 1;
                return self::apiResponse(200, __('api.Added To Cart Successfully'), $this->body);
            }
        } else {
            $service = Service::with('category')->find($request->service_id);
            if ($service && $service->active === 1) {
                $cart = Cart::query()->where('user_id', auth()->user()->id)->where('service_id', $service->id)
                    ->first();
                if ($cart) {
                    return self::apiResponse(400, __('api.Already In Your Cart!'), $this->body);
                }
                if (auth()->user()->carts->where('type', 'package')->first()) {
                    return self::apiResponse(400, __('api.finish current order first or clear the cart'), $this->body);
                }
                $price =  $service->price;
                $now = Carbon::now('Asia/Riyadh');
                $contractPackagesUser =  ContractPackagesUser::where('user_id', auth()->user()->id)
                    ->whereDate('end_date', '>=', $now)
                    ->where(function ($query) use ($service) {
                        $query->whereHas('contactPackage', function ($qu) use ($service) {
                            $qu->whereHas('ContractPackagesServices', function ($qu) use ($service) {
                                $qu->where('service_id', $service->id);
                            });
                        });
                    })->first();

                if ($contractPackagesUser) {
                    $contractPackage = ContractPackage::where('id', $contractPackagesUser->contract_packages_id)->first();
                    if ($request->quantity < ($contractPackage->visit_number - $contractPackagesUser->used)) {
                        $price = 0;
                    } else {
                        $price = ($request->quantity - ($contractPackage->visit_number - $contractPackagesUser->used)) *  $service->price;
                    }
                }


                // if ($request->icon_ids) {
                //     $icon_ids = $request->icon_ids;

                //     foreach ($icon_ids as $icon_id) {

                //         $price += Icon::where('id', $icon_id)->first()->price;
                //     }
                // }

                if ($request->is_advance == 1) {
                    $price = $service->preview_price;
                }
                Cart::query()->create([
                    'user_id' => auth()->user()->id,
                    'service_id' => $service->id,
                    // 'icon_ids' => json_encode($request->icon_ids),
                    'category_id' => $service->category->id,
                    'price' => $price,
                    'quantity' => $request->quantity,
                    'type' => 'service'
                ]);
                $carts = Cart::query()->where('user_id', auth()->user()->id)->count();
                $this->body['total_items_in_cart'] = $carts;
                return self::apiResponse(200, __('api.Added To Cart Successfully'), $this->body);
            }
        }

        return self::apiResponse(400, __('api.service not found or an error happened.'), $this->body);
    }


    protected function index(): JsonResponse
    {
        $this->handleCartResponse();
        return self::apiResponse(200, null, $this->body);
    }

    protected function updateCart(Request $request)
    {
        $cart = auth()->user()->carts->first();
        if ($cart) {
            $rules = [
                'category_ids' => 'required|array',
                'category_ids.*' => 'required|exists:categories,id',
                'date' => 'required|array',
                'date.*' => 'required|date',
                'time' => 'required|array',
                'time.*' => 'required|date_format:h:i A',
                'notes' => 'nullable|array',
                'notes.*' => 'nullable|string|max:191',
            ];

            $request->validate($rules, $request->all());
            if ($cart->type == 'service' || !$cart->type) {

                $cartCategoryCount = count(array_unique(auth()->user()->carts->pluck('category_id')->toArray()));
                if (
                    count($request->category_ids) < $cartCategoryCount
                    ||
                    count($request->time) < $cartCategoryCount
                    ||
                    count($request->date) < $cartCategoryCount
                ) {
                    return self::apiResponse(400, __('api.date or time is missed'), $this->body);
                }

                foreach ($request->category_ids as $key => $category_id) {


                    $countGroup = CategoryGroup::where('category_id', $category_id)->count();

                    $countInBooking = Booking::whereHas('visit', function ($q) {
                        $q->whereNotIn('visits_status_id', [5, 6]);
                    })->where('category_id', $category_id)->where('date', $request->date[$key])
                        ->where('time', Carbon::createFromFormat('H:i A', $request->time[$key])->format('H:i:s'))->count();



                    if ($countInBooking == $countGroup) {
                        return self::apiResponse(400, __('api.There is a category for which there are currently no technical groups available'), $this->body);
                    }


                    Cart::query()->where('user_id', auth('sanctum')->user()->id)
                        ->where('category_id', $category_id)->update([
                            'date' => $request->date[$key],
                            'time' => Carbon::parse($request->time[$key])->timezone('Asia/Riyadh')->toTimeString(),
                            'notes' => $request->notes ? array_key_exists($key, $request->notes) ? $request->notes[$key] : '' : '',
                        ]);
                }
                return self::apiResponse(200, __('api.date and time for reservations updated successfully'), $this->body);
            } else {

                //      $cartCategoryCount = count(array_unique(auth()->user()->carts->pluck('category_id')->toArray()));
                $cartCategoryCount = auth()->user()->carts->count();
                if (
                    count($request->category_ids) < $cartCategoryCount
                    ||
                    count($request->time) < $cartCategoryCount
                    ||
                    count($request->date) < $cartCategoryCount
                ) {
                    return self::apiResponse(400, __('api.date or time is missed'), $this->body);
                }
                foreach (auth()->user()->carts as $key => $cart) {

                    $countGroup = CategoryGroup::where('category_id', $cart->category_id)->count();

                    $countInBooking = Booking::whereHas('visit', function ($q) {
                        $q->whereNotIn('visits_status_id', [5, 6]);
                    })->where('category_id', $cart->category_id)->where('date', $request->date[$key])
                        ->where('time', Carbon::createFromFormat('H:i A', $request->time[$key])->format('H:i:s'))->count();

                    if ($countInBooking == $countGroup) {
                        return self::apiResponse(400, __('api.There is a category for which there are currently no technical groups available'), $this->body);
                    }

                    $cart->update([
                        'date' => $request->date[$key],
                        'time' => Carbon::parse($request->time[$key])->timezone('Asia/Riyadh')->toTimeString(),
                        'notes' => $request->notes ? array_key_exists($key, $request->notes) ? $request->notes[$key] : '' : '',

                    ]);
                }
                return self::apiResponse(200, __('api.date and time for reservations updated successfully'), $this->body);
            }
        }
        return self::apiResponse(400, __('api.cart empty'), $this->body);
    }

    protected function controlItem(Request $request): JsonResponse
    {
        $cart = Cart::query()->find($request->cart_id);
        if ($cart) {
            if (request()->action == 'delete') {
                if ($cart->type == 'package') {
                    Cart::query()->where('user_id', auth()->user()->id)->delete();
                } else {
                    $cart->delete();
                }
                $response = ['success' => 'deleted successfully'];
                $this->handleCartResponse();
                return self::apiResponse(200, $response['success'], $this->body);
            }
            $service = service::query()->where('id', $cart->service_id)->first();
            if ($service) {
                $controlClass = new ControlCart();
                $response = $controlClass->makeAction($request->action, $cart, $service);

                $carts = Cart::query()->where('user_id', auth()->user()->id)->get();


                $tempTotal = $this->calc_total($carts);
                $now = Carbon::now('Asia/Riyadh');
                $contractPackagesUser =  ContractPackagesUser::where('user_id', auth()->user()->id)
                    ->whereDate('end_date', '>=', $now)
                    ->where(function ($query) use ($service) {
                        $query->whereHas('contactPackage', function ($qu) use ($service) {
                            $qu->whereHas('ContractPackagesServices', function ($qu) use ($service) {
                                $qu->where('service_id', $service->id);
                            });
                        });
                    })->first();

                if ($contractPackagesUser) {
                    $contractPackage = ContractPackage::where('id', $contractPackagesUser->contract_packages_id)->first();
                    if ($cart->quantity <  ($contractPackage->visit_number - $contractPackagesUser->used)) {
                        $tempTotal = 0;
                    } else {
                        $tempTotal = ($cart->quantity - ($contractPackage->visit_number - $contractPackagesUser->used)) * $service->price;
                    }
                }


                $total = number_format($tempTotal, 2);
                $cat_ids = $carts->pluck('category_id');
                if (key_exists('success', $response)) {
                    $this->body['total'] = $total;
                    $this->body['carts'] = [];
                    $cat_ids = array_unique($cat_ids->toArray());
                    foreach ($cat_ids as $cat_id) {
                        if ($cat_id) {
                            $this->body['carts'][] = [
                                'category_id' => $cat_id ?? 0,
                                'category_title' => Category::query()->find($cat_id)?->title ?? '',
                                'category_minimum' => Category::query()->find($cat_id)?->minimum ?? 0,
                                'cart-services' => CartResource::collection($carts->where('category_id', $cat_id))
                            ];
                        }
                    }

                    $deposit = 0;
                    foreach ($carts as $cart) {
                        $service = Service::where('id', $cart->service_id)->first();
                        $deposit += $service->deposit_price;
                    }
                    $this->body['total_items_in_cart'] = auth()->user()->carts->count();
                    $this->body['deposit_price'] = $deposit;

                    return self::apiResponse(200, $response['success'], $this->body);
                } else {
                    return self::apiResponse(400, $response['error'], $this->body);
                }
            }
        }
        return self::apiResponse(400, __('api.Cart Not Found'), $this->body);
    }

    private function calc_total($carts)
    {
        $total = [];
        for ($i = 0; $i < $carts->count(); $i++) {
            $cart_total = ($carts[$i]->price) * $carts[$i]->quantity;
            array_push($total, $cart_total);
        }
        $total = array_sum($total);
        return $total;
    }

    protected function getAvailableTimesFromDate(Request $request)
    {
        $rules = [
            'service_ids' => 'required|array',
            'service_ids.*' => 'required|exists:services,id',
            'region_id' => 'required|exists:regions,id',
            'package_id' => 'required',
            'page_number' => 'required|numeric'

        ];
        $request->validate($rules, $request->all());
        $category_id = Service::where('id', ($request->service_ids)[0])->first()->category_id;
        $groupIds = CategoryGroup::where('category_id', $category_id)->pluck('group_id')->toArray();
        $group = Group::where('active', 1)->whereHas('regions', function ($qu) use ($request) {
            $qu->where('region_id', $request->region_id);
        })->whereIn('id', $groupIds)->get();
        if ($group->isEmpty()) {
            return self::apiResponse(400, __('api.Sorry, the service is currently unavailable'), []);
        }


        $timeDuration = 60;
        if ($request->package_id != 0) {
            $contract = ContractPackage::where('id', $request->package_id)->first();
            $timeDuration = $contract->time * 30;
        }

        $times = [];
        $bookingTimes = [];
        $bookingDates = [];
        foreach ($request->service_ids as $service_id) {
            $bookSetting = BookingSetting::whereHas('regions', function ($q) use ($request) {
                $q->where('region_id', $request->region_id);
            })->where('service_id', $service_id)->first();

            if (!$bookSetting) {
                return self::apiResponse(400, __('api.Sorry, the service is currently unavailable'), []);
            }

            $dayStartIndex = array_search($bookSetting->service_start_date, $this->days);
            $dayEndIndex = array_search($bookSetting->service_end_date, $this->days);
            $serviceDays = [];
            for ($i = $dayStartIndex; $i <= $dayEndIndex; $i++) {
                $serviceDays[] = $this->days[$i];
            }
            $dates = [];
            $page_size = 14;
            $page_number = 0;
            if ($request->page_number) {
                $page_number = $request->page_number;
            }
            $start = $page_number * $page_size;
            $end = ($page_number + 1) * $page_size;
            if ($start >= $timeDuration) {
                $start = $timeDuration;
            }
            if ($end >= $timeDuration) {
                $end = $timeDuration;
            }
            for ($i = $start; $i <  $end; $i++) {
                $date = Carbon::now('Asia/Riyadh')->addDays($i)->format('Y-m-d');
                if (in_array(Carbon::parse($date)->timezone('Asia/Riyadh')->format('l'), $serviceDays)) {
                    $dates[] = $date;
                }
            }
            if ($bookSetting) {
                foreach ($dates as $day) {
                    $dayName = Carbon::parse($day)->timezone('Asia/Riyadh')->locale('en')->dayName;
                    $get_time = $this->getTime($dayName, $bookSetting);
                    if ($get_time == true) {

                        $times[$service_id][$day] = CarbonInterval::minutes($bookSetting->service_duration + $bookSetting->buffering_time)
                            ->toPeriod(
                                \Carbon\Carbon::now('Asia/Riyadh')->setTimeFrom($bookSetting->service_start_time ?? Carbon::now('Asia/Riyadh')->startOfDay()),
                                Carbon::now('Asia/Riyadh')->setTimeFrom($bookSetting->service_end_time ?? Carbon::now('Asia/Riyadh')->endOfDay())
                            );
                    }
                }
            }

            $bookings = Booking::where('category_id',  $category_id)->whereHas('visit', function ($qq) {
                $qq->whereIn('visits_status_id', [1, 2, 3, 4]);
            })->whereHas('address', function ($qq) use ($request) {
                $qq->where('region_id', $request->region_id);
            })->get();
            foreach ($bookings as $booking) {
                array_push($bookingTimes, $booking->time);
                array_push($bookingDates, $booking->date);
            }
        }


        $collectionOfTimesOfServices = [];
        foreach ($times as $service_id => $timesInDays) {

            $category_id = Service::where('id', $service_id)->first()->category_id;
            $groupIds = CategoryGroup::where('category_id', $category_id)->pluck('group_id')->toArray();
            $countGroup = Group::where('active', 1)->whereHas('regions', function ($qu) use ($request) {
                $qu->where('region_id', $request->region_id);
            })->whereIn('id', $groupIds)->count();

            $collectionOfTimes = [];
            foreach ($timesInDays as $day => $time) {
                $times = $time->toArray();

                $subTimes['day'] = $day;
                $subTimes['dayName'] = Carbon::parse($day)->timezone('Asia/Riyadh')->locale(app()->getLocale())->dayName;
                $subTimes['times'] = collect($times)->map(function ($time) use ($category_id,   $countGroup, $bookSetting, $bookingTimes, $bookingDates, $day, $request) {


                    $now = Carbon::now('Asia/Riyadh')->format('H:i:s');
                    $convertNowTimestamp = Carbon::parse($now)->timezone('Asia/Riyadh')->addHours(2)->timestamp;
                    $dayNow = Carbon::now('Asia/Riyadh')->format('Y-m-d');

                    //realtime
                    $realTime = $time->format('H:i:s');
                    $converTimestamp = Carbon::parse($realTime)->timezone('Asia/Riyadh')->timestamp;
                    //check time between two times
                    $setting = Setting::query()->first();
                    $startDate = $setting->resting_start_time;
                    $endDate = $setting->resting_end_time;



                    // $countInBooking = Booking::whereHas('visit', function ($q) {
                    //     $q->whereNotIn('visits_status_id', [5, 6]);
                    // })->whereHas(
                    //     'address.region',
                    //     function ($q) use ($request) {

                    //         $q->where('id', $request->region_id);
                    //     }
                    // )->where([['category_id', '=', $category_id], ['date', '=',  $day], ['time', '=', $realTime]])
                    //     ->count();
                    //long services
                    $countInBooking = Booking::whereHas('visit', function ($q) {
                        $q->whereNotIn('visits_status_id', [5, 6]);
                    })
                        ->whereHas(
                            'address.region',
                            function ($q) use ($request) {
                                $q->where('id', $request->region_id);
                            }
                        )
                        ->where([['category_id', '=', $category_id]])
                        ->where(function ($query) use ($day, $realTime) {
                            $query->where([['date', '=',  Carbon::parse($day)->timezone('Asia/Riyadh')], ['time', '=', Carbon::parse($realTime)->timezone('Asia/Riyadh')]])
                                ->orWhere(function ($qu) use ($day, $realTime) {
                                    $qu->where([['date', '=',  Carbon::parse($day)->timezone('Asia/Riyadh')], ['time', '<', Carbon::parse($realTime)->timezone('Asia/Riyadh')]])->whereHas('service', function ($service) {
                                        $service->whereHas('BookingSetting', function ($que) {
                                            $que->whereRaw('TIMESTAMPDIFF(MINUTE, service_start_time, service_end_time) < service_duration');
                                        });
                                    });
                                })
                                ->orWhere(function ($qu) use ($day) {
                                    $qu->where([['date', '=',  Carbon::parse(Carbon::parse($day)->timezone('Asia/Riyadh'))->timezone('Asia/Riyadh')->subDay()]])->whereHas('service', function ($service) {
                                        $service->whereHas('BookingSetting', function ($que) {
                                            $que->whereRaw('TIMESTAMPDIFF(MINUTE, service_start_time, service_end_time) < service_duration');
                                        });
                                    });
                                });
                        })->count();

                    $allowedDuration = (Carbon::parse($bookSetting->service_start_time)->diffInMinutes(Carbon::parse($bookSetting->service_end_time)));
                    $diff = (($bookSetting->service_duration) - $allowedDuration) / 60;

                    $inVisit = Visit::where([['start_time', '<', Carbon::parse($realTime)->timezone('Asia/Riyadh')]])->where(function ($que) use ($realTime, $diff) {
                        if ($diff > 0) {
                            $que->where([['end_time', '<', Carbon::parse($realTime)->timezone('Asia/Riyadh')]]);
                        } else {
                            $que->where([['end_time', '>', Carbon::parse($realTime)->timezone('Asia/Riyadh')]]);
                        }
                    })->whereHas('booking', function ($qu) use ($dayNow) {
                        $qu->whereDate('date', '=', Carbon::parse($dayNow));
                    })->get();
                    $inVisit2 = collect();
                    $inVisit3 = collect();
                    if (($bookSetting->service_duration) > (Carbon::parse($bookSetting->service_start_time)->diffInMinutes(Carbon::parse($bookSetting->service_end_time)))) {


                        //visits at the day of expected end with a start time before the expected end
                        $inVisit2 = Visit::where('start_time', '<', Carbon::parse($bookSetting->service_start_time)->timezone('Asia/Riyadh')->addHours($diff % ($allowedDuration / 60)))->whereHas('booking', function ($qu) use ($category_id, $request, $day, $diff, $allowedDuration) {
                            $qu->where([['category_id', '=', $category_id], ['date', '=', Carbon::parse($day)->timezone('Asia/Riyadh')->addDays(1 + intval($diff / ($allowedDuration / 60)))]])->whereHas(
                                'address.region',
                                function ($q) use ($request) {

                                    $q->where('id', $request->region_id);
                                }
                            );
                        })->get();

                        //visits between the expected start and expected end of the visit
                        $inVisit3 = Visit::whereHas('booking', function ($qu) use ($category_id, $request, $day, $diff, $allowedDuration) {
                            $qu->where([['category_id', '=', $category_id], ['date', '<', Carbon::parse($day)->timezone('Asia/Riyadh')->addDays(1 + intval($diff / ($allowedDuration / 60)))], ['date', '>=', Carbon::parse($day)->timezone('Asia/Riyadh')]])->whereHas(
                                'address.region',
                                function ($q) use ($request) {

                                    $q->where('id', $request->region_id);
                                }
                            );
                        })->get();
                    }




                    if ($day == $dayNow && $converTimestamp < $convertNowTimestamp) {

                        // error_log("A");
                    } else if ($countGroup == 0) {
                    } else if ($setting->is_resting == 1 && $time->between($startDate, $endDate, true)) {
                        //  error_log("B");

                    } else if (in_array($day, $bookingDates) && in_array($converTimestamp, $bookingTimes) && ($countInBooking ==  $countGroup)) {
                        //  error_log("C");

                    } else if (in_array($day, $bookingDates)  && ($countInBooking + $inVisit->count()) == $countGroup) {
                    } else if (($inVisit2->IsNotEmpty()  || $inVisit3->IsNotEmpty()) && ($countInBooking + $inVisit->count() + $inVisit2->count() + $inVisit3->count()) == $countGroup) {
                    } else {

                        return $time->format('g:i A');
                    }
                });
                $collectionOfTimes[] = $subTimes;
            }
            $collectionOfTimesOfServices = $collectionOfTimes;
        }
        $this->body['times']['available_days'] = $collectionOfTimesOfServices;
        return self::apiResponse(200, null, $this->body);
    }

    /**
     * @return void
     */
    protected function handleCartResponse(): void
    {
        $carts = Cart::with('coupon')->where('user_id', auth()->user()->id)->where('type', 'service')->orWhereNull('type')->get();
        $cat_ids = $carts->pluck('category_id');
        $this->body['cart_type'] = auth()->user()->carts->first()?->type;
        $this->body['carts'] = [];
        $cat_ids = array_unique($cat_ids->toArray());
        foreach ($cat_ids as $cat_id) {
            if ($cat_id) {
                $this->body['carts'][] = [
                    'category_id' => $cat_id ?? 0,
                    'category_title' => Category::query()->find($cat_id)?->title ?? '',
                    'category_minimum' => Category::query()->find($cat_id)?->minimum ?? 0,
                    'cart-services' => CartResource::collection($carts->where('category_id', $cat_id))
                ];
            }
        }
        $deposit = 0;
        foreach ($carts as $cart) {
            $service = Service::where('id', $cart->service_id)->first();
            $deposit += $service->deposit_price;
        }

        $total = number_format($this->calc_total($carts), 2, '.', '');
        $this->body['total'] = $total;
        $this->body['total_items_in_cart'] = auth()->user()->carts->count();
        $this->body['deposit_price'] = $deposit;


        //packages
        $cart_package = Cart::with('coupon')->where('user_id', auth()->user()->id)->where('type', 'package')->first();
        if ($cart_package) {
            $this->body['total'] = $cart_package->price;
            $this->body['total_items_in_cart'] = 1;
            $cat_id = $cart_package->category_id;
            $this->body['cart_package'][] = [
                'category_id' => $cat_id ?? 0,
                'category_title' => Category::query()->find($cat_id)?->title ?? '',
                'category_minimum' => Category::query()->find($cat_id)?->minimum ?? 0,
                'cart-services' => CartResource::make($cart_package)
            ];
        } else {
            $this->body['cart_package'] = null;
        }
        $this->body['coupon'] = null;
        $coupon = $carts->first()?->coupon;
        if ($coupon) {
            $discount_value = $coupon->type == 'percentage' ? ($coupon->value / 100) * $total : $coupon->value;
            $this->body['coupon'] = [
                'code' => $coupon->code,
                'total_before_discount' => $total,
                'discount_value' => $discount_value,
                'total_after_discount' => $total - $discount_value
            ];
        }
    }
}

//                $formatter = new \IntlDateFormatter(app()->getLocale(), \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
//                $collectionOfTimes[$formatter->format(strtotime($day))] = $subTimes;
