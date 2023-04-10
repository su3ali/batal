<?php

use App\Http\Controllers\Dashboard\SettingsController;

Route::group(['prefix' => 'settings'], function (){
    Route::get('/', [SettingsController::class, 'index'])->name('settings')->middleware('permission:view_setting');
    Route::post('/', [SettingsController::class, 'update'])->middleware('permission:update_setting');

    Route::get('country/change_status', 'Settings\CountryController@change_status')->name('country.change_status');
    Route::resource('country', 'Settings\CountryController');

    Route::get('city/change_status', 'Settings\CityController@change_status')->name('city.change_status');
    Route::resource('city', 'Settings\CityController');

    Route::get('region/change_status', 'Settings\RegionController@change_status')->name('region.change_status');
    Route::resource('region', 'Settings\RegionController');

    Route::get('faqs/change_status', 'Settings\FaqsController@change_status')->name('faqs.change_status');
    Route::resource('faqs', 'Settings\FaqsController');

});
