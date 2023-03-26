<?php

use App\Http\Controllers\FrontEnd\Landind\LandingPageController;

Route::get('/', [LandingPageController::class, 'index']);

