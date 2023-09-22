<?php

Route::resource('orders', 'Orders\OrderController');
Route::resource('order_statuses', 'Orders\OrderStatusController');
Route::get('order_statuses/change_status/change', 'Orders\OrderStatusController@change_status')->name('order_statuses.change_status');

Route::post('order/customer/store', 'Orders\OrderController@customerStore')->name('order.customerStore');
Route::get('order/customer/autoCompleteCustomer', 'Orders\OrderController@autoCompleteCustomer')->name('order.autoCompleteCustomer');
Route::get('order/service/autoCompleteService', 'Orders\OrderController@autoCompleteService')->name('order.autoCompleteService');
Route::get('order/service/getServiceById', 'Orders\OrderController@getServiceById')->name('order.getServiceById');
Route::get('order/service/getAvailableTime', 'Orders\OrderController@getAvailableTime')->name('order.getAvailableTime');
Route::get('order/showService', 'Orders\OrderController@showService')->name('order.showService');
Route::get('order/confirmOrder', 'Orders\OrderController@confirmOrder')->name('order.confirmOrder');
Route::get('order/orderDetail', 'Orders\OrderController@orderDetail')->name('order.orderDetail');

