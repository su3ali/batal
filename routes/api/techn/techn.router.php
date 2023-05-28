<?php

use App\Http\Controllers\Api\Techn\Auth\AuthController;
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



//Route::post('/payment-callback/{type?}',[CheckoutController::class,'callbackPayment']);

Route::middleware('auth:sanctum')->group(function () {
    require __DIR__ . '/auth.router.php';
    require __DIR__ . '/home.router.php';

});

