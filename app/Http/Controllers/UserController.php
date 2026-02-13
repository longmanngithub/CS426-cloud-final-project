<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'phone_number' => 'nullable|string|max:100',
            'date_of_birth' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect('/userpf')->with('success', 'User created successfully!');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.userpf', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'phone_number' => 'nullable|string|max:100',
            'date_of_birth' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->update($request->all());
        return redirect('/userpf')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/users')->with('success', 'User deleted successfully!');
    }

    /**
     * Handle user registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' checks for 'password_confirmation' field
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'phone_number' => 'nullable|string|max:100',
            'date_of_birth' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('success', 'User registered successfully!');
    }

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_banned) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['message' => 'Your account has been suspended. Please contact support.'])->withInput();
            }

            $request->session()->regenerate();

            return redirect('/')->with('success', 'Login successful!');
        } else {
            return back()->withErrors(['message' => 'Invalid credentials'])->withInput();
        }
    }

    /**
     * Handle user logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully!');
    }



    public function userFav()
    {
        $user = Auth::user();
        $favorites = \App\Models\FavoriteEvent::with('event')->where('user_id', $user->user_id)->get();
        return view('user.userfav', compact('favorites', 'user'));
    }

    public function userProfile()
    {
        $user = Auth::user();
        return view('user.userpf', compact('user'));
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $user = \App\Models\User::find($user->user_id); // Ensure Eloquent model instance
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->date_of_birth = $request->date_of_birth;
        $user->email = $request->email;
        $user->save();
        return redirect('/userpf')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user = User::find($user->user_id);

        if (!Hash::check($request->current_password, $user->password)) {
             return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
