<?php

use App\Http\Controllers\Dashboard\Chat\ChatController;


Route::group(['prefix' => 'chat'], function () {
    Broadcast::routes(['middleware' => ['auth:dashboard']]);
    Route::get('view_chat', [ChatController::class, 'index']);
    Route::post('broadcast', [ChatController::class, 'saveMessage'])->name('chat.broadcast');
    Route::get('loadChat', [ChatController::class, 'loadChat'])->name('chat.loadChat');
//    Route::post('auth', [ChatController::class, 'auth'])->name('chat.auth');

});
