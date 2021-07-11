<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendInformation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice, $branch;

    public function __construct($invoice, $branch)
    {
        $this->invoice = $invoice;
        $this->branch = $branch;
    }

    public function broadcastOn()
    {
        return ['my-queue-events'.$this->branch];
    }

    public function broadcastAs()
    {
        return 'my-queue';
    }
}
