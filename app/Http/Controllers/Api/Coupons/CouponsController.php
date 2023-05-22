<?php

namespace App\Http\Controllers\Api\Coupons;

use App\Bll\CouponCheck;
use App\Http\Controllers\Controller;
use App\Http\Resources\Checkout\UserAddressResource;
use App\Http\Resources\Coupons\CouponsResource;
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
        $this->middleware('localize');
    }

    protected function allCoupons(){
        $coupons = Coupon::query()->where('active', 1)
            ->where('start', '<=', Carbon::now())->where('end', '>=', Carbon::now())
            ->get();
        $this->body['coupons'] = CouponsResource::collection($coupons);
        return self::apiResponse(200, null, $this->body);
    }

    protected function submit(Request $request){
        $code = $request->code;
        $total = $request->total;
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
                $coupon->times_used++;
                $coupon->save();
                $coupon_value = $coupon->value;
                $total = $total - $coupon_value;
                $this->body['coupon_value'] = $coupon_value;
                $this->body['total'] = $total;
                return self::apiResponse(200, $res['success'], $this->body);
            }else{
                return self::apiResponse(400, $res['error'], $this->body);
            }

        }
        return self::apiResponse(400, t_('invalid code!'), $this->body);

    }
    protected function cancel(Request $request){
        $coupon = Coupon::query()->where('code', $request->code)->first();
        if ($coupon){
            CouponUser::query()->where('user_id', auth()->user()->id)
                ->where('coupon_id', $coupon->id)->delete();
            $coupon->times_used--;
            $coupon->save();
            $total = $request->total + $coupon->value;
            $this->body['total'] = $total;
            return self::apiResponse(200, null, $this->body);
        }else{
            return self::apiResponse(400, t_('invalid code!'), $this->body);
        }

    }
}