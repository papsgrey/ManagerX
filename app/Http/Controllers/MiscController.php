<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class MiscController extends Controller
{
    //Loging Out Users from the Dashboard
    public function signout(Request $request)
    {
        Auth::logout(); // Log the user out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token
        
        return redirect()->route('signout_success'); // Redirect to the signout success page
    }

    //Displaying Signout Page
    public function signout_success()
{
    return view('auth.auth_signout');
}

// Lockout the user
public function lockout(Request $request)
{
    // Store the user's ID in session (to use on lock screen)
    $request->session()->put('locked_user_id', Auth::id());
    $request->session()->put('url.intended', url()->previous());

    // Logout the user temporarily
    Auth::logout();

    // Redirect to the lock screen
    return redirect()->route('locked_screen');
}

// Display the lock screen
public function locked_screen()
{
    return view('auth.auth_lock_screen');
}


/**Unlocking user and redirecting to previous page
public function unlock(Request $request)
{
    $userId = $request->session()->get('locked_user_id');

    if (!$userId) {
        return redirect()->route('signin');
    }

    // Find the locked user
    $user = \App\Models\User::find($userId);

    // Validate the password
    if (Hash::check($request->password, $user->password)) {
        // Log the user back in
        Auth::login($user);

        // Remove the locked session
        $request->session()->forget('locked_user_id');

        // Redirect to the intended dashboard
        return redirect()->intended();
    }

    // If password doesn't match, return back to the lock screen with an error
    return back()->withErrors(['password' => 'Invalid password']);
}**/

//redirect to admin settings
public function admin_setting()
{
    return view('admin.default.admin_settings');
}

//redirect to admin profile
public function admin_profile()
{
    return view('admin.default.admin_profile');
}



//public function bb_add_um_server(){
//    return view('admin.default.add_umserver');
//}

}
