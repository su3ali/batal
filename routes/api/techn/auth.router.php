<?php


use App\Http\Controllers\Api\Techn\Auth\AuthController;
use App\Http\Controllers\Api\Techn\Auth\TechProfileController;

Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/profile', [TechProfileController::class, 'getTechnInfo']);
Route::post('/profile/edit', [TechProfileController::class, 'updateTechnInfo']);




