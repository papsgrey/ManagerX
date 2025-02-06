<?php

namespace App\Http\Controllers;

use App\Models\UMClient;
use App\Models\UMServer;
use App\Services\MikroTikUMClientService;
use Illuminate\Http\Request;
use App\Events\CreateRadiusOnUMClient;
use Illuminate\Support\Facades\Log;

class UMClientController extends Controller
{
    protected $mikroTikService;

    public function __construct(MikroTikUMClientService $mikroTikService)
    {
        $this->mikroTikService = $mikroTikService;
    }

    // List all UM Clients
    public function show_list_umclient()
    {
        $umServers = UMServer::all();
        $umClients = UMClient::with('umServer')->paginate(10); 
        return view('admin.networking.ip_networking.bb_umclient', compact('umClients'));
    }

    // Show form to create a UM Client
    public function create_umclients()
    {
        $umServers = UMServer::all();
        
        return view('admin.networking.ip_networking.bb_add_umclient', compact('umServers'));
    }

    // Store a UM Client
    public function store_umclient(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'client_name' => 'required|string|max:255',
            'ip_address' => 'required|ip|unique:bb_um_clients,ip_address',
            'um_server_ip' => 'required|exists:bb_um_servers,ip_address', // Ensure this is validated
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
    
        // Retrieve the UM Server based on the provided IP address
        $umServer = UMServer::where('ip_address', $request->um_server_ip)->firstOrFail();
    
        // Check if the UM Server was found
        if (!$umServer) {
            return redirect()->back()->withErrors(['um_server_ip' => 'The selected UM Server IP does not exist.']);
        }
    
        // Create a new UMClient record
        UMClient::create([
            'client_name' => $request->client_name,
            'ip_address' => $request->ip_address,
            'um_server_id' => $umServer->id, // Store the UM server ID
            'um_server_ip_address' => $umServer->ip_address, // Store the UM server's IP address
            'username' => $request->username,
            'password' => bcrypt($request->password), 
            'encrypted_password' => encrypt($request->password), 
            'status' => 'Pending', 
        ]);
    
        // Redirect to the list of UM clients with a success message
        return redirect()->route('show_list_umclients')->with('success', 'UM Client added successfully!');
    }

    // Edit a UM Client
    public function edit_umclient($id)
    {
        $client = UMClient::findOrFail($id);
        $umServers = UMServer::all();
        return view('admin.networking.ip_networking.bb_edit_umclient', compact('client', 'umServers'));
    }

    // Update a UM Client
    public function update_umclient(Request $request, $id)
    {
        $client = UMClient::findOrFail($id);

        $request->validate([
            'client_name' => 'required|string|max:255',
            'ip_address' => 'required|ip|unique:bb_um_clients,ip_address,' . $client->id, // Exclude the current record
            'um_server_ip' => 'required|exists:bb_um_servers,ip_address',
            'username' => 'required|string|max:255',
        ]);

        $data = $request->only(['client_name', 'ip_address', 'um_server_ip', 'username']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
            $data['encrypted_password'] = encrypt($request->password);
        }

        $client->update($data);

        return redirect()->route('show_list_umclients')->with('success', 'UM Client updated successfully!');
    }

    // Delete a UM Client
    public function destroy_umclient($id)
    {
        $client = UMClient::findOrFail($id);
        $client->delete();

        return redirect()->route('show_list_umclients')->with('success', 'UM Client deleted successfully!');
    }

    // Send configuration to MikroTik for all UM Clients
    public function umclients_sendConfiguration(Request $request, MikroTikUMClientService $mikroTikService)
    {
        $clientId = $request->input('client_id');
    
        if (!$clientId) {
            return redirect()->back()->with('error', 'No client selected.');
        }
    
        $umClient = UMClient::with('umServer')->findOrFail($clientId);
    
        try {
            // Add router to the UM server
            $mikroTikService->createRadiusClientOnUMServer($umClient);
    
            // Configure RADIUS server on the UM client
            $mikroTikService->configureRadiusServerOnUMClient($umClient);
    
            // Check connectivity by pinging the UM client's IP address
            if ($this->pingIPAddress($umClient->ip_address)) {
                $umClient->update(['status' => 'Online']);
            } else {
                $umClient->update(['status' => 'Offline']);
            }
    
            return redirect()->route('show_list_umclients')->with('success', 'Configuration sent successfully.');
        } catch (\Exception $e) {
            Log::error("Error sending configuration: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send configuration: ' . $e->getMessage());
        }
    }
    
    

/**
 * Ping an IP address to check its availability.
 */
private function pingIPAddress(string $ipAddress): bool
{
    $pingResult = null;

    // Use `exec` to perform the ping command
    if (strtolower(PHP_OS) === 'winnt') {
        // For Windows, use '-n' flag for ping
        exec("ping -n 1 $ipAddress", $pingResult, $status);
    } else {
        // For Linux/Mac, use '-c' flag for ping
        exec("ping -c 1 $ipAddress", $pingResult, $status);
    }

    // Status 0 means ping was successful
    return $status === 0;
}

}
