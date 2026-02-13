@extends('layouts.app')

@section('title', $event->title . ' - Local Events Discovery')

@section('content')
    <!-- Hero Section with Event Image -->
    <section class="relative w-full h-[350px] overflow-hidden flex justify-center items-end text-white">
        <img src="{{ $event->picture_url ?? '/images/default-event.jpg' }}" alt="{{ $event->title }}" class="absolute top-0 left-0 w-full h-full object-cover brightness-[0.4]">
        <div class="relative z-10 w-full p-8 bg-gradient-to-t from-black/80 to-transparent">
            <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-between items-end gap-4">
                <div>
                    <h1 class="text-3xl md:text-5xl font-bold mb-2 drop-shadow-md">{{ $event->title }}</h1>
                    <div class="flex flex-wrap gap-6 text-lg opacity-95">
                        <span class="flex items-center gap-2"><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}@if($event->end_date && $event->end_date != $event->start_date) - {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}@endif</span>
                        <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="py-8 pb-16">
        <div class="max-w-7xl mx-auto px-4">
            <a href="/events" class="inline-flex items-center gap-2 text-blue-600 font-medium py-4 hover:underline mb-4">
                <i class="fas fa-arrow-left"></i> Back to Events
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 md:p-8">
                        <span class="inline-block bg-blue-50 dark:bg-blue-900/30 text-blue-600 px-4 py-1.5 rounded-full text-sm font-semibold mb-6 uppercase">{{ $event->category->name ?? 'Event' }}</span>

                        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-600"></i> About This Event
                        </h2>
                        <p class="leading-relaxed text-gray-600 dark:text-gray-400 mb-8 whitespace-pre-line">{{ $event->description ?? 'No description available.' }}</p>

                        <div class="mt-6 border-t border-gray-100 dark:border-gray-700 pt-6">
                            <div class="flex items-center py-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-blue-600 text-lg mr-4 flex-shrink-0">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-medium">Date</div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-100">{{ \Carbon\Carbon::parse($event->start_date)->format('l, d M Y') }}@if($event->end_date && $event->end_date != $event->start_date) - {{ \Carbon\Carbon::parse($event->end_date)->format('l, d M Y') }}@endif</div>
                                </div>
                            </div>
                            <div class="flex items-center py-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-blue-600 text-lg mr-4 flex-shrink-0">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-medium">Time</div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('h:i A') : 'N/A' }}@if($event->end_time) - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}@endif</div>
                                </div>
                            </div>
                            <div class="flex items-center py-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-blue-600 text-lg mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-medium">Location</div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $event->location ?? 'N/A' }}</div>
                                </div>
                            </div>
                            @if($event->link)
                            <div class="flex items-center py-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-blue-600 text-lg mr-4 flex-shrink-0">
                                    <i class="fas fa-external-link-alt"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-medium">Event Link</div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-100"><a href="{{ $event->link }}" target="_blank" class="text-blue-600 hover:underline">{{ Str::limit($event->link, 40) }}</a></div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Price & Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center">
                        <div class="text-4xl font-bold mb-2 {{ $event->price == 0 ? 'text-blue-600' : 'text-green-600' }}">
                            {{ $event->price == 0 ? 'Free' : '$' . number_format($event->price, 2) }}
                        </div>
                        <div class="text-gray-400 text-sm mb-6">{{ $event->price == 0 ? 'No registration fee' : 'Registration fee' }}</div>

                        @if(Auth::user())
                            @php
                                $isFavorited = Auth::user()->favorites()->where('event_id', $event->event_id)->exists();
                            @endphp
                            @if(!$isFavorited)
                                <form method="POST" action="{{ route('favorite-events.add') }}">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-white dark:bg-gray-800 text-red-500 border-2 border-red-500 rounded-lg py-3 font-semibold text-lg hover:bg-red-500 hover:text-white transition-all cursor-pointer">
                                        <i class="fa-regular fa-heart"></i> Add to Favorites
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('favorite-events.remove') }}">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-500 text-white border-2 border-red-500 rounded-lg py-3 font-semibold text-lg hover:bg-red-600 hover:border-red-600 transition-all cursor-pointer">
                                        <i class="fa-solid fa-heart"></i> Remove from Favorites
                                    </button>
                                </form>
                            @endif
                        @endif

                        @if($event->link)
                        <a href="{{ $event->link }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white rounded-lg py-3 font-semibold text-lg hover:bg-blue-700 transition-colors mt-4 no-underline">
                            <i class="fas fa-external-link-alt"></i> Register Now
                        </a>
                        @endif
                    </div>

                    <!-- Organizer Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100 flex items-center gap-2"><i class="fas fa-user-tie text-gray-400"></i> Organizer</h3>
                        <div class="flex flex-col gap-4">
                            <div class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                {{ $event->organizer->organization_name ?? ($event->organizer->first_name . ' ' . $event->organizer->last_name) }}
                            </div>
                            <div class="flex flex-col gap-2 text-sm text-gray-600 dark:text-gray-400">
                                @if($event->organizer->email)
                                <span class="flex items-center gap-2"><i class="fas fa-envelope text-gray-400 w-5"></i> <a href="mailto:{{ $event->organizer->email }}" class="text-blue-600 hover:underline">{{ $event->organizer->email }}</a></span>
                                @endif
                                @if($event->organizer->phone_number)
                                <span class="flex items-center gap-2"><i class="fas fa-phone text-gray-400 w-5"></i> <a href="tel:{{ $event->organizer->phone_number }}" class="text-blue-600 hover:underline">{{ $event->organizer->phone_number }}</a></span>
                                @endif
                                @if($event->organizer->website)
                                <span class="flex items-center gap-2"><i class="fas fa-globe text-gray-400 w-5"></i> <a href="{{ $event->organizer->website }}" target="_blank" class="text-blue-600 hover:underline">Website</a></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
