<?php

Route::resource('bookings', 'Bookings\BookingController');
Route::resource('booking_statuses', 'Bookings\BookingStatusController');
Route::get('booking_statuses/change_status/change', 'Bookings\BookingStatusController@change_status')->name('booking_statuses.change_status');


Route::get('booking_setting',  'Bookings\BookingSettingController@index')->name('booking_setting.index');
Route::post('booking_setting',  'Bookings\BookingSettingController@store')->name('booking_setting.store');
Route::post('booking_setting/{id}', 'Bookings\BookingSettingController@update')->name('booking_setting.update');
