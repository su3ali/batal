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
use App\Models\Group;
use App\Models\Service;
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
    use ApiResponse, schedulesTrait,imageTrait;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function add_to_cart(Request $request): JsonResponse
    {
        if ($request->type == 'package') {
            $package = ContractPackage::with('service.category')->find($request->package_id);
            if ($package && $package->active === 1) {
                $cart = Cart::query()->where('user_id', auth()->user()->id)
                    ->first();
                if ($cart) {
                    return self::apiResponse(400, t_('finish current order first or clear the cart'), $this->body);
                }
                for ($i = 0; $i < $package->visit_number; $i++) {
                    Cart::query()->create([
                        'user_id' => auth()->user()->id,
                        'contract_package_id' => $package->id,
                        'service_id' => $package->service_id,
                        'category_id' => $package->service->category_id,
                        'price' => $package->price,
                        'quantity' => $package->visit_number,
                        'type' => 'package'
                    ]);
                }
//                $carts = Cart::query()->where('user_id', auth()->user()->id)->count();
//                $this->body['total_items_in_cart'] = $carts;
                $this->body['total_items_in_cart'] = 1;
                return self::apiResponse(200, t_('Added To Cart Successfully'), $this->body);
            }

        } else {
            $service = Service::with('category')->find($request->service_id);
            if ($service && $service->active === 1) {
                $cart = Cart::query()->where('user_id', auth()->user()->id)->where('service_id', $service->id)
                    ->first();
                if ($cart) {
                    return self::apiResponse(400, t_('Already In Your Cart!'), $this->body);
                }
                if (auth()->user()->carts->where('type', 'package')->first()) {
                    return self::apiResponse(400, t_('finish current order first or clear the cart'), $this->body);
                }

                if($request->is_advance == 1){
                    $price = $service->preview_price;
                }else{
                    $price = $service->price;
                }
                Cart::query()->create([
                    'user_id' => auth()->user()->id,
                    'service_id' => $service->id,
                    'category_id' => $service->category->id,
                    'price' => $price,
                    'quantity' => $request->quantity,
                    'type' => 'service'
                ]);
                $carts = Cart::query()->where('user_id', auth()->user()->id)->count();
                $this->body['total_items_in_cart'] = $carts;
                return self::apiResponse(200, t_('Added To Cart Successfully'), $this->body);
            }

        }

        return self::apiResponse(400, t_('service not found or an error happened.'), $this->body);

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
                'file' => 'nullable|array',
                'file.*' => 'nullable',
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
                    return self::apiResponse(400, t_('date or time is missed'), $this->body);
                }

                foreach ($request->category_ids as $key => $category_id) {

                    $countGroup = CategoryGroup::where('category_id', $category_id)->count();

                    $countInBooking = Booking::with(['visit' => function ($q) {
                        $q->whereNotIn('visits_status_id', [5, 6]);
                    }])->where('category_id', $category_id)->where('date', $request->date[$key])
                        ->where('time', Carbon::createFromFormat('H:i A', $request->time[$key])->format('H:i:s'))->count();

                    if ($countInBooking == $countGroup) {
                        return self::apiResponse(400, t_('There is a category for which there are currently no technical groups available'), $this->body);
                    }

                    if ($request->file&& array_key_exists($key, $request->file)){
                        $file=$this->storeImages($request->file[$key],'cart');
                        $upload= 'storage/cart'.'/'.$file;
                    }
                    Cart::query()->where('user_id', auth('sanctum')->user()->id)
                        ->where('category_id', $category_id)->update([
                            'date' => $request->date[$key],
                            'time' => Carbon::parse($request->time[$key])->toTimeString(),
                            'notes' => $request->notes ? array_key_exists($key, $request->notes) ? $request->notes[$key] : '' : '',
                            'files' => $upload??null,
                        ]);
                }
                return self::apiResponse(200, t_('date and time for reservations updated successfully'), $this->body);
            } else {
                $cartCategoryCount = auth()->user()->carts->first()->quantity;
                if (
                    count($request->category_ids) < $cartCategoryCount
                    ||
                    count($request->time) < $cartCategoryCount
                    ||
                    count($request->date) < $cartCategoryCount
                ) {
                    return self::apiResponse(400, t_('date or time is missed'), $this->body);
                }
                foreach (auth()->user()->carts as $key => $cart) {

                    $countGroup = CategoryGroup::where('category_id', $cart->category_id)->count();

                    $countInBooking = Booking::with(['visit' => function ($q) {
                        $q->whereNotIn('visits_status_id', [5, 6]);
                    }])->where('category_id', $cart->category_id)->where('date', $request->date[$key])
                        ->where('time', Carbon::createFromFormat('H:i A', $request->time[$key])->format('H:i:s'))->count();

                    if ($countInBooking == $countGroup) {
                        return self::apiResponse(400, t_('There is a category for which there are currently no technical groups available'), $this->body);
                    }
                    if ($request->file && array_key_exists($key, $request->file)){
                        $file=$this->storeImages($request->file[$key],'cart');
                        $upload= 'storage/cart'.'/'.$file;
                    }
                    $cart->update([
                            'date' => $request->date[$key],
                            'time' => Carbon::parse($request->time[$key])->toTimeString(),
                            'notes' => $request->notes ? array_key_exists($key, $request->notes) ? $request->notes[$key] : '' : '',
                            'files' => $upload ?? null,

                    ]);
                }
                return self::apiResponse(200, t_('date and time for reservations updated successfully'), $this->body);

            }
        }
        return self::apiResponse(400, t_('cart empty'), $this->body);
    }

    protected function controlItem(Request $request): JsonResponse
    {
        $cart = Cart::query()->find($request->cart_id);
        if ($cart) {
            if (request()->action == 'delete') {
                if ($cart->type == 'package'){
                    Cart::query()->where('user_id', auth()->user()->id)->delete();
                }else{
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
                $total = number_format($this->calc_total($carts), 2);
                $cat_ids = $carts->pluck('category_id');
                if (key_exists('success', $response)) {
                    $this->body['total'] = $total;
                    $this->body['carts'] = [];
                    $cat_ids = array_unique($cat_ids->toArray());
                    foreach ($cat_ids as $cat_id) {
                        if ($cat_id) {
                            $this->body['carts'][] = [
                                'category_id' => $cat_id,
                                'category_title' => Category::query()->find($cat_id)?->title,
                                'cart-services' => CartResource::collection($carts->where('category_id', $cat_id))
                            ];
                        }
                    }

                    $deposit=0;
                    foreach ($carts as $cart) {
                        $service = Service::where('id',$cart->service_id)->first();
                        $deposit +=$service->deposit_price;
                    }
                    $this->body['total_items_in_cart'] = auth()->user()->carts->count();
                    $this->body['deposit_price'] = $deposit;

                    return self::apiResponse(200, $response['success'], $this->body);
                } else {
                    return self::apiResponse(400, $response['error'], $this->body);
                }
            }
        }
        return self::apiResponse(400, t_('Cart Not Found'), $this->body);

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
        ];
        $request->validate($rules, $request->all());
        $times = [];
        foreach ($request->service_ids as $service_id) {
            $bookSetting = BookingSetting::where('service_id', $service_id)->first();
            if (!$bookSetting){
                return self::apiResponse(400, 'عفوا الخدمة غير متاحة حاليا', []);
            }
            $dayStartIndex = array_search($bookSetting->service_start_date, $this->days);
            $dayEndIndex = array_search($bookSetting->service_end_date, $this->days);
            $serviceDays = [];
            for ($i = $dayStartIndex; $i <= $dayEndIndex; $i++) {
                $serviceDays[] = $this->days[$i];
            }
            $dates = [];
            for ($i = 0; $i < 14; $i++) {
                $date = date('Y-m-d', strtotime('+' . $i . ' day'));
                if (in_array(date('l', strtotime($date)), $serviceDays)) {
                    $dates[] = $date;
                }
            }
            if ($bookSetting) {
                foreach ($dates as $day) {
                    $dayName = Carbon::parse($day)->locale('en')->dayName;
                    $get_time = $this->getTime($dayName, $bookSetting);
                    if ($get_time == true) {
                        $times[$service_id][$day] = CarbonInterval::minutes($bookSetting->service_duration + $bookSetting->buffering_time)
                            ->toPeriod(
                                \Carbon\Carbon::now()->setTimeFrom($bookSetting->service_start_time ?? Carbon::now()->startOfDay()),
                                Carbon::now()->setTimeFrom($bookSetting->service_end_time ?? Carbon::now()->endOfDay())
                            );
                    }
                }
            }
        }
        $collectionOfTimesOfServices = [];
        foreach ($times as $service_id => $timesInDays) {
            $collectionOfTimes = [];
            foreach ($timesInDays as $day => $time) {
                $times = $time->toArray();
                $subTimes['day'] = $day;
                $subTimes['dayName'] = Carbon::parse($day)->locale(app()->getLocale())->dayName;
                $subTimes['times'] = collect($times)->map(function ($time) {
                    return $time->format('g:i A');
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
                    'category_id' => $cat_id,
                    'category_title' => Category::query()->find($cat_id)?->title,
                    'category_minimum' => Category::query()->find($cat_id)?->minimum,
                    'cart-services' => CartResource::collection($carts->where('category_id', $cat_id))
                ];
            }
        }
        $deposit=0;
        foreach ($carts as $cart) {
            $service = Service::where('id',$cart->service_id)->first();
            $deposit +=$service->deposit_price;
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
                'category_id' => $cat_id,
                'category_title' => Category::query()->find($cat_id)?->title,
                'category_minimum' => Category::query()->find($cat_id)?->minimum,
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
