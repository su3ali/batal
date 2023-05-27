<?php

use App\Http\Controllers\Api\Core\ContactUsController;
use App\Http\Controllers\Api\Core\HomeController;
use App\Http\Controllers\Api\Core\ServiceController;
use App\Http\Controllers\Api\Intro\IntroController;
use App\Http\Controllers\Api\Product\Operations\ProductOperationsController;
use App\Http\Controllers\Api\SinglePages\CategoryController;
use App\Http\Controllers\Api\SinglePages\ProductController;
use App\Http\Controllers\Api\SinglePages\SettingsController;
use App\Http\Controllers\Api\SinglePages\StoreController;

Route::prefix('home')->group(function (){
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/search', [HomeController::class, 'search']);
});

Route::prefix('services')->group(function (){
    Route::get('/all', [ServiceController::class, 'allServices']);
    Route::get('/most_ordered', [ServiceController::class, 'orderedServices']);
    Route::get('/{id}', [ServiceController::class, 'serviceDetails']);
    Route::get('/services_from_category/{id}', [ServiceController::class, 'getServiceFromCategory']);
});

Route::post('contactus',[ContactUsController::class,'store']);
Route::post('home_search', [HomeController::class, 'search']);
Route::post('home_filter', [HomeController::class, 'filter']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('rate', [HomeController::class, 'rate']);
});
