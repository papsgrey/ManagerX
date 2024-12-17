<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MikroTikPolicyEditService
{
    protected $httpClient;
    protected $baseUrl;
    protected $auth;

    public function __construct()
    {
        $this->httpClient = new Client([
            'verify' => false,
            'timeout' => 10,
        ]);
    }

    public function connect($ip, $username, $password)
    {
        $this->baseUrl = "https://$ip/rest";
        $this->auth = [$username, $password];
    }

    // Fetch Profile by ID
    public function getProfileById($id)
    {
        return $this->request('GET', "/user-manager/profile/$id");
    }

    // Update Profile
    public function updateProfile($id, $data)
    {
        return $this->request('PUT', "/user-manager/profile/$id", $data);
    }

    // Delete Profile
    public function deleteProfile($id)
    {
        return $this->request('DELETE', "/user-manager/profile/$id");
    }

    // Fetch Limit by ID
    public function getLimitById($id)
    {
        return $this->request('GET', "/user-manager/limit/$id");
    }

    // Update Limit
    public function updateLimits($id, $data)
    {
        return $this->request('PUT', "/user-manager/limit/$id", $data);
    }

    // Delete Limit
    public function deleteLimits($id)
    {
        return $this->request('DELETE', "/user-manager/limit/$id");
    }

    // Fetch Profile Limit by ID
    public function getProfileLimitById($id)
    {
        return $this->request('GET', "/user-manager/profile-limit/$id");
    }

    // Update Profile Limit
    public function updateProfileLimits($id, $data)
    {
        return $this->request('PUT', "/user-manager/profile-limit/$id", $data);
    }

    // Delete Profile Limit
    public function deleteProfileLimits($id)
    {
        return $this->request('DELETE', "/user-manager/profile-limit/$id");
    }

    // General Request Method
    protected function request($method, $endpoint, $data = [])
    {
        try {
            $response = $this->httpClient->request($method, $this->baseUrl . $endpoint, [
                'auth' => $this->auth,
                'json' => $data,
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error("MikroTik Policy Edit Service Error: " . $e->getMessage());
            throw $e;
        }
    }
}
