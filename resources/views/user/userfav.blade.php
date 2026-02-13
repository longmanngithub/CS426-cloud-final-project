@extends('layouts.app')

@section('title', 'Favorite Events - User Dashboard')

@section('content')
    <section class="bg-gradient-to-br from-[#1a1a2e] via-[#16213e] to-[#0f3460] text-white py-12 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-2"><i class="fas fa-heart mr-2"></i> My Favorites</h1>
        <p class="text-white/80">Events you've saved for later</p>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <section class="w-full">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                <div class="flex justify-between items-center mb-8 pb-6 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold flex items-center gap-2 dark:text-white">
                        <i class="fas fa-heart text-red-500"></i> Saved Events
                    </h2>
                    <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">{{ $favorites->count() }} event(s)</span>
                </div>

                @if($favorites->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($favorites as $favorite)
                    <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col group">
                        <a href="/events/{{ $favorite->event->event_id }}" class="block h-48 overflow-hidden relative">
                            <img src="{{ $favorite->event->picture_url ?? '/images/default-event.jpg' }}" alt="{{ $favorite->event->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </a>
                        <div class="p-5 flex-1 flex flex-col">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-blue-600 mb-3 self-start uppercase">{{ $favorite->event->category->name ?? 'Event' }}</span>
                            <h3 class="text-lg font-bold mb-2 leading-tight">
                                <a href="/events/{{ $favorite->event->event_id }}" class="text-gray-900 dark:text-white hover:text-blue-600 transition-colors no-underline">{{ $favorite->event->title }}</a>
                            </h3>
                            <div class="flex flex-col gap-1.5 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-2"><i class="fas fa-calendar text-blue-500 w-4"></i> {{ \Carbon\Carbon::parse($favorite->event->start_date)->format('d M Y') }}</span>
                                <span class="flex items-center gap-2"><i class="fas fa-clock text-blue-500 w-4"></i> {{ \Carbon\Carbon::parse($favorite->event->start_time)->format('h:i A') ?? 'TBA' }}</span>
                                <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-blue-500 w-4"></i> {{ Str::limit($favorite->event->location, 25) }}</span>
                            </div>

                            <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700 mt-auto">
                                <span class="font-bold text-lg {{ $favorite->event->price == 0 ? 'text-blue-600' : 'text-green-600' }}">
                                    {{ $favorite->event->price == 0 ? 'Free' : '$' . number_format($favorite->event->price, 2) }}
                                </span>
                                <form method="POST" action="{{ route('favorite-events.remove') }}" class="contents">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $favorite->event->event_id }}">
                                    <button type="submit" class="inline-flex items-center gap-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/50 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cursor-pointer border border-transparent hover:border-red-100 dark:hover:border-red-800">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-20 px-4">
                    <div class="w-24 h-24 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center text-4xl text-gray-300 dark:text-gray-600 mx-auto mb-6">
                        <i class="fas fa-heart-broken"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">No Favorite Events Yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">It looks like you haven't saved any events. Explore our listings to find events you'll love!</p>
                    <a href="/events" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition-all hover:shadow-lg hover:-translate-y-1 no-underline">
                        Explore Events <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                @endif
            </div>
        </section>
    </div>
@endsection
