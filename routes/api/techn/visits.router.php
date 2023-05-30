<?php


use App\Http\Controllers\Api\Techn\home\VisitsController;

Route::prefix('visits')->middleware('auth')->group(function () {

    Route::post('/change_status', [VisitsController::class, 'changeStatus']);

});

