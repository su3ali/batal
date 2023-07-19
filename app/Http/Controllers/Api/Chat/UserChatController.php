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
use Illuminate\Support\Str;

class UserChatController extends Controller
{
    protected function myRooms()
    {
        if (auth()->user()->room) {
            return response()->json(['messages' => auth()->user()->room->messages->take(50), 'room_id' => auth()->user()->room->id]);
        } else {
            return response()->json([]);
        }
    }

    protected function saveMessage(Request $request)
    {
        $user = auth()->user();
        $room = Room::with('sender')->find($request->room_id);
        if (!$request->room_id || !$room) {
            if (class_basename(get_class($user)) == 'User') {
                $room = Room::query()->where('sender_id', $user->id)
                    ->where('sender_type', 'App\\Models\\User')->first();
            } else {
                $room = Room::query()->where('sender_id', $user->id)
                    ->where('sender_type', 'App\\Models\\Technician')->first();
            }
            if (!$room) {
                $room = Room::query()->create([
                    'sender_id' => $user->id,
                    'sender_type' => 'App\\Models\\' . class_basename(get_class($user))
                ]);
            }
            $message = $request->input('message');
            $messageObj = Message::query()->create([
                'room_id' => $room->id,
                'message' => $message,
                'sent_by_admin' => 0
            ]);
            event(new NewRoomEvent($room, Admin::query()->first(), $messageObj));
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
        return response()->json(['status' => 'Message sent!', 'room_id' => $room->id]);
    }

    protected function loadChat(Request $request)
    {
        $messages = Message::query()->where('room_id', auth()->user()->room->id)->orderBy('id','DESC')->paginate(50);
        return response()->json(['messages' => $messages, 'room_id' => auth()->user()->room->id ?? null]);
    }
}
