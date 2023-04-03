<?php

Route::resource('orders', 'Orders\OrderController');
Route::resource('order_statuses', 'Orders\OrderStatusController');
Route::get('order_statuses/change_status/change', 'Orders\OrderStatusController@change_status')->name('order_statuses.change_status');
