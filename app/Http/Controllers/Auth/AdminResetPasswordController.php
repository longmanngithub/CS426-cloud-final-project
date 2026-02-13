<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use Carbon\Carbon;

class AdminResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:user_admin,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $email = $request->email;
        $password = $request->password;
        $token = $request->token;

        // Verify token
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || $record->token !== $token) {
             return back()->withErrors(['email' => 'Invalid token!']);
        }
        
        // Check expiry (1440 mins = 24 hours)
        $tokenCreatedAt = Carbon::parse($record->created_at);
        if ($tokenCreatedAt->addMinutes(1440)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->withErrors(['email' => 'This password reset token is invalid or has expired.']);
        }

        // Update password
        $admin = Admin::where('email', $email)->first();
        $admin->password = Hash::make($password);
        // Regenerate remember token to invalidate all existing sessions
        $admin->setRememberToken(Str::random(60));
        $admin->save();

        // Delete token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('admin.login')->with('success', 'Your password has been reset!');
    }
}
