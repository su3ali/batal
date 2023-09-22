<?php

Route::get('report/sales', 'Reports\ReportsController@sales')->name('report.sales');
Route::get('report/contractSales', 'Reports\ReportsController@contractSales')->name('report.contractSales');
Route::get('report/customers', 'Reports\ReportsController@customers')->name('report.customers');
Route::get('report/technicians', 'Reports\ReportsController@technicians')->name('report.technicians');
Route::get('report/services', 'Reports\ReportsController@services')->name('report.services');

