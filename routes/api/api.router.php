<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Core\HomeController;
use App\Http\Controllers\Api\Core\ServiceController;
use App\Http\Controllers\Api\Settings\SettingsController;
use App\Http\Controllers\Api\Coupons\CouponsController;
use App\Http\Controllers\VersionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/home', [HomeController::class, 'index']);
Route::get('/home/search', [HomeController::class, 'search']);



Route::get('/services/services_from_category/{id}', [ServiceController::class, 'getServiceFromCategory']);

Route::get('/settings', [SettingsController::class, 'index']);
Route::get('/settings/faqs', [SettingsController::class, 'getFaqs']);
Route::get('/coupons', [CouponsController::class, 'allCoupons']);
Route::get('contact', [ServiceController::class, 'getContact']);
Route::get('package/{id}', [ServiceController::class, 'PackageDetails']);
Route::get('package', [ServiceController::class, 'getPackage']);

Route::post('check_update', [VersionController::class, 'checkUpdate'])->name('check_update');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/verify', [AuthController::class, 'verify']);


//Route::post('/payment-callback/{type?}',[CheckoutController::class,'callbackPayment']);

Route::middleware(['auth:sanctum', 'abilities:user'])->group(function () {
    require __DIR__ . '/complaint.router.php';
    require __DIR__ . '/core.router.php';
    require __DIR__ . '/auth.router.php';
    require __DIR__ . '/chat.router.php';
    require __DIR__ . '/users.router.php';
    require __DIR__ . '/checkout.router.php';
    require __DIR__ . '/order.router.php';
    require __DIR__ . '/settings.router.php';
});

Route::prefix('techn')->group(function () {
    require __DIR__ . '/techn/techn.router.php';
});
