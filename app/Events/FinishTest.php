<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FinishTest implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $name;
    public $code;
    public $number;
    public $correct;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
      $this->name=$data['name'];
      $this->code=$data['code'];
      $this->number=$data['number'];
      $this->correct=$data['correct'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('testroom.'.$this->code);
    }
}
