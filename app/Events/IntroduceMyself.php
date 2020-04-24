<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IntroduceMyself implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $my_number;
    public $my_name;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($my_number, $my_name)
    {
        $this->my_number = $my_number;
        $this->my_name = $my_name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('table');
    }
}
