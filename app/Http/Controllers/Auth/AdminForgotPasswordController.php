<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class AdminForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user_admin,email',
        ]);

        $email = $request->email;

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
        
        // Send email
        // Note: Using 'admin' prefix for route to ensure correct handling
        $link = route('admin.password.reset', ['token' => $token, 'email' => $email]);
        
        try {
            Mail::to($email)->send(new ResetPasswordMail($link));
        } catch (\Exception $e) {
             return back()->withErrors(['email' => 'Failed to send password reset link. Please try again later.']);
        }

        return back()->with('status', 'We have e-mailed your password reset link!');
    }
}
