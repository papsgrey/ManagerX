<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MikroTikPolicyService
{
    protected $restApiClient;

    public function __construct()
    {
        $this->restApiClient = new Client([
            'timeout' => 10.0,
            'verify' => false, // Disable SSL verification for self-signed certs
        ]);
    }

    public function setCredentials($ip, $username, $password)
    {
        $this->restApiClient = new Client([
            'base_uri' => "https://$ip/rest/",
            'auth' => [$username, $password],
            'verify' => false,
        ]);
    }

    /**
     * Fetch Profile by ID.
     */
    public function getProfileById($id)
    {
        try {
            $response = $this->restApiClient->get("user-manager/profile/$id");
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error("Failed to fetch profile: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete Profile by ID.
     */
    public function deleteProfile($id)
    {
        try {
            $this->restApiClient->delete("user-manager/profile/$id");
            Log::info("Profile $id deleted successfully.");
        } catch (\Exception $e) {
            Log::error("Failed to delete profile: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch Limit by ID.
     */
    public function getLimitById($id)
    {
        try {
            $response = $this->restApiClient->get("user-manager/limit/$id");
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error("Failed to fetch limit: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete Limit by ID.
     */
    public function deleteLimit($id)
    {
        try {
            $this->restApiClient->delete("user-manager/limit/$id");
            Log::info("Limit $id deleted successfully.");
        } catch (\Exception $e) {
            Log::error("Failed to delete limit: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch Profile Limit by ID.
     */
    public function getProfileLimitById($id)
    {
        try {
            $response = $this->restApiClient->get("user-manager/profile-limit/$id");
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error("Failed to fetch profile limit: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete Profile Limit by ID.
     */
    public function deleteProfileLimit($id)
    {
        try {
            $this->restApiClient->delete("user-manager/profile-limit/$id");
            Log::info("Profile Limit $id deleted successfully.");
        } catch (\Exception $e) {
            Log::error("Failed to delete profile limit: " . $e->getMessage());
            throw $e;
        }
    }
}
