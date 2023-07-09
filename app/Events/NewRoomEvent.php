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

    public $room, $admin;

    public function __construct($room, $admin)
    {
        $this->room = $room;
        $this->admin = $admin;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("chat_room.{$this->admin->id}");
    }

    public function broadcastWith()
    {
        return [
            'room' => $this->room, 'sender' => $this->room->sender
        ];
    }
    public function broadcastAs()
    {
        return 'room-create';
    }
}
