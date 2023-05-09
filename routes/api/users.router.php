<?php

use App\Http\Controllers\Api\Core\AddressController;
use App\Http\Controllers\Api\Product\Favourite\FavouriteController;

Route::prefix('user')->group(function (){
    Route::prefix('addresses')->group(function (){
        Route::get('/', [AddressController::class, 'getAddresses']);
        Route::post('/', [AddressController::class, 'addAddress']);
        Route::post('/{id}/update', [AddressController::class, 'updateAddress']);
        Route::get('/{id}/delete', [AddressController::class, 'deleteAddress']);
        Route::get('/{id}/make_default', [AddressController::class, 'makeAddressDefault']);
    });
    Route::get('favourites', [FavouriteController::class, 'favourites']);
    Route::post('add_to_fav', [FavouriteController::class, 'add_to_fav']);
});
