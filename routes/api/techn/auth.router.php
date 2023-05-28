<?php


use App\Http\Controllers\Api\Techn\Auth\AuthController;

Route::post('/logout', [AuthController::class, 'logout']);




