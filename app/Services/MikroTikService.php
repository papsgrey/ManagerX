<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;
use RouterOS\Exceptions\QueryException;
use Illuminate\Support\Facades\Log;


class MikroTikService
{
    protected $client;

/**
     * Connect to MikroTik router.
     */
    public function connect($host, $username, $password)
    {
        try {
            Log::info("Attempting to connect to MikroTik at $host with username $username");

            $config = new Config([
                'host' => $host,
                'user' => $username,
                'pass' => $password,
                'port' => 8728, 
                'legacy' => false // Set to `false` for RouterOS v7
            ]);

            $this->client = new Client($config);
            Log::info("Successfully connected to MikroTik at $host");

            return true;
        } catch (\Exception $e) {
            Log::error("Connection failed to MikroTik at $host: " . $e->getMessage());
            return false;
        }
    }

     /**                        
     * Check if a User Manager router with the same name or IP already exists On UMSERVER.
     */
    public function userManagerRouterExists($name, $ip)
    {
        
        try{
            $query = (new Query('/user-manager/router/print'))
                ->where('name', $name)
                ->where('address', $ip);
                   
                $existingRouter = $this->client->query($query)->read();
                                     
                   // Log the result for debugging purposes
                   Log::info("Checking for existing User Manager router", [
                       'name' => $name,
                       'ip' => $ip,
                       'result' => $existingRouter
                   ]);
           
                   return !empty($existingRouter);}
           catch (QueryException $e) {
                   Log::error('Failed to check for existing User Manager router: ' . $e->getMessage());
                   throw new \Exception('Failed to check for existing User Manager router: ' . $e->getMessage());
               }
           
    }
        /**
     * Check if RADIUS server entry with specified address and src-address already exists on HS.
     */
    public function radiusServerExistsOnHS($umServerIp, $srcAddress)
    {
        try {
            $query = new Query('/radius/print');
            $existingServers = collect($this->client->query($query)->read());

            return $existingServers->contains(function ($server) use ($umServerIp, $srcAddress) {
                return ($server['address'] ?? '') === $umServerIp &&
                       ($server['src-address'] ?? '') === $srcAddress;
            });
        } catch (\Exception $e) {
            Log::error('Failed to check existing RADIUS server: ' . $e->getMessage());
            throw new \Exception('Failed to check existing RADIUS server: ' . $e->getMessage());
        }
    }


        /**
        * Add router to User Manager on UM server.
       */
      public function addUserManagerRouter($name, $sharedSecret, $ip)
      {
          if ($this->userManagerRouterExists($name, $ip)) {
              Log::info("Router with name $name and IP $ip already exists in User Manager.");
              throw new \Exception("Router with this name or IP already exists in User Manager.");
          }
  
          try {
              $query = (new Query('/user-manager/router/add'))
                  ->equal('name', $name)
                  ->equal('shared-secret', $sharedSecret)
                  ->equal('address', $ip);
  
              Log::info("Adding router to User Manager with Name: $name, IP: $ip");
              return $this->client->query($query)->read();
          } catch (QueryException $e) {
              Log::error('Failed to add router: ' . $e->getMessage());
              throw new \Exception('Failed to add router: ' . $e->getMessage());
          }
      }
  
      /**
       * Check if a RADIUS server with the same IP and src-address already exists.
       */
      public function radiusServerExists($address, $srcAddress)
      {
          $query = (new Query('/radius/print'))
          ->where('address', $address)
          ->where('src-address', $srcAddress);
          $existingRadius = $this->client->query($query)->read();
  
          return !empty($existingRadius);
      }
  

    /**
     * Add RADIUS server on UM client.
     */
    public function addRadiusServer($umServerIp, $secret, $srcAddress)
    {
        if ($this->radiusServerExists($umServerIp, $srcAddress)) {
            Log::info("RADIUS server with IP $umServerIp and src-address $srcAddress already exists.");
            throw new \Exception("RADIUS server with this IP or src-address already exists.");
        }

        try {
            // Add the RADIUS server entry without 'incoming'
            $query = (new Query('/radius/add'))
                ->equal('service', 'hotspot')
                ->equal('address', $umServerIp)
                ->equal('secret', $secret)
                ->equal('src-address', $srcAddress);
    
            Log::info("Adding RADIUS server for Hotspot with IP: $umServerIp, Source: $srcAddress");
            $response = $this->client->query($query)->read();
            Log::info("Hotspot RADIUS server added successfully without incoming.");
    
            // Set incoming to 'accept' for the RADIUS service globally
            $incomingQuery = (new Query('/radius/incoming/set'))
                ->equal('accept', 'yes');
            
            $this->client->query($incomingQuery)->read();
            Log::info("RADIUS incoming requests enabled.");
    
            return $response;
        }  catch (QueryException $e) {
            Log::error('Failed to add RADIUS server: ' . $e->getMessage());
            throw new \Exception('Failed to add RADIUS server: ' . $e->getMessage());
        }
    }

    public function getDhcpLeases()
    {
        // Check if connected before making a query
        if (!$this->client) {
            Log::error("Attempted to query MikroTik without an active connection.");
            return collect();  // Return empty collection to handle gracefully
        }

        try {
            $query = new Query('/ip/dhcp-server/lease/print');
            $response = $this->client->query($query)->read();
            return collect($response);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve DHCP leases: " . $e->getMessage());
            return collect();  // Return empty collection on failure
        }
    }

    // Configure DHCP server on MikroTik router
    public function setupDhcpServer($interface, $addressSpace, $gateway, $addresses, $dnsServers, $leaseTime = '00:30:00')
    {
        try {
            // Set up DHCP Network
            $networkQuery = (new Query('/ip/dhcp-server/network/add'))
                ->equal('address', $addressSpace)
                ->equal('gateway', $gateway)
                ->equal('dns-server', $dnsServers)
                ->equal('comment', 'DHCP Network for ' . $addressSpace);
            $this->client->query($networkQuery)->read();
    
            Log::info('DHCP Network added successfully', [
                'address' => $addressSpace,
                'gateway' => $gateway,
                'dns-server' => $dnsServers,
            ]);
    
            // Create an Address Pool
            $poolQuery = (new Query('/ip/pool/add'))
                ->equal('name', 'dhcp_pool_' . str_replace('.', '_', $addressSpace))
                ->equal('ranges', $addresses);
            $this->client->query($poolQuery)->read();
    
            Log::info('Address Pool added successfully', [
                'name' => 'dhcp_pool_' . str_replace('.', '_', $addressSpace),
                'ranges' => $addresses,
            ]);
    
            // Add DHCP Server
            $serverQuery = (new Query('/ip/dhcp-server/add'))
                ->equal('name', 'dhcp_server_' . $interface)
                ->equal('interface', $interface)
                ->equal('lease-time', $leaseTime)
                ->equal('address-pool', 'dhcp_pool_' . str_replace('.', '_', $addressSpace));
            $this->client->query($serverQuery)->read();
    
            Log::info('DHCP Server setup successfully', [
                'interface' => $interface,
                'lease-time' => $leaseTime,
                'address-pool' => 'dhcp_pool_' . str_replace('.', '_', $addressSpace),
            ]);
    
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to set up DHCP Server: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Add RADIUS server for HS Client.
     */
    public function addRadiusServerForHotspot($umServerIp, $secret, $srcAddress)
    {
        try {
            // Add the RADIUS server entry without 'incoming'
            $query = (new Query('/radius/add'))
                ->equal('service', 'hotspot')
                ->equal('address', $umServerIp)
                ->equal('secret', $secret)
                ->equal('src-address', $srcAddress);
    
            Log::info("Adding RADIUS server for Hotspot with IP: $umServerIp, Source: $srcAddress");
            $response = $this->client->query($query)->read();
            Log::info("Hotspot RADIUS server added successfully without incoming.");
    
            // Set incoming to 'accept' for the RADIUS service globally
            $incomingQuery = (new Query('/radius/incoming/set'))
                ->equal('accept', 'yes');
            
            $this->client->query($incomingQuery)->read();
            Log::info("RADIUS incoming requests enabled.");
    
            return $response;
        } catch (\Exception $e) {
            Log::error('Failed to add RADIUS server for Hotspot or enable incoming requests: ' . $e->getMessage());
            throw new \Exception('Failed to add RADIUS server for Hotspot or enable incoming requests: ' . $e->getMessage());
        }
    }
    

    /**
     * Check if User Manager router entry with specified name and IP already exists.
     */
    public function userManagerRouterExistsOnHS($name, $ip)
    {
        try {
            $query = new Query('/tool/user-manager/router/print');
            $existingRouters = collect($this->client->query($query)->read());
    
            return $existingRouters->contains(function ($router) use ($name, $ip) {
                return ($router['name'] ?? '') === $name &&
                       ($router['ip-address'] ?? '') === $ip;
            });
        } catch (\Exception $e) {
            Log::error('Failed to check existing User Manager router for HS Client: ' . $e->getMessage());
            throw new \Exception('Failed to check existing User Manager router for HS Client: ' . $e->getMessage());
        }
    }
    


    /**
     * Add router to User Manager on HS Client.
     */
    public function addUserManagerRouterForHS($name, $sharedSecret, $ip)
    {
        // Check if the router already exists
        if ($this->userManagerRouterExistsOnHS($name, $ip)) {
            Log::info("Router with name $name and IP $ip already exists in User Manager for HS Client.");
            throw new \Exception("Router with this name or IP already exists in User Manager for HS Client.");
        }
    
        try {
            $query = (new Query('/tool/user-manager/router/add'))
                ->equal('name', $name)
                ->equal('shared-secret', $sharedSecret)
                ->equal('ip-address', $ip);
    
            Log::info("Adding router to User Manager for HS Client with Name: $name, IP: $ip");
            $response = $this->client->query($query)->read();
            Log::info("Router added successfully to User Manager for HS Client");
    
            return $response;
        } catch (\Exception $e) {
            Log::error('Failed to add router to User Manager for HS Client: ' . $e->getMessage());
            throw new \Exception('Failed to add router to User Manager for HS Client: ' . $e->getMessage());
        }
    }
    

    //Fetches comprehensive details to display in the  profile tab
    public function getProfiles($ip, $username, $password)
    {
        try {
            if ($this->connect($ip, $username, $password)) {
                $query = new Query('/user-manager/profile/print'); // Ensure this is the correct path
                $profiles = $this->client->query($query)->read();
    
                return array_map(function ($profile) {
                    return [
                        'name' => $profile['name'] ?? 'N/A', // Name of the profile
                        'validity' => $profile['validity'] ?? 'N/A', // Validity period
                        'name-of-users' => $profile['name-for-users'] ?? 'N/A', // Name of users
                        'start-when' => $profile['starts-when'] ?? 'N/A', // Start when condition
                        'price' => $profile['price'] ?? 'N/A', // Price
                        'override-shared-users' => $profile['override-shared-users'] ?? 'N/A', // Override share
                    ];
                }, $profiles);
            }
            throw new \Exception("Failed to connect to UM server");
        } catch (\Exception $e) {
            Log::error('Error retrieving UM profiles: ' . $e->getMessage());
            return [];
        }
    }

    //Fetches comprehensive details to display in the  profile tab
    public function getUMProfiles($ip, $username, $password)
    {
    try {
        // Connect to the UM server
        if (!$this->connect($ip, $username, $password)) {
            throw new \Exception('Failed to connect to UM server.');
        }

        // Execute query to fetch profiles
        $query = new Query('/user-manager/profile/print');
        $profiles = $this->client->query($query)->read();

        // Return only the names of the profiles
        return array_map(function ($profile) {
            return [
                'name' => $profile['name'] ?? 'N/A', // Return only the profile name
            ];
        }, $profiles);
    } catch (\Exception $e) {
        Log::error('Error fetching profiles: ' . $e->getMessage());
        return [];
    }
    }


    public function getUMLimits($ip, $username, $password)
    {
    try {
        if ($this ->connect($ip, $username, $password)) {
            $query = new Query('/user-manager/limitation/print'); // Ensure this is the correct path
            $limits = $this->client->query($query)->read();

            return array_map(function ($limit) {
                return [
                    'name' => $limit['name'] ?? 'N/A', // Name of the limit
                    'transfer_limit' => $limit['transfer-limit'] ?? 'N/A', // Transfer limit
                    'uptime_limit' => $limit['uptime-limit'] ?? 'N/A', // Uptime limit
                    'rate_limit_rx' => $limit['rate-limit-rx'] ?? 'N/A', // Rate limit RX
                    'rate_limit_tx' => $limit['rate-limit-tx'] ?? 'N/A', // Rate limit TX
                ];
            }, $limits);
        }
        throw new \Exception("Failed to connect to UM server");
    } catch (\Exception $e) {
        Log::error('Error retrieving UM limits: ' . $e->getMessage());
        return [];
    }
}

public function getUMProfileLimits($ip, $username, $password)
{
    // Log the start of the method execution
    Log::info("Starting getUMProfileLimits method for IP: $ip");

    try {
        // Attempt to connect to the UM server
        Log::info("Attempting to connect to UM Server at IP: $ip with username: $username");
        
        if ($this->connect($ip, $username, $password)) {
            Log::info("Successfully connected to UM Server at IP: $ip");

            // Prepare the query to fetch profile limits
            $query = new Query('/user-manager/profile-limitation/print'); // Updated path to match the sample
            Log::info("Executing query to fetch profile limits.");

            // Execute the query and read the results
            $profileLimits = $this->client->query($query)->read();

            // Log the number of profile limits retrieved
            Log::info("Retrieved " . count($profileLimits) . " profile limits from UM Server at IP: $ip");

            // Map the results to the desired format
            return array_map(function ($limit) {
                return [
                    'name' => $limit['name'] ?? 'N/A', // Name of the limit
                    'profile' => $limit['profile'] ?? 'N/A', // Transfer limit
                    'limitation' => $limit['limitation'] ?? 'N/A', // Uptime limit
                ];
            }, $profileLimits);
        }

        // Log a failure to connect
        Log::error("Failed to connect to UM server at IP: $ip");
        throw new \Exception("Failed to connect to UM server");
    } catch (\Exception $e) {
        // Log the exception message
        Log::error('Error retrieving UM profile limits: ' . $e->getMessage());
        return [];
    } finally {
        // Log the end of the method execution
        Log::info("Completed getUMProfileLimits method for IP: $ip");
    }
}

public function createLimit($ip, $username, $password, $data)
{
    try {
        // Connect to the UM Server
        if (!$this->connect($ip, $username, $password)) {
            throw new \Exception("Failed to connect to UM Server at $ip.");
        }

        // Prepare the query to add the limit
        $query = (new Query('/user-manager/limitation/add'))
            ->equal('name', $data['name'])
            ->equal('transfer-limit', $data['transfer_limit'] ?? '0B')
            ->equal('uptime-limit', $data['uptime_limit'] ?? '0s')
            ->equal('rate-limit-rx', $data['rate_limit_rx'] ?? '0B')
            ->equal('rate-limit-tx', $data['rate_limit_tx'] ?? '0B')
            ->equal('rate-limit-priority', $data['rate_priority'] ?? 0);

        // Execute the query
        $response = $this->client->query($query)->read();

        Log::info("Created limit '{$data['name']}' on UM Server at $ip.", ['response' => $response]);

        return $response;
    } catch (\Exception $e) {
        Log::error('Failed to create limit on UM Server: ' . $e->getMessage());
        throw $e;
    }
}
    
public function createProfile($ip, $username, $password, $data)
{
    try {
        // Connect to the MikroTik server
        if ($this->connect($ip, $username, $password)) {
            Log::info("Connected to MikroTik at {$ip} to create profile.");

            // Prepare the query to add a profile for RouterOS 7
            $query = (new Query('/user-manager/profile/add'))
                ->equal('name', $data['name'])
                ->equal('name-for-users', $data['name_for_users'] ?? $data['name'])
                ->equal('validity', $data['validity'] ?? '1d')
                ->equal('starts-when', $data['starts_when'] ?? 'first-auth')
                ->equal('price', $data['price'] ?? '0')
                ->equal('override-shared-users', $data['override_shared_users'] ?? 'off');

            // Log the query being sent
            Log::info('Profile creation query:', $query->getAttributes());

            // Execute the query and log the response
            $response = $this->client->query($query)->read();
            Log::info('Profile creation response:', $response);

            return $response;
        }

        throw new \Exception('Failed to connect to MikroTik.');
    } catch (\Exception $e) {
        // Log the error message
        Log::error('Error creating profile: ' . $e->getMessage());
        throw $e;
    }
}


public function createProfileLimitation($ip, $username, $password, $profile, $limitation)
{
    if ($this->connect($ip, $username, $password)) {
        $query = (new Query('/user-manager/profile-limitation/add'))
            ->equal('profile', $profile)
            ->equal('limitation', $limitation);

        return $this->client->query($query)->read();
    }

    throw new \Exception('Failed to connect to UM server.');
}

//Fetches comprehensive details to display in the  limits tab
public function getLimitations($ip, $username, $password)
{
    try {
        // Connect to the UM server
        if (!$this->connect($ip, $username, $password)) {
            throw new \Exception('Failed to connect to UM server.');
        }

        // Execute query to fetch limitations
        $query = new Query('/user-manager/limitation/print');
        $limitations = $this->client->query($query)->read();

        // Map and format limitations
        return array_map(function ($limitation) {
            return [
                'name' => $limitation['name'] ?? 'N/A',
                'transfer_limit' => $limitation['transfer-limit'] ?? 'N/A',
                'uptime_limit' => $limitation['uptime-limit'] ?? 'N/A',
                'rate_limit_rx' => $limitation['rate-limit-rx'] ?? 'N/A',
                'rate_limit_tx' => $limitation['rate-limit-tx'] ?? 'N/A',
            ];
        }, $limitations);
    } catch (\Exception $e) {
        Log::error('Error fetching limitations: ' . $e->getMessage());
        return [];
    }
}

//Fetches just the name of the limits to populate in Profilelimit creation
public function getUMLimitations($ip, $username, $password)
{
    try {
        if ($this->connect($ip, $username, $password)) {
            $query = new Query('/user-manager/limitation/print');
            $limitations = $this->client->query($query)->read();

            return array_map(function ($limitation) {
                return [
                    'name' => $limitation['name'] ?? 'N/A',
                ];
            }, $limitations);
        }
        throw new \Exception('Failed to connect to UM server.');
    } catch (\Exception $e) {
        Log::error('Error retrieving UM limitations: ' . $e->getMessage());
        return [];
    }
}



}
