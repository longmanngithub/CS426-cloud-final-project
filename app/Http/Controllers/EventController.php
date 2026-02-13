<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\FavEvent;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // List all events with organizer and category
    public function index(Request $request)
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

    // Show a single event by event_id (with organizer and category)
    public function show($event_id)
    {
        $event = Event::with(['organizer', 'category'])->find($event_id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
    }

    // Home page data: latest events, featured events, categories
    public function homePage()
    {
        $events = Event::with(['organizer', 'category'])->latest()->take(6)->get();
        $featuredEvents = Event::with(['organizer', 'category'])->inRandomOrder()->take(5)->get();
        $categories = Category::all();

        return response()->json([
            'latest_events' => $events,
            'featured_events' => $featuredEvents,
            'categories' => $categories,
        ]);
    }

    // Get events by organizer ID
    public function getEventsByOrganizer($organizerId)
    {
        $events = Event::where('organizer_id', $organizerId)
                      ->with(['category'])
                      ->get();

        return response()->json($events);
    }

    // Get events by category ID
    public function getEventsByCategory($categoryId)
    {
        $events = Event::where('category_id', $categoryId)
                      ->with(['organizer', 'category'])
                      ->get();

        return response()->json($events);
    }

    // Create a new event (organizer only)
    public function store(Request $request)
    {
        $organizer = auth('organizer')->user();

        if (!$organizer) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,category_id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'nullable',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:200',
            'link' => 'nullable|url|max:200',
            'picture_url' => 'nullable|string|max:500',
            'picture_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except(['picture_file']);
        $data['organizer_id'] = $organizer->organizer_id;

        // Handle file upload
        if ($request->hasFile('picture_file')) {
            $file = $request->file('picture_file');
            $disk = config('filesystems.default');
            $path = $file->store('event_images', $disk);
            $data['picture_url'] = $path;
        }

        $event = Event::create($data);

        return response()->json([
            'message' => 'Event created successfully.',
            'event' => $event->load(['organizer', 'category']),
        ], 201);
    }

    // Update an event by event_id (organizer only)
    public function update(Request $request, $event_id)
    {
        $event = Event::find($event_id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:200',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,category_id',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'sometimes',
            'end_time' => 'nullable',
            'price' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:200',
            'link' => 'nullable|url|max:200',
            'picture_url' => 'nullable|string|max:500',
            'picture_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except(['picture_file']);

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

        return response()->json([
            'message' => 'Event updated successfully.',
            'event' => $event->load(['organizer', 'category']),
        ]);
    }

    // Delete an event by event_id
    public function destroy($event_id)
    {
        $event = Event::find($event_id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Delete related favorite_events first
        FavEvent::where('event_id', $event->event_id)->delete();
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully.']);
    }

    // Search events by keyword
    public function search(Request $request)
    {
        if (!$request->filled('q')) {
            return response()->json(['message' => 'Please provide a search keyword.'], 400);
        }

        $keyword = strtolower($request->input('q'));

        $events = Event::with(['organizer', 'category'])
            ->where(function ($q) use ($keyword) {
                $q->whereRaw('LOWER(title) like ?', ["%$keyword%"])
                  ->orWhereRaw('LOWER(location) like ?', ["%$keyword%"])
                  ->orWhereRaw('LOWER(description) like ?', ["%$keyword%"]);
            })
            ->get();

        if ($events->isEmpty()) {
            return response()->json(['message' => 'No events found.', 'events' => []], 404);
        }

        return response()->json($events);
    }

    // Show all events that the organizer had created (with search, filter, sort)
    public function myEvents(Request $request)
    {
        $organizer = auth('organizer')->user();

        if (!$organizer) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $query = Event::with(['category'])
            ->where('organizer_id', $organizer->organizer_id);

        // Search
        if ($request->has('search') && $request->search) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) like ?', ["%$search%"])
                  ->orWhereRaw('LOWER(location) like ?', ["%$search%"]);
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
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

        return response()->json(['events' => $query->get()]);
    }
}
