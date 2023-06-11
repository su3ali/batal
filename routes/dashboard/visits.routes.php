<?php

Route::resource('visits', 'Visits\VisitsController');
Route::get('visits/change_status', 'Visits\VisitsController@change_status')->name('visits.change_status');
Route::post('visits/getLocation', 'Visits\VisitsController@getLocation')->name('visits.getLocation');
Route::post('visits/updateStatus', 'Visits\VisitsController@updateStatus')->name('visits.updateStatus');


Route::get('reason_cancel/change_status', 'Visits\ReasonCancelController@change_status')->name('reason_cancel.change_status');
Route::resource('reason_cancel', 'Visits\ReasonCancelController');


Route::get('visits_statuses/change_status', 'Visits\VisitStatusController@change_status')->name('visits_statuses.change_status');
Route::resource('visits_statuses', 'Visits\VisitStatusController');
