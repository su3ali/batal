<?php

Route::resource('bookings', 'Bookings\BookingController');
Route::resource('booking_statuses', 'Bookings\BookingStatusController');
Route::get('booking_statuses/change_status/change', 'Bookings\BookingStatusController@change_status')->name('booking_statuses.change_status');

Route::resource('booking_setting', 'Bookings\BookingSettingController');

Route::get('get_group_by_service', 'Bookings\BookingController@getGroupByService')->name('getGroupByService');
