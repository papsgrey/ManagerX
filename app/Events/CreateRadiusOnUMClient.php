<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\UMServer;
use App\Models\UMClient;

class CreateRadiusOnUMClient
{
    use Dispatchable, SerializesModels;

    public $umServer;
    public $umClient;

    /**
     * Create a new event instance.
     *
     * @param UMServer $umServer
     * @param UMClient $umClient
     */
    public function __construct(UMServer $umServer, UMClient $umClient)
    {
        $this->umServer = $umServer;
        $this->umClient = $umClient;
    }
}
