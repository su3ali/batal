<?php


use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\SinglePages\StoreController;

Route::prefix('orders')->middleware('auth')->group(function () {

    Route::get('/', [OrderController::class, 'index']);
    Route::post('/custom_order', [StoreController::class, 'custom_order']);
    Route::get('/{id}', [OrderController::class, 'singleOrder']);
    Route::post('/{id}', [OrderController::class, 'refund']);

//    Route::post('refund')
});
