<?php

use App\Http\Controllers\Api\Chat\UserChatController;

Route::group(['prefix' => 'chat'], function () {
    Route::post('/broadcasting/auth', function (\Illuminate\Http\Request $request){
        if (Auth::check()) {
            $user = Auth::user();
            $socketId = $request->input('socket_id');
            $channelName = $request->input('channel_name');
            $channelData = ['user_id' => $user->id, 'name' => $user->name];
            $authData = Broadcast::auth($request);
            $authData['channel_data'] = json_encode($channelData);

            return $authData;
        } else {
            abort(403, 'Unauthorized');
        }
    });
    Route::get('my_rooms', [UserChatController::class, 'myRooms']);
    Route::post('broadcast', [UserChatController::class, 'saveMessage']);
    Route::get('loadChat', [UserChatController::class, 'loadChat']);
});
