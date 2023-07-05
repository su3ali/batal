<?php

use App\Http\Controllers\Dashboard\Chat\ChatController;

Route::group(['prefix' => 'chat'], function () {
    Route::get('view_chat', [ChatController::class, 'index']);
    Route::post('broadcast', [ChatController::class, 'saveMessage'])->name('chat.broadcast');
    Route::get('loadChat', [ChatController::class, 'loadChat'])->name('chat.loadChat');
});
