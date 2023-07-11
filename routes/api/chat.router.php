<?php

use App\Http\Controllers\Api\Chat\UserChatController;

Route::group(['prefix' => 'chat'], function () {
    Route::post('/broadcasting/auth', function (\Illuminate\Http\Request $request){
        if (Auth::check()) {
            $pusher = new \Pusher\Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'));
            $user = Auth::user();
            $socketId = $request->input('socket_id');
            $channelName = $request->input('channel_name');
            $channelData = ['user_id' => $user->id, 'name' => $user->name];
            $authData = $pusher->socket_auth($request->get('channel_name'), $request->get('socket_id'));
            $authData = collect(json_decode($authData))->toArray();
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
