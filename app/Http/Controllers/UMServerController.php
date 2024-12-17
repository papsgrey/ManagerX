<?php

namespace App\Http\Controllers;

use App\Models\UMServer;
use App\Services\MikroTikUMServerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UMServerController extends Controller
{
    protected $mikroTikService;

    // Inject the MikroTik service
    public function __construct(MikroTikUMServerService $mikroTikService)
    {
        $this->mikroTikService = $mikroTikService;
    }

    /**
     * Display the list of UM servers.
     */
    public function show_list_umservers()
    {
        $servers = UMServer::all();
        return view('admin.networking.ip_networking.bb_umserver', compact('servers'));
    }

    /**
     * Show the form for creating a new UM server.
     */
    public function create_umserver()
    {
        return view('admin.networking.ip_networking.bb_add_umserver');
    }

    /**
     * Store a newly created UM server in the database and validate with MikroTik API.
     */
    public function store_umservers(Request $request)
    {
        $request->validate([
            'server_name' => 'required|string|max:255|unique:bb_um_servers,server_name',
            'ip_address' => 'required|ip|unique:bb_um_servers,ip_address',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            // Determine the status by pinging the server IP
            $status = $this->pingIPAddress($request->ip_address) ? 'Online' : 'Offline';

            // Create the UMServer record
            UMServer::create([
                'server_name' => $request->server_name,
                'ip_address' => $request->ip_address,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'encrypted_password' => encrypt($request->password),
                'status' => $status,
            ]);

            return redirect()->route('show_list_umservers')->with('success', 'UM Server added successfully!');
        } catch (\Exception $e) {
            Log::error("Failed to add UM Server: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Failed to add UM Server. Please try again.');
        }
    }

    /**
     * Show the form for editing an existing UM server.
     */
    public function edit_umservers($id)
    {
        $server = UMServer::findOrFail($id);
        return view('admin.networking.ip_networking.bb_edit_umserver', compact('server'));
    }
    /**
     * Update the specified UM server in the database.
     */
    public function update_umservers(Request $request, $id)
    {
        $server = UMServer::findOrFail($id);
    
        $request->validate([
            'server_name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'username' => 'required|string|max:255',
        ]);
    
        $data = $request->only(['server_name', 'ip_address', 'username']);
    
        // Update password only if provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
            $data['encrypted_password'] = encrypt($request->password);
        }
    
        $server->update($data);
    
        return redirect()->route('show_list_umservers')->with('success', 'UM Server updated successfully!');
    }
    

    /**
     * Remove the specified UM server from the database.
     */
    public function destroy_umservers($id)
    {
        $server = UMServer::findOrFail($id);
        $server->delete();

        return redirect()->route('show_list_umservers')->with('success', 'UM Server deleted successfully!');
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
