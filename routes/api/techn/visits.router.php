<?php


use App\Http\Controllers\Api\Statuses\StatusController;
use App\Http\Controllers\Api\Techn\home\VisitsController;

Route::prefix('visits')->group(function () {
    Route::post('/change_status', [VisitsController::class, 'changeStatus']);
    Route::get('/visit_statuses', [StatusController::class, 'visitsStatuses']);
    Route::post('/change_location', [VisitsController::class, 'sendLatLong']);
});

