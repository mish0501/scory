<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EndTest implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $code;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($code)
    {
      $this->code = $code;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['testroom.'.$this->code];
    }
}
