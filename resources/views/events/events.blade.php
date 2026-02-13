@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <section class="relative w-full h-[280px] sm:h-auto sm:py-20 overflow-hidden flex justify-center items-center text-white text-center bg-gradient-to-br from-[#1a1a2e] via-[#16213e] to-[#0f3460]">
        <div class="absolute inset-0 bg-[url('/images/events-hero.png')] bg-cover bg-center opacity-20"></div>
        <div class="relative z-10 px-4">
            <h1 class="text-3xl md:text-5xl font-bold mb-2 drop-shadow-md">Discover Events</h1>
            <p class="text-lg text-white/90">Find amazing events happening near you</p>
        </div>
    </section>

    <div class="py-12 pb-20">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 p-4 md:p-6 rounded-xl shadow-sm mb-8 flex flex-col md:flex-row gap-4 items-stretch md:items-center">
                <form id="search-form" class="contents" method="GET" action="/events">
                    <div class="flex-1 min-w-[200px] relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" placeholder="Search events..." value="{{ request('search') }}" class="w-full py-3 pl-11 pr-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:outline-none focus:border-blue-500 transition-colors dark:placeholder-gray-500">
                    </div>
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="price_type" value="{{ request('price_type') }}">
                </form>

                <div class="w-full md:w-auto">
                    <select id="category-select" onchange="updateFilter('category', this.value)" class="w-full md:w-[180px] py-3 pl-4 pr-10 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm bg-white cursor-pointer focus:outline-none focus:border-blue-500 appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.65em] bg-no-repeat bg-[center_right_1rem]">
                        <option value="">All Categories</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-auto">
                    <select id="sort-select" onchange="updateFilter('sort', this.value)" class="w-full md:w-[180px] py-3 pl-4 pr-10 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm bg-white cursor-pointer focus:outline-none focus:border-blue-500 appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.65em] bg-no-repeat bg-[center_right_1rem]">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>

                <div class="w-full md:w-auto">
                    <select id="cost-select" onchange="updateFilter('price_type', this.value)" class="w-full md:w-[150px] py-3 pl-4 pr-10 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm bg-white cursor-pointer focus:outline-none focus:border-blue-500 appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.65em] bg-no-repeat bg-[center_right_1rem]">
                        <option value="">All Prices</option>
                        <option value="free" {{ request('price_type') == 'free' ? 'selected' : '' }}>Free Only</option>
                        <option value="paid" {{ request('price_type') == 'paid' ? 'selected' : '' }}>Paid Only</option>
                    </select>
                </div>

                <button type="submit" form="search-form" class="bg-blue-600 text-white py-3 px-8 rounded-lg font-semibold text-sm hover:bg-blue-700 transition-colors cursor-pointer w-full md:w-auto">Search</button>
            </div>

            <script>
                function updateFilter(key, value) {
                    const url = new URL(window.location.href);
                    if (value) {
                        url.searchParams.set(key, value);
                    } else {
                        url.searchParams.delete(key);
                    }
                    window.location.href = url.toString();
                }
            </script>

            <!-- Active Filters -->
            @if(request('category') || request('search'))
            <div class="flex items-center gap-3 flex-wrap mb-6">
                <span class="text-sm text-gray-500 dark:text-gray-400">Active filters:</span>
                @if(request('category'))
                    @php $activeCategory = \App\Models\Category::find(request('category')); @endphp
                    <span class="bg-blue-600 text-white px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-2">
                        {{ $activeCategory->name ?? 'Category' }}
                        <a href="{{ request('search') ? '/events?search=' . request('search') : '/events' }}" class="text-white hover:text-white/80 font-bold text-base leading-none">&times;</a>
                    </span>
                @endif
                @if(request('search'))
                    <span class="bg-green-600 text-white px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-2">
                        "{{ request('search') }}"
                        <a href="{{ request('category') ? '/events?category=' . request('category') : '/events' }}" class="text-white hover:text-white/80 font-bold text-base leading-none">&times;</a>
                    </span>
                @endif
                <a href="/events" class="text-red-500 text-sm hover:underline">Clear all</a>
            </div>
            @endif

            <!-- Events Grid or Empty State -->
            @if($events->isEmpty())
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                <i class="fas fa-calendar-times text-5xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                <h3 class="text-xl text-gray-600 dark:text-gray-300 mb-2">No events found</h3>
                <p class="text-gray-400 mb-4">Try adjusting your search or filters</p>
                <a href="/events" class="text-blue-600 hover:underline">View all events &rarr;</a>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex flex-col h-full group">
                    <a href="/events/{{ $event->event_id }}" class="block overflow-hidden h-48">
                        <img src="{{ $event->picture_url ?? '/images/default-event.jpg' }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </a>
                    <div class="p-5 flex-1 flex flex-col">
                        <span class="inline-block bg-blue-50 dark:bg-blue-900/30 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold mb-3 uppercase self-start">{{ $event->category->name ?? 'Event' }}</span>
                        <h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100 leading-tight">
                            <a href="/events/{{ $event->event_id }}" class="hover:text-blue-600 transition-colors">{{ $event->title }}</a>
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-4 line-clamp-2">{{ Str::limit($event->description, 80) }}</p>

                        <div class="flex flex-col gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4 mt-auto">
                            <span class="flex items-center gap-2"><i class="fas fa-calendar text-blue-500 w-4"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                            <span class="flex items-center gap-2"><i class="fas fa-clock text-blue-500 w-4"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</span>
                            <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-blue-500 w-4"></i> {{ Str::limit($event->location, 30) }}</span>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700 mt-auto">
                            <span class="font-bold text-lg {{ $event->price == 0 ? 'text-blue-600' : 'text-green-600' }}">
                                {{ $event->price == 0 ? 'Free' : '$' . number_format($event->price, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
@endsection
