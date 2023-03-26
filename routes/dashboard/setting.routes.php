<?php

use App\Http\Controllers\Dashboard\SettingsController;

Route::group(['prefix' => 'settings'], function (){
    Route::get('/', [SettingsController::class, 'index'])->name('settings')->middleware('permission:view_setting');
    Route::post('/', [SettingsController::class, 'update'])->middleware('permission:update_setting');
});
