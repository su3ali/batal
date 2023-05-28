<?php


use App\Http\Controllers\Api\Techn\home\VisitsController;

Route::prefix('home')->middleware('auth')->group(function () {

    Route::get('/currentOrders', [VisitsController::class, 'myCurrentOrders']);
    Route::get('/previousOrders', [VisitsController::class, 'myPreviousOrders']);
//    Route::get('/{id}', [VisitsController::class, 'orderDetails']);

});

