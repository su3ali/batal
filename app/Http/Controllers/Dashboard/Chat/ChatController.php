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


    protected function searchChat(Request $request)
    {
        $customers = [];
        $technicians = [];
        if ($request->search != '') {

            $search = $request->search;
            $customers = User::where('email', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('first_name', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%")
                ->get();

            $technicians = Technician::where('email', 'LIKE', "%$search%")
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%")
                ->get();

        }else{
            $customers = User::get();
            $technicians = Technician::get();
        }
        $data = [
            'users' => $customers,
            'technicians' => $technicians,
        ];

        return response()->json($data);
    }

}
