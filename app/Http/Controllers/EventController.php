<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\FavoriteEvent;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['organizer', 'category'])->get();
        return view('events.index', compact('events'));
    }

    public function store(Request $request)
    {
        // Get the organizer from the auth guard
        $organizer = Auth::guard('organizer')->user();
        if (!$organizer) {
            return back()->withErrors(['message' => 'Organizer account not found. Please make sure you are logged in as an organizer.'])->withInput();
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:200',
            'link' => 'nullable|url|max:200',
            'picture_url' => 'nullable|url|max:200',
            'picture_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Custom validation: if same day event, end_time must be after start_time
        $startDate = $request->start_date;
        $endDate = $request->end_date ?? $request->start_date; // If no end_date, assume same day
        $startTime = $request->start_time;
        $endTime = $request->end_time;

        if ($startDate === $endDate && $endTime) {
            if ($endTime <= $startTime) {
                return back()->withErrors(['end_time' => 'End time must be after start time when the event is on the same day.'])->withInput();
            }
        }

        $data = $request->all();
        $data['organizer_id'] = $organizer->organizer_id; // Set the organizer_id from the database
        
        // Handle file upload
        if ($request->hasFile('picture_file')) {
            $file = $request->file('picture_file');
            $disk = config('filesystems.default');
            $path = $file->store('event_images', $disk);
            $data['picture_url'] = $path;
        }
        // If no file, use the provided URL (already in $data['picture_url'])
        $event = Event::create($data);
        return redirect('/orgmyevents')->with('success', 'Event created successfully!');
    }

    public function show($id)
    {
        $event = Event::with(['organizer', 'category'])->findOrFail($id);
        return view('events.eventsinfo', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:200',
            'link' => 'nullable|url|max:200',
            'picture_url' => 'nullable|string|max:500',
            'picture_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Custom validation: if same day event, end_time must be after start_time
        $startDate = $request->start_date;
        $endDate = $request->end_date ?? $request->start_date;
        $startTime = $request->start_time;
        $endTime = $request->end_time;

        if ($startDate === $endDate && $endTime) {
            if ($endTime <= $startTime) {
                return back()->withErrors(['end_time' => 'End time must be after start time when the event is on the same day.'])->withInput();
            }
        }

        $data = $request->all();
        // Handle file upload
        if ($request->hasFile('picture_file')) {
            // Delete old file if it's a stored file (not an external URL)
            $oldUrl = $event->getRawOriginal('picture_url');
            if ($oldUrl && !str_starts_with($oldUrl, 'http://') && !str_starts_with($oldUrl, 'https://')) {
                $oldPath = str_starts_with($oldUrl, '/storage/') ? substr($oldUrl, 9) : $oldUrl;
                Storage::disk(config('filesystems.default'))->delete($oldPath);
            }

            $file = $request->file('picture_file');
            $disk = config('filesystems.default');
            $path = $file->store('event_images', $disk);
            $data['picture_url'] = $path;
        }
        $event->update($data);
        return redirect('/orgmyevents')->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        // Delete related favorite_events first
        FavoriteEvent::where('event_id', $event->event_id)->delete();
        $event->delete();
        // Redirect based on user role
        if (Auth::guard('organizer')->check()) {
            return redirect('/orgmyevents')->with('success', 'Event deleted successfully!');
        }
        return redirect('/events')->with('success', 'Event deleted successfully!');
    }

    public function getEventsByOrganizer($organizerId)
    {
        $events = Event::where('organizer_id', $organizerId)
                      ->with(['category'])
                      ->get();
        return view('events.index', compact('events'));
    }

    public function getEventsByCategory($categoryId)
    {
        $events = Event::where('category_id', $categoryId)
                      ->with(['organizer', 'category'])
                      ->get();
        return view('events.index', compact('events'));
    }

    public function homePage()
    {
        $events = \App\Models\Event::with(['organizer', 'category'])->latest()->take(6)->get();
        $featuredEvents = \App\Models\Event::with(['organizer', 'category'])->inRandomOrder()->take(5)->get();
        $categories = \App\Models\Category::all();
        return view('main.home', compact('events', 'featuredEvents', 'categories'));
    }

    public function eventsPage()
    {
        $query = \App\Models\Event::with(['organizer', 'category']);
        
        // Filter by category if provided
        if (request()->has('category') && request('category')) {
            $query->where('category_id', request('category'));
        }
        
        // Filter by search term if provided (case-insensitive)
        if (request()->has('search') && request('search')) {
            $search = strtolower(request('search'));
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(title) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(description) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(location) like ?', ["%$search%"])
                  ->orWhereHas('category', function($catQ) use ($search) {
                      $catQ->whereRaw('LOWER(name) like ?', ["%$search%"]);
                  });
            });
        }
        // Filter by price type (Free/Paid)
        if (request()->has('price_type') && request('price_type')) {
            if (request('price_type') === 'free') {
                $query->where('price', 0);
            } elseif (request('price_type') === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // Sort results
        $sort = request('sort', 'newest');
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
        return view('events.events', compact('events'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('org.edit_event', compact('event', 'categories'));
    }
}