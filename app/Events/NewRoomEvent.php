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

    public $room;

    public function __construct($room)
    {
        $this->room = $room;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("chat_room.{$this->room->sender->id}");
    }

    public function broadcastWith()
    {
        return [
            'room' => $this->room
        ];
    }
}
