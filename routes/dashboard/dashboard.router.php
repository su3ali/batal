<?php

use App\Http\Controllers\Dashboard\Setting\SettingController;
use App\Support\Actions\ChangeLocalizationAction;
use Illuminate\Support\Facades\Route;

Route::any('clear', function () {

    //Artisan::call('storage:link');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');

    //Artisan::call('telescope:clear');
    //Artisan::call('telescope:prune');

    session()->flash('success', t_('All Command successfully'));

    return redirect()->back();
})->name('clear.cache');

Route::get('lang/{locale}', [ChangeLocalizationAction::class, '__invoke'])->name('lang');
include __DIR__ . '/auth.routes.php';

Route::group(['middleware' => ['auth:dashboard']], static function () {
    Route::get('/','IndexController@index' )->name('home');
    require __DIR__ . '/core.routes.php';
    require __DIR__ . '/order.routes.php';
    require __DIR__ . '/booking.routes.php';
    require __DIR__ . '/contract.routes.php';
    require __DIR__ . '/coupons.routes.php';
    require __DIR__ . '/setting.routes.php';
    require __DIR__ . '/visits.routes.php';
    require __DIR__ . '/rates.routes.php';
    require __DIR__ . '/notification.routes.php';
    require __DIR__ . '/reports.routes.php';
});


