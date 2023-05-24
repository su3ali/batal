<?php

use App\Http\Controllers\Api\Settings\SettingsController;

Route::prefix('settings')->middleware('auth')->group(function () {

    Route::get('/', [SettingsController::class, 'index']);


});
