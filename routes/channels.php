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
Broadcast::channel('chat_message.{chat}', function (\App\Models\Admin $admin, $roomId) {
//    return  $room->admin_id == $admin->id;
    return ['id' => $admin->id, 'name' => $admin->first_name];
});
Broadcast::channel('chat_room.{room_id}', function (\App\Models\Admin $admin, $room) {
//    return  $room->admin_id == $admin->id;
    return ['id' => $admin->id, 'name' => $admin->first_name, 'room' => $room];
});
