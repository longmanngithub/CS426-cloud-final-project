<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{


    public function myEvents(Request $request)
    {
        $organizer = Auth::guard('organizer')->user();
        $query = \App\Models\Event::with(['category'])
            ->where('organizer_id', $organizer->organizer_id);

        // Search
        if ($request->has('search') && $request->search) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(title) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(location) like ?', ["%$search%"]);
            });
        }

        // Filter by Category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by Price Type
        if ($request->has('price_type') && $request->price_type) {
            if ($request->price_type === 'free') {
                $query->where('price', 0);
            } elseif ($request->price_type === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // Sort
        $sort = $request->query('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $events = $query->get();
        return view('org.orgmyevents', compact('events'));
    }

    public function orgProfile()
    {
        $organizer = Auth::guard('organizer')->user();
        return view('org.orgpf', compact('organizer'));
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $organizer = Auth::guard('organizer')->user();
        if ($organizer) {
            $organizer->first_name = $request->first_name;
            $organizer->last_name = $request->last_name;
            $organizer->phone_number = $request->phone_number;
            $organizer->date_of_birth = $request->date_of_birth;
            $organizer->email = $request->email;
            $organizer->organization_name = $request->organization_name;
            $organizer->company_name = $request->company_name;
            $organizer->website = $request->website;
            $organizer->business_reg_no = $request->business_reg_no;
            $organizer->save();
        }
        return redirect('/orgpf')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $organizer = Auth::guard('organizer')->user();
        
        if (!Hash::check($request->current_password, $organizer->password)) {
             return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $organizer->password = Hash::make($request->password);
        $organizer->save();

        return back()->with('success', 'Password updated successfully!');
    }

    public function registerOrganizer(\Illuminate\Http\Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:organizers',
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
            return back()->withErrors($validator)->withInput();
        }

        // Create organizer
        $organizer = \App\Models\Organizer::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'organization_name' => $request->organization_name,
            'company_name' => $request->company_name,
            'website' => $request->website,
            'business_reg_no' => $request->business_reg_no,
        ]);

        // Log in the organizer using the auth guard
        Auth::guard('organizer')->login($organizer);
        $request->session()->regenerate();
        
        return redirect('/orgmyevents')->with('success', 'Organizer registered successfully!');
    }
}
