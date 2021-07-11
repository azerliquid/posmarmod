<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendListOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice, $broadcast_item, $branch;

    public function __construct($invoice, $broadcast_item, $branch)
    {
        $this->invoice = $invoice;
        $this->broadcast_item = $broadcast_item;
        $this->branch = $branch;
    }

    public function broadcastOn()
    {
        return ['my-channel'.$this->branch];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}


