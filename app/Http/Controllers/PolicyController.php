<?php

namespace App\Http\Controllers;

use App\Services\MikroTikService;
use Illuminate\Support\Facades\Log;
use App\Models\UMServer;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    protected $mikroTikService;

    public function __construct(MikroTikService $mikroTikService)
    {
        $this->mikroTikService = $mikroTikService;
    }


    public function showSetBundle()
    {
        $umServers = UMServer::all(); // Fetch UM Servers for the dropdown
        return view('admin.policies.broadband.set_bundle', compact('umServers'));
    }

    public function fetchProfiles(Request $request)
    {
        $serverId = $request->input('server_id');
        $umServer = UMServer::find($serverId);
    
        if (!$umServer) {
            Log::error("UM Server not found for ID: $serverId");
            return response()->json(['error' => 'UM Server not found'], 404);
        }
    
        try {
            $profiles = $this->mikroTikService->getProfiles(
                $umServer->ip_address,
                $umServer->username,
                decrypt($umServer->encrypted_password)
            );
    
            if (!empty($profiles)) {
                Log::info("Fetched profiles for UM Server ID: $serverId", ['profiles' => $profiles]);
                return response()->json($profiles);
            } else {
                Log::error("No profiles found for UM Server ID: $serverId");
                return response()->json(['error' => 'No profiles found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching profiles: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching profiles'], 500);
        }
        $umServer = UMServer::find($serverId);

    if (!$umServer) {
        return response()->json(['error' => 'UM Server not found.'], 404);
    }

    try {
        $profiles = $this->mikroTikService->getProfiles(
            $umServer->ip_address,
            $umServer->username,
            decrypt($umServer->encrypted_password)
        );

        return response()->json($profiles);
    } catch (\Exception $e) {
        Log::error('Error fetching profiles: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to fetch profiles.'], 500);
    }
    }

    //fetch limit
    public function fetchLimits(Request $request)
    {
    $serverId = $request->input('server_id');
    $umServer = UMServer::find($serverId);

    if (!$umServer) {
        Log::error("UM Server not found for ID: $serverId");
        return response()->json(['error' => 'UM Server not found'], 404);
    }

    try {
        $limits = $this->mikroTikService->getUMLimits(
            $umServer->ip_address,
            $umServer->username,
            decrypt($umServer->encrypted_password)
        );

        if (!empty($limits)) {
            Log::info("Fetched limits for UM Server ID: $serverId", ['limits' => $limits]);
            return response()->json($limits);
        } else {
            Log::error("No limits found for UM Server ID: $serverId");
            return response()->json(['error' => 'No limits found'], 404);
        }
    } catch (\Exception $e) {
        Log::error('Error fetching limits: ' . $e->getMessage());
        return response()->json(['error' => 'Error fetching limits'], 500);
    }
    }

public function fetchProfileLimits(Request $request)
    {
    // Log the start of the method execution
    Log::info("Starting fetchProfileLimits method.");

    // Retrieve the server ID from the request
    $serverId = $request->input('server_id');
    Log::info("Received request to fetch profile limits for UM Server ID: $serverId");

    // Find the UM Server by ID
    $umServer = UMServer::find($serverId);
    if (!$umServer) {
        Log::error("UM Server not found for ID: $serverId");
        return response()->json(['error' => 'UM Server not found'], 404);
    }

    try {
        // Log the connection details
        Log::info("Attempting to fetch profile limits from UM Server at IP: {$umServer->ip_address}");

        // Fetch profile limits from the MikroTik service
        $profileLimits = $this->mikroTikService->getUMProfileLimits(
            $umServer->ip_address,
            $umServer->username,
            decrypt($umServer->encrypted_password)
        );

        // Check if any profile limits were returned
        if (!empty($profileLimits)) {
            Log::info("Fetched profile limits for UM Server ID: $serverId", ['profile_limits' => $profileLimits]);
            return response()->json($profileLimits);
        } else {
            Log::warning("No profile limits found for UM Server ID: $serverId");
            return response()->json(['error' => 'No profile limits found'], 404);
        }
    } catch (\Exception $e) {
        // Log the exception message
        Log::error('Error fetching profile limits: ' . $e->getMessage());
        return response()->json(['error' => 'Error fetching profile limits'], 500);
    } finally {
        // Log the end of the method execution
        Log::info("Completed fetchProfileLimits method for UM Server ID: $serverId");
    }
    }

    public function createLimits()
    {
            // Fetch all UM servers from the database
        $umServers = UMServer::all();
        return view('admin.policies.broadband.policy_create_limits', compact('umServers'));
    }

    public function storeLimit(Request $request)
    {
        Log::info('Request Data:', $request->all()); // Add this line for debugging

        $request->validate([
            'um_server_id' => 'required|exists:bb_um_servers,id',
            'name' => 'required|string|max:255',
            'transfer_limit' => 'nullable|string',
            'uptime_limit' => 'nullable|string',
            'rate_limit_rx' => 'nullable|string',
            'rate_limit_tx' => 'nullable|string',
            'rate_priority' => 'nullable|integer|min:0|max:8',
        ]);
    
        $umServer = UMServer::find($request->um_server_id);
    
        if (!$umServer) {
            return redirect()->back()->withErrors(['um_server_id' => 'UM Server not found.']);
        }
    
        try {
            $this->mikroTikService->createLimit(
                $umServer->ip_address,
                $umServer->username,
                decrypt($umServer->encrypted_password),
                $request->only([
                    'name',
                    'transfer_limit',
                    'uptime_limit',
                    'rate_limit_rx',
                    'rate_limit_tx',
                    'rate_priority'
                ])
            );
    
            return redirect()->route('set.bundle')->with('success', 'Limit created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create limit: ' . $e->getMessage()]);
        }
    }


    public function createProfile()
    {
            $umServers = UMServer::all();

        // Pass the UM servers to the view
        return view('admin.policies.broadband.policy_create_profile', compact('umServers'));
    }

    public function storeProfile(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'um_server_id' => 'required|exists:bb_um_servers,id',
            'name' => 'required|string|max:255',
            'validity' => 'nullable|string',
            'name_for_users' => 'nullable|string|max:255',
            'starts_when' => 'nullable|string|in:first-auth,activation',
            'price' => 'nullable|numeric|min:0',
            'override_shared_users' => 'nullable|in:on,off',
        ]);
    
        // Log the validated data
        Log::info('Validated profile data:', $validatedData);
    
        // Retrieve UM server details
        $umServer = UMServer::find($validatedData['um_server_id']);
    
        if (!$umServer) {
            return redirect()->back()->with('error', 'UM Server not found.');
        }
    
        try {
            // Attempt to create the profile on the UM server
            $this->mikroTikService->createProfile(
                $umServer->ip_address,
                $umServer->username,
                decrypt($umServer->encrypted_password),
                $validatedData
            );
    
            return redirect()->route('set.bundle')->with('success', 'Profile created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create profile: ' . $e->getMessage());
        }
    }
    

    public function createProfileLimitation()
    {
       // Fetch all UM servers from the database
    $umServers = UMServer::all();

    // Pass the $umServers variable to the view
    return view('admin.policies.broadband.policy_create_profile_limits', compact('umServers'));
    }

    public function fetchLimitations($serverId)
    {
        $umServer = UMServer::find($serverId);
    
        if (!$umServer) {
            return response()->json(['error' => 'UM Server not found.'], 404);
        }
    
        try {
            $limitations = $this->mikroTikService->getLimitations(
                $umServer->ip_address,
                $umServer->username,
                decrypt($umServer->encrypted_password)
            );
    
            return response()->json($limitations);
        } catch (\Exception $e) {
            Log::error('Error fetching limitations: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch limitations.'], 500);
        }
    }
    
    public function storeProfileLimitation(Request $request)
    {
        $validatedData = $request->validate([
            'um_server_id' => 'required|exists:bb_um_servers,id',
            'profile' => 'required|string',
            'limitation' => 'required|string',
        ]);
    
        $umServer = UMServer::find($validatedData['um_server_id']);
    
        try {
            $this->mikroTikService->createProfileLimitation(
                $umServer->ip_address,
                $umServer->username,
                decrypt($umServer->encrypted_password),
                $validatedData['profile'],
                $validatedData['limitation']
            );
    
            return redirect()->route('set.bundle')->with('success', 'Profile limitation created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating profile limitation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create profile limitation.');
        }
    }

   //Fetch Just the Names of UM Profiles
    public function fetchUMProfiles($serverId)
    {
    $umServer = UMServer::find($serverId);

    if (!$umServer) {
        return response()->json(['error' => 'UM Server not found.'], 404);
    }

    try {
        $profiles = $this->mikroTikService->getUMProfiles(
            $umServer->ip_address,
            $umServer->username,
            decrypt($umServer->encrypted_password)
        );

        return response()->json($profiles);
    } catch (\Exception $e) {
        Log::error('Error fetching profiles: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to fetch profiles.'], 500);
    }
}


}