<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('chat.{chat}', function ($user, $order) {
    return true;
});
Broadcast::channel('chat-room.{chat}', function ($user, $tech, $roomId) {
    return true;

//    $room = \App\Models\Room::with('sender')->find($roomId);
//    if (class_basename(get_class($room->sender)) == 'User'){
//        return \App\Models\Room::with('sender')->find($roomId)?->sender->id == $user->id;
//    }else{
//        return \App\Models\Room::with('sender')->find($roomId)?->sender->id == $tech->id;
//    }
});
Broadcast::channel('chat_message.{chat}', function (\App\Models\Admin $admin, \App\Models\Room $room) {
//    return  $room->admin_id == $admin->id;
    return true;
});
