<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRoomEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room, $admin, $message;

    public function __construct($room, $admin, $message)
    {
        $this->room = $room;
        $this->admin = $admin;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("chat_room.{$this->room->id}");
    }

    public function broadcastWith()
    {
        return [
            'room' => $this->room, 'sender' => $this->room->sender, 'message' => $this->message
        ];
    }
    public function broadcastAs()
    {
        return 'room-create';
    }
}
