<?php

namespace App\Services;

use App\Models\UMClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class MikroTikUMClientService
{
    // Send configuration for a specific UM Client
    public function sendConfiguration(UMClient $client)
    {
        try {
            $httpClient = new Client(['base_uri' => "http://{$client->um_server_ip}"]);
            $response = $httpClient->post('/api/configure-client', [
                'form_params' => [
                    'username' => $client->username,
                    'password' => decrypt($client->encrypted_password),
                    'ip' => $client->ip_address,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $client->update(['status' => 'Online']);
            } else {
                throw new \Exception('Configuration failed. Server returned an error.');
            }
        } catch (RequestException $e) {
            Log::error("Failed to configure UM Client [{$client->client_name}]: {$e->getMessage()}");
            throw new \Exception("Failed to configure UM Client: {$e->getMessage()}");
        }
    }
}
