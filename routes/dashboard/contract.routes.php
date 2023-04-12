<?php

Route::get('contracts/change_status', 'Contracts\ContractController@change_status')->name('contracts.change_status');
Route::resource('contracts', 'Contracts\ContractController');


Route::get('contract_packages/change_status', 'Contracts\ContractPackagesController@change_status')->name('contract_packages.change_status');
Route::resource('contract_packages', 'Contracts\ContractPackagesController');

