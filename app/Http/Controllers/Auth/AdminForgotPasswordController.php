<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\AdminUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class AdminForgotPasswordController extends Controller
{
    // Send password reset link for admin
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
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Build reset link
        $link = url('/api/admin/reset-password/' . $token . '?email=' . urlencode($email));

        try {
            Mail::to($email)->send(new ResetPasswordMail($link));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send password reset link. Please try again later.'], 500);
        }

        return response()->json(['message' => 'We have e-mailed your password reset link!']);
    }
}
