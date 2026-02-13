<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class FavoriteEventController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $eventId = $request->input('event_id');
        if (!$user) {
            return back()->with('error', 'You must be logged in to favorite events.');
        }
        $exists = FavoriteEvent::where('user_id', $user->user_id)->where('event_id', $eventId)->exists();
        if (!$exists) {
            FavoriteEvent::create([
                'user_id' => $user->user_id,
                'event_id' => $eventId,
                'favorited_at' => now(),
            ]);
        }
        return back()->with('success', 'Event added to favorites!');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $eventId = $request->input('event_id');
        if (!$user) {
            return back()->with('error', 'You must be logged in to remove favorites.');
        }
        $favorite = FavoriteEvent::where('user_id', $user->user_id)->where('event_id', $eventId)->first();
        if ($favorite) {
            $favorite->delete();
            // Redirect to /userfav if coming from there
            $referer = $request->headers->get('referer');
            if ($referer && str_contains($referer, '/userfav')) {
                return redirect('/userfav')->with('success', 'Event removed from favorites!');
            }
            return back()->with('success', 'Event removed from favorites!');
        }
        return back()->with('error', 'Favorite not found.');
    }
}
