<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminUser;
use App\Models\User;
use App\Models\Organizer;
use App\Models\Event;
use App\Models\Category;
use App\Models\FavEvent;

class AdminAuthController extends Controller
{
    // Admin Login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = AdminUser::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Admin login successful.',
            'token' => $admin->createToken('admin-token')->plainTextToken,
            'admin' => $admin->only(['admin_id', 'email', 'first_name', 'last_name', 'phone_number', 'date_of_birth', 'age', 'is_banned']),
        ]);
    }

    // Admin Logout
    public function logout(Request $request)
    {
        $admin = $request->user('admin');

        if ($admin && $admin->currentAccessToken()) {
            $admin->currentAccessToken()->delete();
            return response()->json(['message' => 'Admin logged out successfully.']);
        }

        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    // Admin Dashboard - stats + recent activity + chart data
    public function dashboard(Request $request)
    {
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalOrganizers = Organizer::count();

        // Recent Activity
        $recentUsers = User::latest()->take(5)->get();
        $recentEvents = Event::with('organizer')->latest()->take(5)->get();

        // User vs Organizer summary
        $userVsOrg = [
            'users' => $totalUsers,
            'organizers' => $totalOrganizers,
            'total' => $totalUsers + $totalOrganizers,
        ];

        // Monthly Data (Last 12 Months)
        $monthlyLabels = [];
        $monthlyEvents = [];
        $monthlyUserReg = [];
        $monthlyOrgReg = [];

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

        // Daily Data (Last 30 Days)
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

        $chartData = [
            'monthly' => [
                'labels' => $monthlyLabels,
                'events' => $monthlyEvents,
                'users' => $monthlyUserReg,
                'organizers' => $monthlyOrgReg,
            ],
            'daily' => [
                'labels' => $dailyLabels,
                'events' => $dailyEvents,
                'users' => $dailyUserReg,
                'organizers' => $dailyOrgReg,
            ],
        ];

        return response()->json([
            'admin' => $request->user('admin'),
            'total_users' => $totalUsers,
            'total_events' => $totalEvents,
            'total_organizers' => $totalOrganizers,
            'recent_users' => $recentUsers,
            'recent_events' => $recentEvents,
            'user_vs_org' => $userVsOrg,
            'chart_data' => $chartData,
        ]);
    }

    // Admin Profile
    public function profile(Request $request)
    {
        return response()->json($request->user('admin'));
    }

    // Admin Update Password
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = $request->user('admin');
        $adminModel = AdminUser::find($admin->admin_id);

        if (!Hash::check($request->current_password, $adminModel->password)) {
            return response()->json(['errors' => ['current_password' => ['Current password does not match.']]], 422);
        }

        $adminModel->password = Hash::make($request->password);
        $adminModel->save();
        
        // Revoke all other tokens except the current one for security
        $adminModel->tokens()->where('id', '!=', $admin->currentAccessToken()->id)->delete();

        return response()->json(['message' => 'Password updated successfully.']);
    }


    // =========== USER MANAGEMENT =================

    // List all users (with optional search)
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

        return response()->json($query->get());
    }

    // Toggle ban/unban user
    public function toggleBanUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'banned' : 'unbanned';
        return response()->json(['message' => "User has been {$status}.", 'user' => $user->only(['user_id', 'email', 'first_name', 'last_name', 'is_banned'])]);
    }

    // Show user detail (with favorites)
    public function showUser($id)
    {
        $user = User::with(['favorites' => function($query) {
            $query->with(['event' => function($q) {
                $q->without('users');
            }]);
        }])->findOrFail($id);
        return response()->json($user);
    }


    // ================= ORGANIZER MANAGEMENT =================

    // List all organizers (with optional search)
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

        return response()->json($query->get());
    }

    // Toggle ban/unban organizer
    public function toggleBanOrganizer($id)
    {
        $organizer = Organizer::findOrFail($id);
        $organizer->is_banned = !$organizer->is_banned;
        $organizer->save();

        $status = $organizer->is_banned ? 'banned' : 'unbanned';
        return response()->json(['message' => "Organizer has been {$status}.", 'organizer' => $organizer->only(['organizer_id', 'email', 'first_name', 'last_name', 'organization_name', 'is_banned'])]);
    }

    // Show organizer detail (with events)
    public function showOrganizer($id)
    {
        $organizer = Organizer::with(['events' => function($query) {
            $query->without('users', 'favoriteEvents');
        }])->findOrFail($id);
        return response()->json($organizer);
    }


    // ================= EVENT MANAGEMENT =================

    // List all events (with optional search, category filter, price filter, sorting)
    public function manageEvent(Request $request)
    {
        $query = Event::with(['organizer', 'category']);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search
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

        // Filter by price type
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

        return response()->json($query->get());
    }

    // Fetch one event
    public function showEvent($id)
    {
        $event = Event::with(['organizer', 'category'])->findOrFail($id);
        return response()->json($event);
    }

    // Delete event (soft delete)
    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully.']);
    }
}
