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
    return class_basename(get_class($user)) == 'Admin' ||
    $user->id == \App\Models\Room::query()->find($roomId)->sender->id
        ? ['user_id' => $user->id, 'user_type' => class_basename(get_class($user)), 'room_id' => $roomId]
        : false;
});
Broadcast::channel('chat_room.{room_id}', function ($user, $room) {
//    return  $room->admin_id == $admin->id;
    return class_basename(get_class($user)) == 'Admin' ||
    $user->id == $room->sender->id
        ? ['id' => $user->id, 'name' => $user->first_name, 'type' => class_basename(get_class($user)), 'room' => $room]
        : false;
});
