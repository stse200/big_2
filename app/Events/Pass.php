<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Pass implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $player_number;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($player_number)
    {
      $this->player_number = $player_number;
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
