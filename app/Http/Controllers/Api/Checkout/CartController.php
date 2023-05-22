<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Bll\ControlCart;
use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\CartResource;
use App\Models\Booking;
use App\Models\BookingSetting;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Service;
use App\Support\Api\ApiResponse;
use App\Traits\schedulesTrait;
use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    use ApiResponse, schedulesTrait;

    public function __construct()
    {
        $this->middleware('localize');
    }

    protected function add_to_cart(Request $request): JsonResponse
    {
        $service = Service::with('category')->find($request->service_id);

        if ($service && $service->active === 1) {
            $cart = Cart::query()->where('user_id', auth()->user()->id)->where('service_id', $service->id)
                ->first();
            if ($cart) {
                return self::apiResponse(400, t_('Already In Your Cart!'), $this->body);
            }
            Cart::query()->create([
                'user_id' => auth()->user()->id,
                'service_id' => $service->id,
                'category_id' => $service->category->id,
                'price' => $service->price,
                'quantity' => $request->quantity
            ]);
            $carts = Cart::query()->where('user_id', auth()->user()->id)->count();
            $this->body['total_items_in_cart'] = $carts;
            return self::apiResponse(200, t_('Added To Cart Successfully'), $this->body);
        }
        return self::apiResponse(400, t_('service not found or an error happened.'), $this->body);

    }


    protected function index(): JsonResponse
    {
        $carts = Cart::query()->where('user_id', auth()->user()->id)->get();

        $cat_ids = $carts->pluck('category_id');
        $this->body['carts'] = [];
        foreach ($cat_ids as $cat_id) {
            if ($cat_id) {
                $this->body['carts'][] = [
                    'category_id' => $cat_id,
                    'category_title' => Category::query()->find($cat_id)?->title,
                    'cart-services' => CartResource::collection($carts->where('category_id', $cat_id))
                ];
            }
        }
        $total = number_format($this->calc_total($carts), 2, '.', '');
        $this->body['total'] = $total;

        return self::apiResponse(200, null, $this->body);
    }

    protected function updateCart(Request $request)
    {

        if (auth()->user()->carts->first()) {
            $rules = [
                'category_ids' => 'required|array',
                'category_ids.*' => 'required|exists:categories,id',
                'date' => 'required|array',
                'date.*' => 'required|date',
                'time' => 'required|array',
                'time.*' => 'required|date_format:H:i A',
                'notes' => 'nullable|array',
                'notes.*' => 'nullable|string|max:191',
            ];

            $request->validate($rules, $request->all());
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
                Cart::query()->where('user_id', auth('sanctum')->user()->id)
                    ->where('category_id', $category_id)->update([
                        'date' => $request->date[$key],
                        'time' => Carbon::parse($request->time[$key])->toTimeString(),
                        'notes' => $request->notes ? array_key_exists($key,$request->notes) ? $request->notes[$key] : '' :''
                    ]);
            }
            return self::apiResponse(200, t_('date and time for reservations updated successfully'), $this->body);
        }
        return self::apiResponse(400, t_('cart empty'), $this->body);
    }

    protected function controlItem(Request $request): JsonResponse
    {
        $cart = Cart::query()->find($request->cart_id);
        if ($cart) {
            if (request()->action == 'delete') {
                $cart->delete();
                $response = ['success' => 'deleted successfully'];
                $carts = Cart::query()->where('user_id', auth()->user()->id)->get();
                $cat_ids = $carts->pluck('category_id');
                $this->body['carts'] = [];
                foreach ($cat_ids as $cat_id) {
                    if ($cat_id) {
                        $this->body['carts'][] = [
                            'category_id' => $cat_id,
                            'category_title' => Category::query()->find($cat_id)?->title,
                            'cart-services' => CartResource::collection($carts->where('category_id', $cat_id))
                        ];
                    }
                }
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
                    foreach ($cat_ids as $cat_id) {
                        if ($cat_id) {
                            $this->body['carts'][] = [
                                'category_id' => $cat_id,
                                'category_title' => Category::query()->find($cat_id)?->title,
                                'cart-services' => CartResource::collection($carts->where('category_id', $cat_id))
                            ];
                        }
                    }
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
            'date' => 'required|date',
            'service_ids' => 'required|array',
            'service_ids.*' => 'required|exists:services,id',
        ];
        $request->validate($rules, $request->all());
        $day = Carbon::parse($request->date)->locale('en')->dayName;

        $times = [];
        foreach ($request->service_ids as $service_id) {
            $bookSetting = BookingSetting::where('service_id', $service_id)->first();
            if ($bookSetting) {
                $get_time = $this->getTime($day, $bookSetting);
                if ($get_time == true) {
                    $times[] = CarbonInterval::minutes($bookSetting->service_duration + $bookSetting->buffering_time)
                        ->toPeriod(
                            \Carbon\Carbon::now()->setTimeFrom($bookSetting->service_start_time ?? Carbon::now()->startOfDay()),
                            Carbon::now()->setTimeFrom($bookSetting->service_end_time ?? Carbon::now()->endOfDay())
                        );
                }

            }
        }
        $finalAvailTimes = [];
        $oldMemory = [];
        foreach ($times as $time) {
            $allTimes = [];
            foreach ($time as $t) {
                $allTimes[] = $t->format('g:i A');
            }
            if (isset($oldMemory[0])) {
                $finalAvailTimes = array_intersect($allTimes, $oldMemory);
            } else {
                $oldMemory = $allTimes;
                $finalAvailTimes = $allTimes;
            }
        }
//        foreach ($finalAvailTimes as $finalAvailTime){
//
//        }
        //check if groups available to be continued
        $this->body['times'] = $finalAvailTimes;
        return self::apiResponse(200, null, $this->body);
    }
}
