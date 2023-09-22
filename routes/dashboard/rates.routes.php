<?php

Route::get('rates/RateTechnician', 'Rates\RatesController@rateTechnicians')->name('rates.RateTechnician');
Route::get('rates/showTechnician/{id}', 'Rates\RatesController@showTechnicians')->name('rates.showTechnician');

Route::get('rates/RateService', 'Rates\RatesController@rateServices')->name('rates.RateService');
Route::get('rates/showService/{id}', 'Rates\RatesController@showServices')->name('rates.showService');

