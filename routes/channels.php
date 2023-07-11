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
Broadcast::channel('chat_message.{chat}', function ($user, $roomId) {
//    return  $room->admin_id == $admin->id;
    return ['id' => $user->id, 'name' => $user->first_name, 'type' => class_basename(get_class($user))];
});
Broadcast::channel('chat_room.{room_id}', function ($user, $room) {
//    return  $room->admin_id == $admin->id;
    return ['id' => $user->id, 'name' => $user->first_name, 'type' => class_basename(get_class($user)), 'room' => $room];
});
