<?php

use App\Http\Controllers\Api\Techn\Auth\AuthController;
use App\Http\Controllers\Api\Techn\lang\LangController;
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
Route::get('/getLang', [LangController::class, 'getLang']);



//Route::post('/payment-callback/{type?}',[CheckoutController::class,'callbackPayment']);

Route::middleware(['auth:sanctum','abilities:technician'])->group(function () {
    require __DIR__ . '/auth.router.php';
    require __DIR__ . '/home.router.php';
    require __DIR__ . '/visits.router.php';
    require __DIR__ . '/settings.router.php';

});

