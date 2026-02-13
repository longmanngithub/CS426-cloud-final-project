<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Organizer;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    // Reset password for user or organizer
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
            return response()->json(['message' => 'Invalid token!'], 422);
        }

        // Check expiry (1440 mins = 24 hours)
        $tokenCreatedAt = Carbon::parse($record->created_at);
        if ($tokenCreatedAt->addMinutes(1440)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return response()->json(['message' => 'This password reset token is invalid or has expired.'], 422);
        }

        // Update password
        if ($role === 'user') {
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found.'], 404);
            }
            $user->password = Hash::make($password);
            $user->save();
            
            // Revoke all existing tokens for security
            $user->tokens()->delete();
        } else {
            $organizer = Organizer::where('email', $email)->first();
            if (!$organizer) {
                return response()->json(['message' => 'Organizer not found.'], 404);
            }
            $organizer->password = Hash::make($password);
            $organizer->save();
            
            // Revoke all existing tokens for security
            $organizer->tokens()->delete();
        }

        // Delete token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return response()->json(['message' => 'Your password has been reset successfully!']);
    }
}
