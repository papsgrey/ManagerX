<?php

namespace App\Listeners;

use App\Events\CreateRouterOnUMServer;
use App\Services\MikroTikService;
use Illuminate\Support\Facades\Log;
use Exception;


class HandleCreateRouterOnUMServer
{
    protected $mikroTikService;

    public function __construct(MikroTikService $mikroTikService)
    {
        $this->mikroTikService = $mikroTikService;
    }

    public function handle(CreateRouterOnUMServer $event)
    {
        $umServer = $event->umServer;

        // Log information for debugging
        Log::info('Event triggered for UMServer: ', ['server' => $umServer->server_name]);

        // Pass the parameters in the correct order (name, shared secret, IP)
        $this->mikroTikService->addUserManagerRouter(
            $umServer->server_name,
            $umServer->password,  // Shared secret
            $umServer->ip_address
        );
    }
}
