<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifFinishedOrder implements ShouldBroadcast
{ 
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id_invoice, $branch;

    public function __construct($id_invoice, $branch)
    {
        $this->id_invoice = $id_invoice;
        $this->branch = $branch;
    }

    public function broadcastOn()
    {
        return ['my-queue-update'.$this->branch];
    }

    public function broadcastAs()
    {
        return 'my-queue-update';
    }
}
