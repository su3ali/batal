<?php

use App\Http\Controllers\Api\Settings\SettingsController;

Route::prefix('settings')->group(function () {

    Route::get('/', [SettingsController::class, 'index']);


});
