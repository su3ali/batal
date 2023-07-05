<?php

namespace App\Http\Controllers\Dashboard\Chat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Room;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected function index()
    {
        $admin = auth()->user();
        $rooms = Room::with('messages')->where('sender_one_type', 'admin')
            ->orWhere('sender_two_type', 'admin')->pluck('id')->toArray();
        $rooms = Room::query()->withCount(['messages as latest_message_created_at' => function ($query) {
            $query->select('created_at')
                ->latest()
                ->take(1);
        }])->whereIntegerInRaw('id', $rooms)->where('sender_one', $admin->id)
            ->orWhere('sender_two', $admin->id)
            ->orderBy('latest_message_created_at', 'desc')
            ->get();
        $users = User::select(['id', 'first_name', 'last_name', 'phone'])->get();
        $techs = Technician::select(['id', 'name', 'phone', 'image'])->get();
        return view('dashboard.chat.index', compact('rooms', 'users', 'techs'));
    }

    protected function saveMessage(Request $request)
    {
        $sender = auth()->user();
        $room = Room::query()->find($request->room);
        if ($room->sender_one_type == 'admin'){
            if ($room->sender_two_type == 'user'){
                $receiverId = User::query()->find($room->sender_two)->id;
                $receiverType = 'user';
            }else{
                $receiverId = Technician::query()->find($room->sender_two)->id;
                $receiverType = 'tech';
            }
        }else{
            if ($room->sender_ono_type == 'user'){
                $receiverId = User::query()->find($room->sender_one)->id;
                $receiverType = 'user';
            }else{
                $receiverId = Technician::query()->find($room->sender_one)->id;
                $receiverType = 'tech';
            }
        }
        $message = $request->input('message');
        $messageObj = Message::query()->create([
            'room_id' => $room->id,
            'sender' => $sender->id,
            'sender_type' => 'admin',
            'receiver' => $receiverId,
            'receiver_type' => $receiverType,
            'message' => $request->get('message'),
        ]);
        event(new MessageSent($messageObj, $sender));

        return response()->json(['status' => 'Message sent!']);
    }

    protected function loadChat(Request $request)
    {
        $room = Room::query()->with('messages')->where('id', $request->room_id)->first();
        return response()->json($room);
    }
}
