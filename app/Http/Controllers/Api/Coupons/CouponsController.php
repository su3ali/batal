<?php

namespace App\Http\Controllers\Api\Coupons;

use App\Bll\CouponCheck;
use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\Coupons\CouponsResource;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\UserAddresses;
use App\Support\Api\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localization');
    }

    protected function allCoupons(){
        $coupons = Coupon::query()->where('active', 1)
            ->where('start', '<=', Carbon::now('Asia/Riyadh'))->where('end', '>=', Carbon::now('Asia/Riyadh'))
            ->get();
        $this->body['coupons'] = CouponsResource::collection($coupons);
        return self::apiResponse(200, null, $this->body);
    }

    protected function submit(Request $request){
        $code = $request->code;
        $user = auth()->user('sanctum');

        $carts = Cart::query()->where('user_id', $user->id)->get();
        if (!$carts->first()) {
            return self::apiResponse(400, __('api.cart empty'), []);
        }
        $total = $this->calc_total($carts);
        $coupon = Coupon::query()->where('code', $code)->first();

        if ($coupon){
            $coupon_user = CouponUser::query()->where('coupon_id', $coupon->id)
                ->where('user_id', auth()->user()->id)->get();
            $check = new CouponCheck();
            $res = $check->check_avail($coupon, $coupon_user, $total);
            if (key_exists('success', $res)){
                CouponUser::query()->create([
                    'user_id' => auth()->user()->id,
                    'coupon_id' => $coupon->id
                ]);
                foreach ($carts as $cart){
                    $cart->update([
                       'coupon_id' => $coupon->id
                    ]);
                }
                $coupon->times_used++;
                $coupon->save();
                $coupon_value = $coupon->type == 'percentage'?($coupon->value/100)*$total : $coupon->value;
                $sub_total = $total - $coupon_value;
                $this->body['coupon_value'] = $coupon_value;
                $this->body['total'] = $total;
                $this->body['sub_total'] = $sub_total;
                return self::apiResponse(200, $res['success'], $this->body);
            }else{
                return self::apiResponse(400, $res['error'], $this->body);
            }

        }
        return self::apiResponse(400, __('api.invalid code!'), $this->body);

    }
    protected function cancel(Request $request){

        $user = auth()->user('sanctum');

        $carts = Cart::query()->where('user_id', $user->id)->get();
        if (!$carts->first()) {
            return self::apiResponse(400, __('api.cart empty'), []);
        }
        $total = $this->calc_total($carts);

        $coupon = Coupon::query()->where('code', $request->code)->first();
        if ($coupon){
            CouponUser::query()->where('user_id', auth()->user()->id)
                ->where('coupon_id', $coupon->id)->delete();
            $coupon->times_used--;
            $coupon->save();
            foreach ($carts as $cart){
                $cart->update([
                    'coupon_id' => null
                ]);
            }
            $coupon_value = $coupon->type == 'percentage'?($coupon->value/100)*$total : $coupon->value;
            $sub_total = $request->total - $coupon_value;

            $this->body['coupon_value'] = $coupon_value;
            $this->body['total'] = $total;
            $this->body['sub_total'] = $sub_total;
            return self::apiResponse(200, null, $this->body);
        }else{
            return self::apiResponse(400, __('api.invalid code!'), $this->body);
        }

    }

    private function calc_total($carts)
    {
        $total = [];
        for ($i = 0; $i < $carts->count(); $i++) {
            $cart_total = ($carts[$i]->price) * $carts[$i]->quantity;
            $total[] = $cart_total;
        }
        return array_sum($total);
    }

}
