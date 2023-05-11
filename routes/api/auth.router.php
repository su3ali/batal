<?php


use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Core\PersonalInfoController;
use App\Http\Controllers\Dashboard\Setting\SettingController;

Route::get('/user', [PersonalInfoController::class, 'getUserInfo']);
Route::post('/user/edit', [PersonalInfoController::class, 'updateUserInfo']);



