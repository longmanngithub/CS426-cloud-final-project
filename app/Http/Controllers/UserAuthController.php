<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserAuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'phone_number' => 'nullable|string|max:100',
            'date_of_birth' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return response()->json([
            'message' => 'User registered successfully.',
            'token' => $user->createToken('user-token')->plainTextToken,
            'user' => $user->only(['user_id', 'email', 'first_name', 'last_name', 'phone_number', 'date_of_birth', 'age', 'is_banned']),
        ], 201);
    }

    // Login user
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($user->is_banned) {
            return response()->json(['message' => 'Your account has been suspended. Please contact support.'], 403);
        }

        return response()->json([
            'message' => 'Login successful.',
            'token' => $user->createToken('user-token')->plainTextToken,
            'user' => $user->only(['user_id', 'email', 'first_name', 'last_name', 'phone_number', 'date_of_birth', 'age', 'is_banned']),
        ]);
    }

    // Get authenticated user profile
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    // Update user profile
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required|string|email|unique:users,email,' . $user->user_id . ',user_id',
            'first_name' => 'sometimes|required|string|max:200',
            'last_name' => 'sometimes|required|string|max:200',
            'phone_number' => 'nullable|string|max:100',
            'date_of_birth' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only([
            'email',
            'first_name',
            'last_name',
            'phone_number',
            'date_of_birth',
        ]);

        $user->update($data);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user,
        ]);
    }

    // Update password (separate endpoint, requires current password)
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['Current password does not match.']]], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        
        // Revoke all other tokens except the current one for security
        $user->tokens()->where('id', '!=', $user->currentAccessToken()->id)->delete();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    // Logout
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully.']);
        }

        return response()->json(['message' => 'Not authenticated'], 401);
    }
}
