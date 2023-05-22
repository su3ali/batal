<?php

Route::resource('visits', 'Visits\VisitsController');
Route::get('visits/change_status', 'Visits\VisitsController@change_status')->name('visits.change_status');


Route::get('reason_cancel/change_status', 'Visits\ReasonCancelController@change_status')->name('reason_cancel.change_status');
Route::resource('reason_cancel', 'Visits\ReasonCancelController');