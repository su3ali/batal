<?php

use App\Http\Controllers\Api\Chat\UserChatController;

Route::post('chat/broadcast', [UserChatController::class, 'saveMessage']);
