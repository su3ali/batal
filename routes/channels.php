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
Broadcast::channel('chat_message.{chat}', function ($user, int $roomId) {
//    return  $room->admin_id == $admin->id;
    return true;
});
Broadcast::channel('chat_room.{room_id}', function ($user, $room) {
//    return  $room->admin_id == $admin->id;
    return class_basename(get_class($user)) == 'Admin' ||
    $user->id == \App\Models\Room::query()->find($room)->sender->id
        ? ['id' => $user->id, 'name' => $user->first_name, 'type' => class_basename(get_class($user)), 'room' => $room]
        : false;
});
