<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class MikroTikDhcpService
{
    protected $httpClient;
    protected $baseUrl;
    protected $auth;

    public function __construct()
    {
        $this->httpClient = new Client([
            'verify' => false, // Disable SSL verification for testing purposes
            'timeout' => 10,
        ]);
    }

    public function setCredentials($ip, $username, $password)
    {
        $this->baseUrl = "https://$ip/rest";
        $this->auth = [$username, $password];
    }

    public function createIpPool($poolName, $ranges)
    {
        $payload = [
            'name' => $poolName,
            'ranges' => $ranges,
        ];

        try {
            $response = $this->httpClient->post($this->baseUrl . '/ip/pool', [
                'auth' => $this->auth,
                'json' => $payload,
            ]);

            if ($response->getStatusCode() === 201) {
                Log::info("IP Pool '{$poolName}' created successfully.");
                return json_decode($response->getBody(), true);
            }
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            Log::error("Failed to create IP Pool: {$e->getMessage()}. Response: {$errorResponse}");
            throw new \Exception("Failed to create IP Pool: {$errorResponse}");
        }

        return false;
    }

    public function createDhcpServer($serverName, $interface, $addressPool, $leaseTime = '00:30:00')
    {
        $payload = [
            'name' => $serverName,
            'interface' => $interface,
            'address-pool' => $addressPool,
            'lease-time' => $leaseTime,
        ];

        try {
            $response = $this->httpClient->post($this->baseUrl . '/ip/dhcp-server', [
                'auth' => $this->auth,
                'json' => $payload,
            ]);

            if ($response->getStatusCode() === 201) {
                Log::info("DHCP Server '{$serverName}' created successfully.");
                return json_decode($response->getBody(), true);
            }
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            Log::error("Failed to create DHCP Server: {$e->getMessage()}. Response: {$errorResponse}");
            throw new \Exception("Failed to create DHCP Server: {$errorResponse}");
        }

        return false;
    }
}
