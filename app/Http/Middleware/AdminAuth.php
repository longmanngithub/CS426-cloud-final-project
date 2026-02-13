<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Check if admin guard is logged in
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }

        // Check if admin is banned
        $admin = Auth::guard('admin')->user();
        if ($admin && $admin->is_banned) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/admin/login')->with('error', 'Your account has been suspended.');
        }

        return $next($request);
    }
}
