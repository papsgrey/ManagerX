<?php

namespace App\Http\Controllers;

use App\Services\MikroTikPolicyEditService;
use Illuminate\Http\Request;

class PolicyEditController extends Controller
{
    protected $policyService;

    public function __construct(MikroTikPolicyEditService $policyService)
    {
        $this->policyService = $policyService;
    }

    // Edit Profile
    public function editProfile($id)
    {
        $profile = $this->policyService->getProfileById($id);
        return view('admin.policies.broadband.policy_edit_profile', compact('profile'));
    }

    public function updateProfile(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'validity' => 'required|string',
            'name_of_users' => 'nullable|string',
            'start_when' => 'nullable|string',
            'price' => 'nullable|numeric',
            'override_shared_users' => 'nullable|boolean',
        ]);

        $this->policyService->updateProfile($id, $data);
        return redirect()->route('profiles.edit', $id)->with('success', 'Profile updated successfully.');
    }

    public function deleteProfile($id)
    {
        $this->policyService->deleteProfile($id);
        return response()->json(['success' => true]);
    }

    // Edit Limits
    public function editLimits($id)
    {
        $limit = $this->policyService->getLimitById($id);
        return view('policy_edit_limits', compact('limit'));
    }

    public function updateLimits(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'transfer_limit' => 'nullable|string',
            'uptime_limit' => 'nullable|string',
            'rate_limit_rx' => 'nullable|string',
            'rate_limit_tx' => 'nullable|string',
        ]);

        $this->policyService->updateLimits($id, $data);
        return redirect()->route('limits.edit', $id)->with('success', 'Limit updated successfully.');
    }

    public function deleteLimits($id)
    {
        $this->policyService->deleteLimits($id);
        return response()->json(['success' => true]);
    }

    // Edit Profile Limits
    public function editProfileLimits($id)
    {
        $profileLimit = $this->policyService->getProfileLimitById($id);
        return view('policy_edit_profilelimits', compact('profileLimit'));
    }

    public function updateProfileLimits(Request $request, $id)
    {
        $data = $request->validate([
            'profile' => 'required|string|max:255',
            'limitation' => 'required|string|max:255',
        ]);

        $this->policyService->updateProfileLimits($id, $data);
        return redirect()->route('profilelimits.edit', $id)->with('success', 'Profile Limit updated successfully.');
    }

    public function deleteProfileLimits($id)
    {
        $this->policyService->deleteProfileLimits($id);
        return response()->json(['success' => true]);
    }
}
