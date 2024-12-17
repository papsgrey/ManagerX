<?php

namespace App\Listeners;

use App\Events\CreateRadiusOnUMClient;
use App\Services\MikroTikService;
use Illuminate\Support\Facades\Log;

class HandleCreateRadiusOnUMClient
{
    protected $mikroTikService;

    /**
     * Create the event listener.
     *
     * @param MikroTikService $mikroTikService
     */
    public function __construct(MikroTikService $mikroTikService)
    {
        $this->mikroTikService = $mikroTikService;
    }

    /**
     * Handle the event.
     *
     * @param  CreateRadiusOnUMClient  $event
     * @return void
     */
    public function handle(CreateRadiusOnUMClient $event)
    {
        $umClient = $event->umClient;
        $umServer = $event->umServer;

        try {
            // Connect to UM Client router using MikroTik API
            if ($this->mikroTikService->connect($umClient->ip_address, $umClient->username, decrypt($umClient->password))) {
                
                // Add RADIUS server configuration to UM Client
                $this->mikroTikService->addRadiusServer(
                    $umServer->ip_address,      // RADIUS server address
                    decrypt($umServer->password),  // Shared secret
                    $umClient->ip_address      // Source address
                );

                Log::info("Successfully configured RADIUS on UM Client", [
                    'client' => $umClient->client_name,
                    'radius_server' => $umServer->ip_address
                ]);
                
                // Disconnect after configuration
                $this->mikroTikService->disconnect();
            } else {
                Log::error("Failed to connect to UM Client: " . $umClient->client_name);
            }
        } catch (\Exception $e) {
            Log::error("Failed to configure RADIUS on UM Client: " . $e->getMessage());
        }
    }
}
