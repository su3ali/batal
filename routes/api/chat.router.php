<?php

use App\Http\Controllers\Api\Chat\UserChatController;

Route::group(['prefix' => 'chat'], function () {
    Route::post('/broadcasting/auth', function (\Illuminate\Http\Request $request){


            $pusher = new \Pusher\Pusher('87ed15aef6ced76b1507', 'd8f21b90df201e227ad8', "1629640");
            $user = Auth::user();
            $socketId = $request->input('socket_id');
            $channelName = $request->input('channel_name');
            $channelData = ['user_id' => $user->id, 'name' => $user->name];
            $authDatas = $pusher->socket_auth($request->get('channel_name'), $request->get('socket_id'), json_encode($channelData));
            $authData['auth'] = json_decode($authDatas)->auth;
            $authData['channel_data'] = json_encode($channelData);

            return $authData;

    });
    Route::get('my_rooms', [UserChatController::class, 'myRooms']);
    Route::post('broadcast', [UserChatController::class, 'saveMessage']);
    Route::get('loadChat', [UserChatController::class, 'loadChat']);
});
