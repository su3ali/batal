<?php


use App\Http\Controllers\Api\Bookings\BookingsController;
use App\Http\Controllers\Api\Coupons\CouponsController;
use App\Http\Controllers\Api\Orders\OrdersController;

Route::prefix('orders')->middleware('auth')->group(function () {

    Route::get('/', [OrdersController::class, 'myOrders']);
//    Route::post('refund')

});

Route::prefix('coupons')->middleware('auth')->group(function () {

    Route::get('/', [CouponsController::class, 'allCoupons']);
    Route::post('submit_coupon', [CouponsController::class, 'submit']);
    Route::post('cancel_coupon', [CouponsController::class, 'cancel']);
});
Route::prefix('bookings')->middleware('auth')->group(function () {

    Route::get('/', [BookingsController::class, 'myBookings']);


});
