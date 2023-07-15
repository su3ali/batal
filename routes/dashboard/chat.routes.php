<?php

use App\Http\Controllers\Dashboard\Chat\ChatController;


Route::group(['prefix' => 'chat'], function () {
    Route::post('/broadcasting/auth', function (\Illuminate\Http\Request $request){
        if (Auth::check()) {
            $pusher = new \Pusher\Pusher('87ed15aef6ced76b1507', 'd8f21b90df201e227ad8', "1629640");
            $user = Auth::user();
            $socketId = $request->input('socket_id');
            $channelName = $request->input('channel_name');
            $channelData = ['user_id' => $user->id, 'name' => $user->name];
            $authDatas = $pusher->socket_auth($request->get('channel_name'), $request->get('socket_id'), json_encode($channelData));
            $authData['auth'] = json_decode($authDatas)->auth;
            $authData['channel_data'] = json_encode($channelData);

            return $authData;
        } else {
            abort(403, 'Unauthorized');
        }
    });
    Broadcast::routes(['middleware' => ['auth:dashboard']]);
    Route::get('view_chat', [ChatController::class, 'index']);
    Route::post('broadcast', [ChatController::class, 'saveMessage'])->name('chat.broadcast');
    Route::get('loadChat', [ChatController::class, 'loadChat'])->name('chat.loadChat');
    Route::get('searchChat', [ChatController::class, 'searchChat'])->name('chat.searchChat');
//    Route::post('auth', [ChatController::class, 'auth'])->name('chat.auth');


    Route::get('test_view', [ChatController::class, 'testView']);

});
