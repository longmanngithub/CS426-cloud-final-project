<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Organizer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    // Send password reset link for user or organizer
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:user,organizer',
        ]);

        $role = $request->role;
        $email = $request->email;

        // Check if user/organizer exists
        if ($role === 'user') {
            $account = User::where('email', $email)->first();
        } else {
            $account = Organizer::where('email', $email)->first();
        }

        if (!$account) {
            return response()->json(['message' => 'We can\'t find an account with that e-mail address.'], 404);
        }

        // Generate token
        $token = Str::random(60);

        // Store token in DB
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Build reset link
        $link = url('/api/password/reset/' . $token . '?email=' . urlencode($email) . '&role=' . $role);

        try {
            Mail::to($email)->send(new ResetPasswordMail($link));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send password reset link. Please try again later.'], 500);
        }

        return response()->json(['message' => 'We have e-mailed your password reset link!']);
    }
}
