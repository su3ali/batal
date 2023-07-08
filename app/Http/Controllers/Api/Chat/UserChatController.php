<?php

namespace App\Http\Controllers\Api\Chat;

use App\Events\MessageSentEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;

class UserChatController extends Controller
{

    protected function saveMessage(Request $request)
    {
        $room = Room::with('sender')->find($request->room_id);
        $message = $request->input('message');
        $messageObj = Message::query()->create([
            'room_id' => $room->id,
            'message' => $message,
            'sent_by_admin' => $request->sent_by_admin ?: 0
        ]);
        event(new MessageSentEvent($messageObj));

        return response()->json(['status' => 'Message sent!']);
    }
}
