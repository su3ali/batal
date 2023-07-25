<?php

use App\Http\Controllers\Api\Checkout\CartController;
use App\Http\Controllers\Api\Checkout\CheckoutController;
use App\Http\Controllers\Api\Coupons\CouponsController;

Route::prefix('carts')->group(function (){
    Route::post('add_to_cart', [CartController::class, 'add_to_cart']);
    Route::get('/', [CartController::class, 'index']);
    Route::get('delete', [CartController::class, 'delete_cart']);
    Route::get('/get_avail_times_from_date', [CartController::class, 'getAvailableTimesFromDate']);
    Route::post('/update_cart', [CartController::class, 'updateCart']);
    Route::post('control_cart_item', [CartController::class, 'controlItem']);

});


Route::get('address', [CheckoutController::class, 'index']);
Route::post('add-address', [CheckoutController::class, 'addAddress']);

Route::get('get-areas', [CheckoutController::class, 'getArea']);


Route::prefix('checkout')->group(function (){

    Route::post('/', [CheckoutController::class, 'checkout']);

    Route::post('paid', [CheckoutController::class, 'paid']);

});

