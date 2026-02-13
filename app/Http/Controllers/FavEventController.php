<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavEvent;
use App\Models\Event;
use Carbon\Carbon;

class FavEventController extends Controller
{
    // User add an event to favorites
    public function store(Request $request)
    {
        $user = auth('user')->user();

        $request->validate([
            'event_id' => 'required|exists:events,event_id',
        ]);

        $alreadyFavorited = FavEvent::where('user_id', $user->user_id)
            ->where('event_id', $request->event_id)
            ->exists();

        if ($alreadyFavorited) {
            return response()->json(['message' => 'Event is already favorited.'], 409);
        }

        $favorite = FavEvent::create([
            'user_id' => $user->user_id,
            'event_id' => $request->event_id,
            'favorited_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Event added to favorites.',
            'favorite' => $favorite,
        ], 201);
    }

    // User remove the favorite event
    public function destroy($event_id)
    {
        $user = auth('user')->user();

        $favorite = FavEvent::where('user_id', $user->user_id)
            ->where('event_id', $event_id)
            ->first();

        if (!$favorite) {
            return response()->json(['message' => 'Favorite not found.'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Event removed from favorites.']);
    }

    // List all favorite events for authenticated user
    public function index()
    {
        $user = auth('user')->user();

        $favorites = FavEvent::with('event.organizer', 'event.category')
            ->where('user_id', $user->user_id)
            ->get();

        return response()->json($favorites);
    }
}
