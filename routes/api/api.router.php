<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Checkout\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', [AuthController::class, 'login']);

Route::post('/verify', [AuthController::class, 'verify']);


//Route::post('/payment-callback/{type?}',[CheckoutController::class,'callbackPayment']);

Route::middleware(['auth:sanctum','abilities:user'])->group(function () {
    require __DIR__ . '/core.router.php';
    require __DIR__ . '/auth.router.php';
    require __DIR__ . '/users.router.php';
    require __DIR__ . '/checkout.router.php';
    require __DIR__ . '/order.router.php';
    require __DIR__ . '/settings.router.php';
});

Route::prefix('techn')->group(function () {
    require __DIR__ . '/techn/techn.router.php';
});
