<?php

namespace App\Bll;

use App\Models\Coupon;
use App\Models\CouponUser;
use Carbon\Carbon;

class CouponCheck
{
    public function check_avail($coupon, $coupon_user, $total, $carts)
    {
        if (
            !$coupon
            ||
            $coupon->active == 0
            ||
            Carbon::parse($coupon->start)->timezone('Asia/Riyadh')->format('y-m-d') > Carbon::now('Asia/Riyadh')->format('y-m-d')
        ) {
            $response = ['error' => __("api.Invalid Code !")];
            return $response;
        }
/* 
        if(!isset($coupon->service_id) && !isset($coupon->category_id)){
            $discount = $coupon->type == 'percentage'?($coupon->value/100)*$total : $coupon->value;
        }elseif (isset($coupon->service_id) && !isset($coupon->category_id)){
            $used = false;
            $discount = 0;
            foreach($carts as $cart){
                if($cart->service_id === $coupon->service_id){
                    $used = true;
                    $cart_total = ($cart->price) * $cart->quantity;
                    $discount += $coupon->type == 'percentage'?($coupon->value/100)*$cart_total : $coupon->value;
                }
            }
            if(!$used){
                return ['error' => __('api.This coupon con not be used to any of these services !')];
            }
        }else{
            $used = false;
            $discount = 0;
            foreach($carts as $cart){
                if($cart->category_id === $coupon->category_id){
                    $used = true;
                    $cart_total = ($cart->price) * $cart->quantity;
                    $discount += $coupon->type == 'percentage'?($coupon->value/100)*$cart_total : $coupon->value;
                }
            }
            if(!$used){
                return ['error' => __('api.This coupon con not be used to any of these services !')];
            }
        } */

        if ($coupon->min_price && $coupon->min_price > $total){
            $response = ['error' => __("api.Your order price didn't reach the minimum value for the coupon !")];
            return $response;
        }
        if (
            $coupon->times_used >= $coupon->times_limit
            ||
            Carbon::now('Asia/Riyadh')->format('y-m-d') >= Carbon::parse($coupon->end)->format('y-m-d')
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

/*     public function check_coupon_services_match()
    {
    
    } */
}
