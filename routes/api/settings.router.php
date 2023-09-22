<?php

use App\Http\Controllers\Api\Settings\SettingsController;

Route::prefix('settings')->group(function () {

    Route::get('/', [SettingsController::class, 'index']);
    Route::get('/faqs', [SettingsController::class, 'getFaqs']);
    Route::get('walletDetails', [SettingsController::class, 'walletDetails']);


});
