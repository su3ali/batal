<?php


use App\Http\Controllers\Api\Techn\home\VisitsController;

Route::prefix('home')->group(function () {

    Route::get('/currentOrders', [VisitsController::class, 'myCurrentOrders']);
    Route::get('/previousOrders', [VisitsController::class, 'myPreviousOrders']);
    Route::get('/ordersByDateNow', [VisitsController::class, 'myOrdersByDateNow']);
    Route::get('order/{id}', [VisitsController::class, 'orderDetails']);

});



Route::prefix('visit')->group(function () {
    Route::post('/paid', [VisitsController::class, 'paid']);
    Route::post('/change_order_cancel', [VisitsController::class, 'change_order_cancel']);
});


