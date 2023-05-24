<?php


Route::get('/showNotification','NotificationController@showNotification')->name('notification.showNotification');
Route::post('/sendNotification','NotificationController@sendNotification')->name('notification.sendNotification');
