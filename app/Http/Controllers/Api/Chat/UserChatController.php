<?php

namespace App\Http\Controllers\Api\Chat;

use App\Events\MessageSentEvent;
use App\Events\NewRoomEvent;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class UserChatController extends Controller
{
    protected function myRooms($id)
    {
        if (auth()->user()->room){
            return response()->json(['messages' => auth()->user()->room->messages]);
        }else{
            return response()->json([]);
        }

    }

    protected function saveMessage(Request $request)
    {
        $user = auth()->user();
        if (!$request->room_id) {
            $room = Room::query()->create([]);
            $message = $request->input('message');
            $messageObj = Message::query()->create([
                'room_id' => $room->id,
                'message' => $message,
                'sent_by_admin' => 0
            ]);
            $room->sender()->save($user);
            event(new NewRoomEvent($room, Admin::query()->first()));
        } else {
            $room = Room::with('sender')->find($request->room_id);
            $message = $request->input('message');
            $messageObj = Message::query()->create([
                'room_id' => $room->id,
                'message' => $message,
                'sent_by_admin' => 0
            ]);

        }
        event(new MessageSentEvent($messageObj));
        return response()->json(['status' => 'Message sent!']);
    }

    protected function loadChat(Request $request)
    {
        $messages = Message::query()->where('room_id', $request->room_id)->paginate(50);
        return response()->json(['messages' => $messages]);
    }
}
