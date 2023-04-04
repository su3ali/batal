<?php

Route::resource('bookings', 'Bookings\BookingController');
Route::resource('booking_statuses', 'Bookings\BookingStatusController');
Route::get('booking_statuses/change_status/change', 'Bookings\BookingStatusController@change_status')->name('booking_statuses.change_status');
