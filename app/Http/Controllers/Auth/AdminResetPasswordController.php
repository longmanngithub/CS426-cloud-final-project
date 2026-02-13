<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUser;
use Carbon\Carbon;

class AdminResetPasswordController extends Controller
{
    // Reset password for admin
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
            return response()->json(['message' => 'Invalid token!'], 422);
        }

        // Check expiry (1440 mins = 24 hours)
        $tokenCreatedAt = Carbon::parse($record->created_at);
        if ($tokenCreatedAt->addMinutes(1440)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return response()->json(['message' => 'This password reset token is invalid or has expired.'], 422);
        }

        // Update password
        $admin = AdminUser::where('email', $email)->first();
        $admin->password = Hash::make($password);
        $admin->save();
        
        // Revoke all existing tokens for security
        $admin->tokens()->delete();

        // Delete token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return response()->json(['message' => 'Your password has been reset successfully!']);
    }
}
