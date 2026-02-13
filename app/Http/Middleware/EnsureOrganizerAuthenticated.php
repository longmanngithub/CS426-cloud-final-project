<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizerAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * Ensure the organizer is authenticated via the 'organizer' guard.
     * Redirects to login if not authenticated.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('organizer')->check()) {
            return redirect('/login')->with('error', 'Please log in as an organizer to access this page.');
        }

        // Check if the authenticated organizer is banned
        $organizer = Auth::guard('organizer')->user();
        if ($organizer && $organizer->is_banned) {
            Auth::guard('organizer')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'Your account has been suspended. Please contact support.');
        }

        return $next($request);
    }
}
