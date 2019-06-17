<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rating;
    public $email;
    public $body;
    public $object_id;
    public $name;
    public $url;

    public function __construct(Request $request)
    {
        $this->rating = $request->rating;
        $this->email = $request->email;
        $this->body = $request->body;
        $this->object_id = $request->object_id;
        $room = Room::find($request->object_id);
        if (is_null($room)) {
            return false;
        }
        $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
        $this->name = $roomDetail->name;
        $this->url = route('client.rooms.detail', $request->object_id);
    }

    public function broadcastOn()
    {
        return ['room-comment'];
    }
}
