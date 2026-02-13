<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organizer;
use App\Models\Event;
use App\Models\Category; // Added this line to load categories
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalOrganizers = Organizer::count();

        // Recent Activity
        $recentUsers = User::latest()->take(5)->get();
        $recentEvents = Event::with('organizer')->latest()->take(5)->get();

        // Chart Data 1: User vs Organizer (Pie Chart)
        $userVsOrg = [
            'users' => $totalUsers,
            'organizers' => $totalOrganizers,
            'total' => $totalUsers + $totalOrganizers
        ];

        // --- Monthly Data (Last 12 Months) ---
        $monthlyLabels = [];
        $monthlyEvents = [];
        $monthlyUserReg = [];
        $monthlyOrgReg = [];

        // Pre-fetch data
        $mEvents = Event::selectRaw("TO_CHAR(start_date, 'YYYY-MM') as month, count(*) as count")
            ->where('start_date', '>=', now()->subMonths(12))
            ->groupBy('month')->pluck('count', 'month')->toArray();

        $mUserReg = User::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, count(*) as count")
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')->pluck('count', 'month')->toArray();

        $mOrgReg = Organizer::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, count(*) as count")
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')->pluck('count', 'month')->toArray();

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $monthlyLabels[] = $date->format('M Y');
            $monthlyEvents[] = $mEvents[$key] ?? 0;
            $monthlyUserReg[] = $mUserReg[$key] ?? 0;
            $monthlyOrgReg[] = $mOrgReg[$key] ?? 0;
        }

        // --- Daily Data (Last 30 Days) ---
        $dailyLabels = [];
        $dailyEvents = [];
        $dailyUserReg = [];
        $dailyOrgReg = [];

        $dEvents = Event::selectRaw("TO_CHAR(start_date, 'YYYY-MM-DD') as day, count(*) as count")
            ->where('start_date', '>=', now()->subDays(30))
            ->groupBy('day')->pluck('count', 'day')->toArray();

        $dUserReg = User::selectRaw("TO_CHAR(created_at, 'YYYY-MM-DD') as day, count(*) as count")
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('day')->pluck('count', 'day')->toArray();

        $dOrgReg = Organizer::selectRaw("TO_CHAR(created_at, 'YYYY-MM-DD') as day, count(*) as count")
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('day')->pluck('count', 'day')->toArray();

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $key = $date->format('Y-m-d');
            $dailyLabels[] = $date->format('M d');
            $dailyEvents[] = $dEvents[$key] ?? 0;
            $dailyUserReg[] = $dUserReg[$key] ?? 0;
            $dailyOrgReg[] = $dOrgReg[$key] ?? 0;
        }

        // Bundle data for view
        $chartData = [
            'monthly' => [
                'labels' => $monthlyLabels,
                'events' => $monthlyEvents,
                'users' => $monthlyUserReg,
                'organizers' => $monthlyOrgReg
            ],
            'daily' => [
                'labels' => $dailyLabels,
                'events' => $dailyEvents,
                'users' => $dailyUserReg,
                'organizers' => $dailyOrgReg
            ]
        ];

        return view('backend.overview', compact(
            'totalUsers', 'totalEvents', 'totalOrganizers', 
            'recentUsers', 'recentEvents',
            'userVsOrg', 'chartData'
        ));

    }

    public function manageUser(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(first_name) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(last_name) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(email) like ?', ["%$search%"]);
            });
        }

        $users = $query->get();
        return view('backend.manageUser', compact('users'));
    }

    public function toggleBanUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'banned' : 'unbanned';
        return redirect()->back()->with('success', "User has been {$status}.");
    }

    public function manageOrganizer(Request $request)
    {
        $query = Organizer::query();

        if ($request->has('search') && $request->search) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(first_name) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(last_name) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(email) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(organization_name) like ?', ["%$search%"]);
            });
        }

        $organizers = $query->get();
        return view('backend.manageOrganizer', compact('organizers'));
    }

    public function toggleBanOrganizer($id)
    {
        $organizer = Organizer::findOrFail($id);
        $organizer->is_banned = !$organizer->is_banned;
        $organizer->save();

        $status = $organizer->is_banned ? 'banned' : 'unbanned';
        return redirect()->back()->with('success', "Organizer has been {$status}.");
    }

    public function manageEvents(Request $request)
    {
        $query = Event::with(['organizer', 'category']);

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by search term if provided (case-insensitive)
        if ($request->has('search') && $request->search) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(description) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(location) like ?', ["%$search%"])
                  ->orWhereHas('category', function ($catQ) use ($search) {
                      $catQ->whereRaw('LOWER(name) like ?', ["%$search%"]);
                  });
            });
        }

        // Filter by price type (Free/Paid)
        if ($request->has('price_type') && $request->price_type) {
            if ($request->price_type === 'free') {
                $query->where('price', 0);
            } elseif ($request->price_type === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // Sort results
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
        return view('backend.manageEvent', compact('events'));
    }



    public function deleteEvent($id)
    {
        Event::destroy($id);
        return redirect('/admin/manageEvents')->with('success', 'Event deleted');
    }

    public function profile()
    {
        // Use the explicit guard to get the logged-in admin
        $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        return view('backend.profile', compact('admin'));
    }

    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        
        // Use the Eloquent model to ensure we can save
        $adminModel = \App\Models\Admin::find($admin->admin_id);

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $adminModel->password)) {
             return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $adminModel->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $adminModel->save();

        return back()->with('success', 'Password updated successfully!');
    }

    public function show($id)
    {
        $event = Event::with(['organizer', 'category'])->findOrFail($id);
        return view('backend.eventDetail', compact('event'));
    }

    public function showUser($id)
    {
        $user = User::with('favorites.event')->findOrFail($id);
        return view('backend.userDetail', compact('user'));
    }

    public function showOrganizer($id)
    {
        $organizer = Organizer::with('events')->findOrFail($id);
        return view('backend.organizerDetail', compact('organizer'));
    }
}
