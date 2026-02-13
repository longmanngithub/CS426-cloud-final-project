<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * Ensure the user is authenticated via the 'web' guard.
     * Redirects to login if not authenticated.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('web')->check()) {
            return redirect('/login')->with('error', 'Please log in as a user to access this page.');
        }

        // Check if the authenticated user is banned
        $user = Auth::guard('web')->user();
        if ($user && $user->is_banned) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'Your account has been suspended. Please contact support.');
        }

        return $next($request);
    }
}
