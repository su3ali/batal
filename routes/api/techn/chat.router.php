<?php

use App\Http\Controllers\Api\Chat\UserChatController;

Route::group(['prefix' => 'chat'], function () {
    Route::get('my_rooms', [UserChatController::class, 'myRooms']);
    Route::post('broadcast', [UserChatController::class, 'saveMessage']);
    Route::get('loadChat', [UserChatController::class, 'loadChat']);
});
