<?php 

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller{
    public function index_signin(){
        return view('index_signin');
    }

    public function auth_pass_reset(){
        return view('auth.auth_pass_reset');
    }

    public function signin(Request $request)
    {
        // Validate the request input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to signin the user in
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->filled('remember'))) {
            // Authentication passed, redirecting.......
            return redirect()->route('admin.dashboard'); // Redirect to your admin dashboard
        }

        // If authentication fails, redirect back with an error
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

}



