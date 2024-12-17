<?php

namespace App\Http\Controllers;

use App\Models\UMClient;
use App\Services\MikroTikService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;


class DhcpController extends Controller
{
    protected $mikroTikService;

    public function __construct(MikroTikService $mikroTikService)
    {
        $this->mikroTikService = $mikroTikService;
    }

    /**
     * Show the list of DHCP clients (UM Clients).
     */
    public function showDhcpList()
    {
        $clients = UMClient::all();

        
        return view('admin.networking.dhcp_server.dhcp_list', compact('clients'));
    }

    /**
     * Show the DHCP leases for a specific UM Client.
     */
    public function showDhcpLease($id)
    {
        // Retrieve the client and connect to it
        $client = UMClient::findOrFail($id);
        $this->mikroTikService->connect($client->ip_address, $client->username, decrypt($client->encrypted_password));
    
        // Get DHCP leases
        $leases = $this->mikroTikService->getDhcpLeases();
    
        // Convert the collection to a paginated instance
        $perPage = 20;
        $page = request()->get('page', 1); // Get the current page or default to 1
        $offset = ($page - 1) * $perPage;
        
        // Manually paginate the collection
        $paginatedLeases = new LengthAwarePaginator(
            $leases->slice($offset, $perPage)->values(), // Get items for current page
            $leases->count(), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => request()->url(), 'query' => request()->query()] // Maintain query parameters
        );
    
        // Pass the paginated leases to the view
        return view('admin.networking.dhcp_server.dhcp_lease', compact('paginatedLeases', 'client'));
    }

    public function showAddDhcpServer()
    {
        // Fetch all UM Clients to show in the dropdown
        $clients = UMClient::all();
        return view('admin.networking.dhcp_server.dhcp_addserver', compact('clients'));
    }
    

    // Store DHCP server configuration and send to selected UM Client
    public function storeDhcpServer(Request $request)
    {
        $request->validate([
            'um_client_id' => 'required|exists:bb_um_clients,id',
            'server_name' => 'required|string',
            'interface' => 'required|string',
            'address_space' => 'required|string',
            'gateway' => 'required|ip',
            'addresses' => 'required|string',
            'dns_servers' => 'required|string',
            'lease_time' => 'nullable|string', // Optional, default will be used if not provided
        ]);
    
        $client = UMClient::find($request->um_client_id);
    
        try {
            $password = decrypt($client->encrypted_password);
    
            // Attempt to connect to the UM Client MikroTik
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
                    Log::info("DHCP Server configured successfully on UM Client: {$client->client_name}");
                    return redirect()->route('dhcp_list')->with('success', 'DHCP Server Processed successfully.');
                } else {
                    Log::error("Failed to configure DHCP Server on UM Client: {$client->client_name}");
                    return redirect()->back()->with('error', 'Failed to configure DHCP Server.')->withInput();
                }
            } else {
                throw new \Exception("Failed to connect to UM Client: {$client->client_name}");
            }
        } catch (\Exception $e) {
            Log::error("Error configuring DHCP Server: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to configure DHCP Server: ' . $e->getMessage())->withInput();
        }
    }
    
}

