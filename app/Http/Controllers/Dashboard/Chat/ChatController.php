<?php

namespace App\Http\Controllers\Dashboard\Chat;

use App\Events\MessageSentEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Room;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;
use Pusher\Pusher;

class ChatController extends Controller
{
    protected function index()
    {
        $rooms = Room::with('messages')->get();
        $users = User::select(['id', 'first_name', 'last_name', 'phone'])->get();
        $techs = Technician::select(['id', 'name', 'phone', 'image'])->get();
        return view('dashboard.chat.index', compact('rooms', 'users', 'techs'));
    }
    protected function saveMessage(Request $request)
    {
        $room = Room::with('sender')->find($request->room);
        $message = $request->input('message');
        $messageObj = Message::query()->create([
            'room_id' => $room->id,
            'message' => $message,
            'sent_by_admin' => $request->sent_by_admin
        ]);
        event(new MessageSentEvent($messageObj));

        return response()->json(['status' => 'Message sent!']);
    }

    protected function loadChat(Request $request)
    {
        $room = Room::query()->with('messages')->with('sender')->where('id', $request->room_id)->first();
        return response()->json($room);
    }


    protected function testView(Request $request)
    {
        $rooms = Room::with('messages')->get();
        $users = User::select(['id', 'first_name', 'last_name', 'phone'])->get();
        $techs = Technician::select(['id', 'name', 'phone', 'image'])->get();
        return view('dashboard.chat.test', compact('rooms', 'users', 'techs'));
    }

}
