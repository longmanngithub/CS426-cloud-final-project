<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Organizer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:user,organizer',
        ]);

        $role = $request->role;
        $email = $request->email;
        $broker = $role === 'organizer' ? 'organizers' : 'users';

        // Check if user exists
        if ($role === 'user') {
            $user = User::where('email', $email)->first();
        } else {
            $user = Organizer::where('email', $email)->first();
        }

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
        }

        // Generate token
        $token = Str::random(60);

        // Store token in DB
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => $token, 
                'created_at' => Carbon::now()
            ]
        );
        
        // Re-do manual store for clarity and control
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Send email
        $link = url('/reset-password/' . $token . '?email=' . urlencode($email) . '&role=' . $role);
        
        try {
            Mail::to($email)->send(new ResetPasswordMail($link));
        } catch (\Exception $e) {
             return back()->withErrors(['email' => 'Failed to send password reset link. Please try again later.']);
        }

        return back()->with('status', 'We have e-mailed your password reset link!');
    }
}
