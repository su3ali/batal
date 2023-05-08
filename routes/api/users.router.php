<?php

use App\Http\Controllers\Api\Product\Favourite\FavouriteController;

Route::prefix('user')->group(function (){
    Route::get('favourites', [FavouriteController::class, 'favourites']);
    Route::post('add_to_fav', [FavouriteController::class, 'add_to_fav']);
});
