<?php


use App\Http\Controllers\Api\Bookings\BookingsController;
use App\Http\Controllers\Api\Coupons\CouponsController;
use App\Http\Controllers\Api\Orders\OrdersController;
use App\Http\Controllers\Api\Statuses\StatusController;
use App\Http\Controllers\Api\Techn\home\VisitsController;

Route::prefix('orders')->middleware('auth')->group(function () {

    Route::get('/', [OrdersController::class, 'myOrders']);
    Route::get('/{id}', [OrdersController::class, 'orderDetails']);
//    Route::post('refund')

});
Route::prefix('statuses')->middleware('auth')->group(function () {

    Route::get('/bookings', [StatusController::class, 'bookingsStatuses']);
    Route::get('/orders', [StatusController::class, 'ordersStatuses']);
    Route::get('/visits', [StatusController::class, 'visitsStatuses']);
//    Route::post('refund')

});

Route::prefix('coupons')->middleware('auth')->group(function () {

    Route::get('/', [CouponsController::class, 'allCoupons']);
    Route::post('submit_coupon', [CouponsController::class, 'submit']);
    Route::post('cancel_coupon', [CouponsController::class, 'cancel']);
});
Route::prefix('bookings')->middleware('auth')->group(function () {
    Route::get('/', [BookingsController::class, 'myBookings']);
    Route::get('/{id}', [BookingsController::class, 'bookingDetails']);
    Route::post('/change_status', [VisitsController::class, 'changeStatus']);
});
Route::prefix('rate')->middleware('auth')->group(function (){
    Route::post('technicians', [OrdersController::class, 'rateTechnicians']);
});
