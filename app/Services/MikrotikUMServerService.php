<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MikroTikUMServerService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10.0, // Set a timeout for API requests
        ]);
    }

    /**
     * Validate UM server credentials via MikroTik API.
     */
    public function validateServer($ip, $username, $password)
    {
        try {
            $response = $this->client->post("http://$ip/rest/login", [
                'auth' => [$username, $password],
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Invalid server credentials or server unreachable.');
            }

            return true;
        } catch (RequestException $e) {
            throw new \Exception('Failed to connect to the MikroTik server: ' . $e->getMessage());
        }
    }
}
    