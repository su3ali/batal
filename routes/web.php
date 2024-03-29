<?php


Route::get('/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('permission:cache-reset');
    Artisan::call('optimize:clear');

    return "Cleared!";

});


Route::get('/', function (){
    return redirect()->route('dashboard.home');
});

