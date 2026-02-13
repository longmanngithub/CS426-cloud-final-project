<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Organizer;
use Symfony\Component\HttpFoundation\Response;

class CheckUserExists
{
    /**
     * Handle an incoming request.
     *
     * Check if the authenticated user or organizer still exists in the database.
     * If they've been deleted (e.g., by admin), log them out gracefully instead of throwing an error.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check user guard
        $userGuard = Auth::guard('web');
        if ($userGuard->check()) {
            try {
                $user = $userGuard->user();
                if ($user === null) {
                    $userGuard->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect('/login')->with('error', 'Your account has been deleted. Please contact support if you believe this is an error.');
                }
            } catch (\Exception $e) {
                $userGuard->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login')->with('error', 'Your session has expired. Please log in again.');
            }
        }
        
        // Check organizer guard
        $organizerGuard = Auth::guard('organizer');
        if ($organizerGuard->check()) {
            try {
                $organizer = $organizerGuard->user();
                if ($organizer === null) {
                    $organizerGuard->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect('/login')->with('error', 'Your organizer account has been deleted. Please contact support if you believe this is an error.');
                }
            } catch (\Exception $e) {
                $organizerGuard->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login')->with('error', 'Your session has expired. Please log in again.');
            }
        }
        
        return $next($request);
    }
}
