<?php

use App\Http\Controllers\Api\Core\ContactUsController;
use App\Http\Controllers\Api\Core\HomeController;
use App\Http\Controllers\Api\Intro\IntroController;
use App\Http\Controllers\Api\Product\Operations\ProductOperationsController;
use App\Http\Controllers\Api\SinglePages\CategoryController;
use App\Http\Controllers\Api\SinglePages\ProductController;
use App\Http\Controllers\Api\SinglePages\SettingsController;
use App\Http\Controllers\Api\SinglePages\StoreController;

Route::prefix('home')->group(function (){
    Route::get('/', [HomeController::class, 'index']);
});

Route::prefix('product')->group(function (){
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/filter', [ProductOperationsController::class, 'filter']);
});

Route::prefix('store')->group(function (){
    Route::get('/{id}', [StoreController::class, 'show']);
});

Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('contactus',[ContactUsController::class,'store']);
Route::post('home_search', [HomeController::class, 'search']);
Route::post('home_filter', [HomeController::class, 'filter']);
Route::get('rules', [SettingsController::class, 'get_rules']);
Route::get('view_all', [HomeController::class, 'view_all']);
Route::get('main_category/{id}', [CategoryController::class, 'inside_main_categories']);
Route::get('intros',[IntroController::class,'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('rate', [HomeController::class, 'rate']);
});
