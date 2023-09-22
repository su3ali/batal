<?php

namespace App\Bll;

use App\Models\Coupon;
use App\Models\CouponUser;
use Carbon\Carbon;

class CouponCheck
{
    public function check_avail($coupon, $coupon_user, $total)
    {
        if (
            !$coupon
            ||
            $coupon->active == 0
            ||
            Carbon::parse($coupon->start)->format('y-m-d') > Carbon::now()->format('y-m-d')
        ) {
            $response = ['error' => __("api.Invalid Code !")];
            return $response;
        }
        if ($coupon->min_price && $coupon->min_price > $total){
            $response = ['error' => __("api.Your order price didn't reach the minimum value for the coupon !")];
            return $response;
        }
        if (
            $coupon->times_used >= $coupon->times_limit
            ||
            Carbon::now()->format('y-m-d') >= Carbon::parse($coupon->end)->format('y-m-d')
        ) {
            $response = ['error' => __("api.Expired Code !")];
            return $response;
        }
        if ($coupon->user_times <= $coupon_user->count()) {
            $response = ['error' => __("api.You cant use this code anymore !")];
            return $response;
        }
        $response = ['success' => __('api.coupon applied !')];
        return $response;
    }
}
