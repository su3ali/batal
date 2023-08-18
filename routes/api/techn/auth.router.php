<?php


use App\Http\Controllers\Api\Techn\Auth\AuthController;
use App\Http\Controllers\Api\Techn\Auth\TechProfileController;

Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/profile', [TechProfileController::class, 'getTechnInfo']);
Route::post('/profile/edit', [TechProfileController::class, 'updateTechnInfo']);
Route::post('/profile/editByCode', [TechProfileController::class, 'editByCode']);
Route::get('/notification', [TechProfileController::class, 'getNotification']);
Route::post('/notification/delete', [TechProfileController::class, 'deleteNotification']);
Route::post('/notification/read', [TechProfileController::class, 'readNotification']);
Route::post('/deleteAccount', [AuthController::class, 'deleteAccount']);




