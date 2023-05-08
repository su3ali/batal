<?php

use App\Http\Controllers\Api\Checkout\CartController;
use App\Http\Controllers\Api\Checkout\CheckoutController;
use App\Http\Controllers\Api\Checkout\CouponController;

Route::post('add_to_cart', [CartController::class, 'add_to_cart']);
Route::get('cart', [CartController::class, 'index']);
Route::get('delete/cart', [CartController::class, 'delete_cart']);
Route::post('control_cart_item', [CartController::class, 'controlItem']);

Route::get('address', [CheckoutController::class, 'index']);
Route::post('add-address', [CheckoutController::class, 'addAddress']);

Route::get('get-areas', [CheckoutController::class, 'getArea']);


Route::prefix('checkout')->group(function (){

    Route::post('/', [CheckoutController::class, 'checkout']);

});


Route::post('submit_coupon', [CouponController::class, 'submit']);
Route::post('cancel_coupon', [CouponController::class, 'cancel']);
