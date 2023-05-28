<?php


use App\Http\Controllers\Api\Techn\home\VisitsController;

Route::prefix('home')->middleware('auth')->group(function () {

    Route::get('/currentOrders', [VisitsController::class, 'myCurrentOrders']);
    Route::get('/previousOrders', [VisitsController::class, 'myPreviousOrders']);
    Route::get('order/{id}', [VisitsController::class, 'orderDetails']);

});

