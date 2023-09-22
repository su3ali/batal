<?php

Route::get('contracts/change_status', 'Contracts\ContractController@change_status')->name('contracts.change_status');
Route::resource('contracts', 'Contracts\ContractController');


Route::get('contract_packages/change_status', 'Contracts\ContractPackagesController@change_status')->name('contract_packages.change_status');
Route::resource('contract_packages', 'Contracts\ContractPackagesController');



Route::resource('contract_order', 'Contracts\ContractOrderController');
Route::get('contract_order/contractPackage/autoCompleteContract', 'Contracts\ContractOrderController@autoCompleteContract')->name('contract_order.autoCompleteContract');
Route::get('contract_order/contractPackage/getContractById', 'Contracts\ContractOrderController@getContractById')->name('contract_order.getContractById');
Route::get('contract_order/contractPackage/getAvailableTime', 'Contracts\ContractOrderController@getAvailableTime')->name('contract_order.getAvailableTime');
Route::get('contract_order/contractPackage/showBookingDiv', 'Contracts\ContractOrderController@showBookingDiv')->name('contract_order.showBookingDiv');
