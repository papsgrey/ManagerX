<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MikroTikHSClientService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'verify' => false, // Disable SSL verification for testing
            'timeout' => 10,
        ]);
    }

    /**
     * Perform a REST API request to MikroTik.
     */
    protected function request($method, $url, $username, $password, $data = [])
    {
        try {
            $response = $this->httpClient->request($method, $url, [
                'auth' => [$username, $password],
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error("MikroTik REST API Error: " . $e->getMessage());
            if ($e->hasResponse()) {
                Log::error("Response: " . $e->getResponse()->getBody());
            }
            throw new \Exception("MikroTik REST API Error: " . $e->getMessage());
        }
    }

    /**
     * Test connection to MikroTik REST API.
     */
    public function connect($host, $username, $password)
    {
        $url = "https://$host/rest/system/resource";

        try {
            $response = $this->httpClient->get($url, [
                'auth' => [$username, $password],
            ]);

            if ($response->getStatusCode() === 200) {
                Log::info("Successfully connected to MikroTik HS Client at $host");
                return true;
            }
        } catch (\Exception $e) {
            Log::error("Failed to connect to MikroTik HS Client at $host: " . $e->getMessage());
            throw new \Exception("Failed to connect to MikroTik HS Client: " . $e->getMessage());
        }

        return false;
    }

    /**
     * Check if a RADIUS server exists on HS Client.
     */
    public function radiusServerExists($host, $username, $password, $address, $srcAddress)
    {
        $url = "https://$host/rest/radius";

        try {
            $radiusServers = $this->request('GET', $url, $username, $password);

            foreach ($radiusServers as $server) {
                if (($server['address'] ?? '') === $address && ($server['src-address'] ?? '') === $srcAddress) {
                    return true;
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to check RADIUS servers: " . $e->getMessage());
        }

        return false;
    }

    /**
     * Add RADIUS server for HS Client.
     */
    public function addRadiusServer($host, $username, $password, $address, $secret, $srcAddress)
    {
        if ($this->radiusServerExists($host, $username, $password, $address, $srcAddress)) {
            throw new \Exception("RADIUS server with this address and src-address already exists.");
        }

        $url = "https://$host/rest/radius";
        $data = [
            'service' => 'hotspot',
            'address' => $address,
            'secret' => $secret,
            'src-address' => $srcAddress,
        ];

        return $this->request('PUT', $url, $username, $password, $data);
    }

    /**
     * Fetch DHCP leases.
     */
    public function getDhcpLeases($host, $username, $password)
    {
        $url = "https://$host/rest/ip/dhcp-server/lease";
        return $this->request('GET', $url, $username, $password);
    }

    /**
     * Set up DHCP server on HS Client.
     */
    public function setupDhcpServer($host, $username, $password, $interface, $addressSpace, $gateway, $dnsServers, $leaseTime = '00:30:00')
    {
        // Add DHCP Network
        $networkUrl = "https://$host/rest/ip/dhcp-server/network";
        $networkData = [
            'address' => $addressSpace,
            'gateway' => $gateway,
            'dns-server' => $dnsServers,
            'comment' => "DHCP Network for $addressSpace",
        ];
        $this->request('PUT', $networkUrl, $username, $password, $networkData);

        // Add DHCP Server
        $serverUrl = "https://$host/rest/ip/dhcp-server";
        $serverData = [
            'name' => "dhcp_server_$interface",
            'interface' => $interface,
            'lease-time' => $leaseTime,
            'address-pool' => "dhcp_pool_$addressSpace",
        ];
        return $this->request('PUT', $serverUrl, $username, $password, $serverData);
    }

    /**
     * Check if a User Manager router exists.
     */
    public function userManagerRouterExists($host, $username, $password, $name, $ip)
    {
        $url = "https://$host/rest/user-manager/router";
        $routers = $this->request('GET', $url, $username, $password);

        foreach ($routers as $router) {
            if (($router['name'] ?? '') === $name && ($router['address'] ?? '') === $ip) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add a User Manager router for HS Client.
     */
    public function addUserManagerRouter($host, $username, $password, $name, $sharedSecret, $ip)
    {
        if ($this->userManagerRouterExists($host, $username, $password, $name, $ip)) {
            throw new \Exception("Router with this name or IP already exists in User Manager.");
        }

        $url = "https://$host/rest/user-manager/router";
        $data = [
            'name' => $name,
            'shared-secret' => $sharedSecret,
            'address' => $ip,
        ];

        return $this->request('PUT', $url, $username, $password, $data);
    }
}
