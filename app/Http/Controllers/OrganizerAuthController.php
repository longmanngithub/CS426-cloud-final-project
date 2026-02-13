<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Organizer;

class OrganizerAuthController extends Controller
{
    // Register organizer
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:organizers,email',
            'password' => 'required|string|min:6|confirmed',
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'phone_number' => 'nullable|string|max:100',
            'date_of_birth' => 'required|date',
            'organization_name' => 'required|string|max:200',
            'company_name' => 'nullable|string|max:200',
            'website' => 'nullable|string|max:200',
            'business_reg_no' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $organizer = Organizer::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'organization_name' => $request->organization_name,
            'company_name' => $request->company_name,
            'website' => $request->website,
            'business_reg_no' => $request->business_reg_no,
        ]);

        return response()->json([
            'message' => 'Organizer registered successfully.',
            'token' => $organizer->createToken('organizer-token')->plainTextToken,
            'organizer' => $organizer->only(['organizer_id', 'email', 'first_name', 'last_name', 'phone_number', 'date_of_birth', 'age', 'organization_name', 'company_name', 'website', 'business_reg_no', 'is_banned']),
        ], 201);
    }

    // Login organizer
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $organizer = Organizer::where('email', $request->email)->first();

        if (!$organizer || !Hash::check($request->password, $organizer->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($organizer->is_banned) {
            return response()->json(['message' => 'Your account has been suspended. Please contact support.'], 403);
        }

        return response()->json([
            'message' => 'Login successful.',
            'token' => $organizer->createToken('organizer-token')->plainTextToken,
            'organizer' => $organizer->only(['organizer_id', 'email', 'first_name', 'last_name', 'phone_number', 'date_of_birth', 'age', 'organization_name', 'company_name', 'website', 'business_reg_no', 'is_banned']),
        ]);
    }

    // Get authenticated organizer profile
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    // Update organizer profile
    public function update(Request $request)
    {
        $organizer = $request->user();

        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required|string|email|unique:organizers,email,' . $organizer->organizer_id . ',organizer_id',
            'first_name' => 'sometimes|required|string|max:200',
            'last_name' => 'sometimes|required|string|max:200',
            'phone_number' => 'nullable|string|max:100',
            'date_of_birth' => 'sometimes|required|date',
            'organization_name' => 'sometimes|required|string|max:200',
            'company_name' => 'nullable|string|max:200',
            'website' => 'nullable|string|max:200',
            'business_reg_no' => 'nullable|string|max:100',
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
            'organization_name',
            'company_name',
            'website',
            'business_reg_no',
        ]);

        $organizer->update($data);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'organizer' => $organizer,
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

        $organizer = $request->user();

        if (!Hash::check($request->current_password, $organizer->password)) {
            return response()->json(['errors' => ['current_password' => ['Current password does not match.']]], 422);
        }

        $organizer->password = Hash::make($request->password);
        $organizer->save();
        
        // Revoke all other tokens except the current one for security
        $organizer->tokens()->where('id', '!=', $organizer->currentAccessToken()->id)->delete();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    // Logout organizer
    public function logout(Request $request)
    {
        $organizer = $request->user();

        if ($organizer && $organizer->currentAccessToken()) {
            $organizer->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully.']);
        }

        return response()->json(['message' => 'Not authenticated'], 401);
    }
}
