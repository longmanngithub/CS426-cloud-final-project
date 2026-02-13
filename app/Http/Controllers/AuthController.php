<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle organizer login via session guard.
     */
    public function loginOrganizer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if organizer exists and is banned
        $organizer = Organizer::where('email', $request->email)->first();
        if ($organizer && $organizer->is_banned) {
             return back()->withErrors(['message' => 'Your account has been suspended. Please contact support.'])->withInput();
        }

        // Try to authenticate using the organizer guard
        if (Auth::guard('organizer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('/orgmyevents')->with('success', 'Login successful!');
        }

        return back()->withErrors(['message' => 'Invalid credentials'])->withInput();
    }

    /**
     * Handle logout for both user and organizer guards.
     * Invalidates the session and regenerates the CSRF token.
     */
    public function logout(Request $request)
    {
        // Logout user if authenticated
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        
        // Logout organizer if authenticated
        if (Auth::guard('organizer')->check()) {
            Auth::guard('organizer')->logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully!');
    }
}