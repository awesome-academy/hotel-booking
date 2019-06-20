<?php

namespace App\Events\Admin;

use http\Env\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Redis;

class UpdateStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
        $logs = json_decode(Redis::get('chat_log:' . $email), true);
        foreach ($logs as $key => $log) {
            $logs[$key]['status'] = 1;
        }
        Redis::getSet('chat_log:' . $email, json_encode($logs));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channel = 'update-status-' . md5($this->email);
        return [$channel];
    }
}
