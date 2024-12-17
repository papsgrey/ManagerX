<?php

namespace App\Http\Controllers;

use App\Models\HSClient;
use App\Models\UMServer;
use App\Services\MikroTikService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class HSClientController extends Controller
{
    protected $mikroTikService;

    public function __construct(MikroTikService $mikroTikService)
    {
        $this->mikroTikService = $mikroTikService;
    }

    // Display list of HS Clients
    public function showHSClients()
    {
        $this->pingAndUpdateHSClientStatus();
            
        $hsClients = HSClient::all();// Retrieve all HS Clients from the database

        // Pass the HS Clients data to the view
        return view('admin.networking.ip_networking.hs_client', compact('hsClients'));
    }

    // Show add HS Client form
    public function addHSClient()
    {
        // Fetch all UM Servers for the dropdown
        $umServers = UMServer::all();
        
        // Pass to the view
        return view('admin.networking.ip_networking.hs_add_client', compact('umServers'));
    }

    // Store HS Client in the database
    public function storeHSClient(Request $request)
    {
        $request->validate([
            'hs_name' => 'required|string|max:255|unique:hs_clients',
            'ip_address' => 'required|ip|unique:hs_clients',
            'um_server' => 'required|string',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        HSClient::create([
            'hs_name' => $request->hs_name,
            'ip_address' => $request->ip_address,
            'um_server' => $request->um_server,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'encrypted_password' => encrypt($request->password),
        ]);

        return redirect()->route('hs_client')->with('success', 'HS Client added successfully');
    }

    // Configure RADIUS on HS Client Router

    public function sendConfiguration()
    {
        $hsClients = HSClient::all();
    
        foreach ($hsClients as $client) {
            try {
                // Retrieve decrypted password for the HS Client
                $password = decrypt($client->encrypted_password);
    
                // 1. Configure RADIUS on the HS Client Router if it doesn't already exist
                if ($this->mikroTikService->connect($client->ip_address, $client->username, $password)) {
                    if (!$this->mikroTikService->radiusServerExistsOnHS($client->um_server, $client->ip_address)) {
                        $this->mikroTikService->addRadiusServerForHotspot(
                            $client->um_server,
                            $password,
                            $client->ip_address
                        );
                        Log::info("RADIUS server configuration successful for HS Client: {$client->hs_name}");
                    } else {
                        Log::info("RADIUS server for {$client->hs_name} already exists. Skipping configuration.");
                    }
    
                    // 2. Configure User Manager on the UM Server if it doesn't already exist
                    $umServer = UMServer::where('ip_address', $client->um_server)->first();
                    if ($umServer) {
                        $umServerPassword = decrypt($umServer->encrypted_password);
    
                        // Connect to UM Server and configure User Manager
                        if ($this->mikroTikService->connect($umServer->ip_address, $umServer->username, $umServerPassword)) {
                            if (!$this->mikroTikService->userManagerRouterExists($client->hs_name, $client->ip_address)) {
                                $this->mikroTikService->addUserManagerRouter(
                                    $client->hs_name,
                                    $password,
                                    $client->ip_address
                                );
                                Log::info("User Manager router configuration successful for HS Client: {$client->hs_name} on UM Server: {$umServer->server_name}");
                            } else {
                                Log::info("User Manager router for {$client->hs_name} already exists on UM Server. Skipping configuration.");
                            }
                        } else {
                            Log::warning("Failed to connect to UM Server: {$umServer->server_name} for User Manager configuration.");
                        }
                    } else {
                        Log::warning("UM Server with IP {$client->um_server} not found for HS Client: {$client->hs_name}");
                    }
                } else {
                    Log::warning("Failed to connect to HS Client: {$client->hs_name} for RADIUS configuration.");
                }
            } catch (\Exception $e) {
                Log::error("Error configuring HS Client: {$client->hs_name}. " . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to send configuration for one or more HS Clients.');
            }
        }
    
        return redirect()->back()->with('success', 'Configuration Process Completed!');
    }
    

    public function editHSClient($id)
{
    $hsClient = HSClient::findOrFail($id);
    $umServers = UMServer::all();

    return view('admin.networking.ip_networking.hs_edit_client', compact('hsClient', 'umServers'));
}

public function updateHSClient(Request $request, $id)
{
    $request->validate([
        'hs_name' => 'required|string|max:255',
        'ip_address' => 'required|ip',
        'username' => 'required|string|max:255',
    ]);

    $hsClient = HSClient::findOrFail($id);
    $hsClient->update([
        'hs_name' => $request->hs_name,
        'ip_address' => $request->ip_address,
        'username' => $request->username,
        'password' => $request->password ? bcrypt($request->password) : $hsClient->password,
        'encrypted_password' => $request->password ? encrypt($request->password) : $hsClient->encrypted_password,
    ]);

    return redirect()->route('hs_client')->with('success', 'HS Client updated successfully.');
}

public function deleteHSClient($id)
{
    $hsClient = HSClient::findOrFail($id);
    $hsClient->delete();

    return redirect()->route('hs_client')->with('success', 'HS Client deleted successfully.');
}

public function pingAndUpdateHSClientStatus()
{
    $hsClients = HSClient::all();

    foreach ($hsClients as $client) {
        $ip = $client->ip_address;

        // Execute ping and capture both output and status
        $output = [];
        $status = null;
        exec(PHP_OS_FAMILY === 'Windows' ? "ping -n 1 $ip" : "ping -c 1 $ip", $output, $status);

        // Check for specific keywords in the output that indicate the host is unreachable
        $isUnreachable = false;
        foreach ($output as $line) {
            if (stripos($line, 'unreachable') !== false) {
                $isUnreachable = true;
                break;
            }
        }

        // Set the client status: online if successful and no 'unreachable' message, otherwise offline
        $client->status = ($status === 0 && !$isUnreachable) ? 'Online' : 'Offline';
        $client->save();

        // Log the status update for debugging
        Log::info("HS Client {$client->hs_name} with IP {$client->ip_address} is " . ($client->status));
    }
}

    public function showAddHSDhcpServer()
    {
        
        $hsClients = HSClient::all(); // Fetch all HS Clients to populate the dropdown
        $hsClients = HSClient::all(); // Fetching HS Clients for dropdown if needed
        return view('admin.networking.ip_networking.hs_dhcp_addserver', compact('hsClients'));
    }



    public function showHSDHCPList()
    {
        // Fetch HS clients from the database
        $hsClients = HSClient::all();

        // Pass data to the view
        return view('admin.networking.dhcp_server.hs_dhcp_list', compact('hsClients'));
    }

    public function storeHSDhcpServer(Request $request)
{
    $request->validate([
        'hs_client_id' => 'required|exists:hs_clients,id',
        'server_name' => 'required|string',
        'interface' => 'required|string',
        'address_space' => 'required|string',
        'gateway' => 'required|ip',
        'addresses' => 'required|string',
        'dns_servers' => 'required|string',
        'lease_time' => 'nullable|string', // Optional, default will be used if not provided
    ]);

    // Retrieve the HS Client based on the selected client ID
    $client = HSClient::find($request->hs_client_id);

    try {
        // Decrypt the HS Client password for MikroTik connection
        $password = decrypt($client->encrypted_password);

        // Attempt to connect to the HS Client MikroTik
        if ($this->mikroTikService->connect($client->ip_address, $client->username, $password)) {

            // Call the setupDhcpServer method to configure DHCP server
            $result = $this->mikroTikService->setupDhcpServer(
                $request->interface,
                $request->address_space,
                $request->gateway,
                $request->addresses,
                $request->dns_servers,
                $request->lease_time ?? '00:30:00' // Default lease time if not provided
            );

            if ($result) {
                Log::info("DHCP Server configured successfully on HS Client: {$client->hs_name}");
                return redirect()->route('hs_dhcp_list')->with('success', 'DHCP Server Processed successfully.');
            } else {
                Log::error("Failed to configure DHCP Server on HS Client: {$client->hs_name}");
                return redirect()->back()->with('error', 'Failed to configure DHCP Server.')->withInput();
            }
        } else {
            throw new \Exception("Failed to connect to HS Client: {$client->hs_name}");
        }
    } catch (\Exception $e) {
        Log::error("Error configuring DHCP Server: " . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to configure DHCP Server: ' . $e->getMessage())->withInput();
    }
}

public function showHSDhcpLease($id)
{
    $client = HSClient::findOrFail($id); // Find the HS Client by ID

    // Connect to the MikroTik router
    if ($this->mikroTikService->connect($client->ip_address, $client->username, decrypt($client->encrypted_password))) {
        
        // Get DHCP leases from the MikroTik router
        $leases = $this->mikroTikService->getDhcpLeases();

        // Paginate the leases if necessary
        $perPage = 20;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;

        $paginatedLeases = new LengthAwarePaginator(
            $leases->slice($offset, $perPage)->values(),
            $leases->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Return view with paginated leases
        return view('admin.networking.dhcp_server.hs_dhcp_lease', compact('paginatedLeases', 'client'));
    } else {
        return redirect()->back()->with('error', 'Failed to connect to HS Client router.');
    }
}


}
