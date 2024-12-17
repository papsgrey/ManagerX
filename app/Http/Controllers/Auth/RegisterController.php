<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Show the signup form
    public function auth_signup(){
        return view('auth.auth_signup');
    }

    // Handle the form submission
    public function signup(Request $request)
    {
        // Validate the form input
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_number' => ['required', 'string', 'max:15'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Ensure passwords match
        
        ]);

        // Create a new user in the database
        User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Hash the password before saving
        ]);

        // Redirect to a success page or login page
        return redirect()->route('signin')->with('success', 'Account created successfully! Please log in.');
    }
}
