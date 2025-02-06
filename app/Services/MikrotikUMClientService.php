<?php

namespace App\Services;

use App\Models\UMClient;
use App\Models\UMServer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException; // Make sure this is imported
use Illuminate\Support\Facades\Log;

class MikroTikUMClientService
{
    private function handleGuzzleException(RequestException $e, string $context = '')
    {
        $logMessage = "MikroTik API Error {$context}: " . $e->getMessage();

        if ($e instanceof ClientException) { // Check if it's a ClientException
            if ($e->hasResponse()) { // THEN check if it has a response
                $response = $e->getResponse();
                $body = $response->getBody()->getContents();
                $logMessage .= " Response Body: " . $body;

                $statusCode = $response->getStatusCode();
                $logMessage .= " Status Code: " . $statusCode;

                $reasonPhrase = $response->getReasonPhrase();
                $logMessage .= " Reason Phrase: " . $reasonPhrase;
            }
        } elseif ($e instanceof ConnectException) {
            $logMessage .= " Connection Error: Could not connect to the MikroTik device.";
        }

        Log::error($logMessage);
        throw new \Exception("MikroTik API Error {$context}: " . $e->getMessage());
    }

    public function createRadiusClientOnUMServer(UMClient $client)
    {
        $server = $client->umServer;
    
        $clientGuzzle = new Client([
            'base_uri' => 'https://' . $server->ip_address . '/rest/',
            'auth' => [$server->username, decrypt($server->password)],
            'verify' => false,
            'timeout' => 5,
        ]);
    
        $data = [
            'address' => $client->ip_address,
            'name' => $client->client_name,
            'shared-secret' => decrypt($client->encrypted_password),
        ];
    
        // Log the payload for debugging
        Log::debug("Payload for Router addition: ", $data);
    
        try {
            $response = $clientGuzzle->post('/user-manager/router/add', [
                'json' => $data,
            ]);
    
            if ($response->getStatusCode() !== 200) {
                throw new \Exception("Failed to create router on UM server. HTTP Status: " . $response->getStatusCode());
            }
        } catch (RequestException $e) {
            $this->handleGuzzleException($e, 'creating Router entry on UM Server');
        }
    }
    


    public function configureRadiusServerOnUMClient(UMClient $client)
{
    $server = $client->umServer;

    $clientGuzzle = new Client([
        'base_uri' => 'https://' . $client->ip_address . '/rest/',
        'auth' => [$client->username, decrypt($client->encrypted_password)],
        'verify' => false,
        'timeout' => 5,
    ]);

    $radiusData = [
        'address' => $server->ip_address,
        'service' => 'dhcp',
        'src-address' => $client->ip_address,
    ];

    // Log the RADIUS payload
    Log::debug("Payload for RADIUS configuration: ", $radiusData);

    try {
        $response = $clientGuzzle->post('/radius', [
            'json' => $radiusData,
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Failed to configure RADIUS server. HTTP Status: " . $response->getStatusCode());
        }
    } catch (RequestException $e) {
        $this->handleGuzzleException($e, 'configuring Radius server on UM Client');
    }
}

    
}