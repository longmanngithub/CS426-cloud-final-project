<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Organizer;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email, 'role' => $request->role]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:user,organizer',
            'password' => 'required|confirmed|min:6',
        ]);

        $role = $request->role;
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
        if ($role === 'user') {
            $user = User::where('email', $email)->first();
            if (!$user) return back()->withErrors(['email' => 'User not found.']);
            $user->password = Hash::make($password);
            // Regenerate remember token to invalidate all existing sessions
            $user->setRememberToken(Str::random(60));
            $user->save();
        } else {
            $organizer = Organizer::where('email', $email)->first();
            if (!$organizer) return back()->withErrors(['email' => 'Organizer not found.']);
            $organizer->password = Hash::make($password);
            // Regenerate remember token to invalidate all existing sessions
            $organizer->setRememberToken(Str::random(60));
            $organizer->save();
        }

        // Delete token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect('/login')->with('success', 'Your password has been reset!');
    }
}
