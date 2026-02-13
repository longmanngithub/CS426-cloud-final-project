@extends('layouts.app')

@section('title', 'Event Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Event Management</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Review and moderate all posted events.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
                <!-- Search & Filters Form -->
                <form id="search-form" action="{{ route('admin.manage_events') }}" method="GET" class="flex flex-col md:flex-row flex-1 gap-4 items-stretch md:items-center">
                    <!-- Search -->
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 dark:text-white focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500 sm:text-sm transition-all shadow-sm" placeholder="Search events...">
                    </div>

                    <!-- Category Filter -->
                    <div class="w-full md:w-auto">
                        <select name="category" onchange="this.form.submit()" class="block w-full md:w-48 pl-3 pr-10 py-2.5 text-base border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-xl appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.65em] bg-no-repeat bg-[center_right_1rem]">
                            <option value="">All Categories</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cost Filter -->
                    <div class="w-full md:w-auto">
                        <select name="price_type" onchange="this.form.submit()" class="block w-full md:w-36 pl-3 pr-10 py-2.5 text-base border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-xl appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.65em] bg-no-repeat bg-[center_right_1rem]">
                            <option value="">All Prices</option>
                            <option value="free" {{ request('price_type') == 'free' ? 'selected' : '' }}>Free Only</option>
                            <option value="paid" {{ request('price_type') == 'paid' ? 'selected' : '' }}>Paid Only</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div class="w-full md:w-auto">
                        <select name="sort" onchange="this.form.submit()" class="block w-full md:w-44 pl-3 pr-10 py-2.5 text-base border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-xl appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.65em] bg-no-repeat bg-[center_right_1rem]">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-gray-900 dark:bg-gray-600 text-white py-2.5 px-6 rounded-xl font-semibold text-sm hover:bg-gray-800 dark:hover:bg-gray-500 transition-colors shadow-sm">Filter</button>
                </form>
            </div>

            <!-- Active Filters -->
            @if(request('category') || request('search') || request('price_type') || (request('sort') && request('sort') != 'newest'))
            <div class="flex items-center gap-3 flex-wrap mt-4 pt-4 border-t border-gray-50 dark:border-gray-700">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Active filters:</span>
                @if(request('search'))
                    <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-xs font-medium inline-flex items-center gap-2 border border-blue-100 dark:border-blue-800">
                        "{{ request('search') }}"
                        <button onclick="updateFilter('search', '')" class="hover:text-blue-900 dark:hover:text-blue-100 font-bold text-lg leading-none">&times;</button>
                    </span>
                @endif
                @if(request('category'))
                    @php $activeCategory = \App\Models\Category::find(request('category')); @endphp
                    <span class="bg-pink-50 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300 px-3 py-1 rounded-full text-xs font-medium inline-flex items-center gap-2 border border-pink-100 dark:border-pink-800">
                        {{ $activeCategory->name ?? 'Category' }}
                        <button onclick="updateFilter('category', '')" class="hover:text-pink-900 dark:hover:text-pink-100 font-bold text-lg leading-none">&times;</button>
                    </span>
                @endif
                @if(request('price_type'))
                    <span class="bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 px-3 py-1 rounded-full text-xs font-medium inline-flex items-center gap-2 border border-emerald-100 dark:border-emerald-800">
                        {{ ucfirst(request('price_type')) }}
                        <button onclick="updateFilter('price_type', '')" class="hover:text-emerald-900 dark:hover:text-emerald-100 font-bold text-lg leading-none">&times;</button>
                    </span>
                @endif
                @if(request('sort') && request('sort') != 'newest')
                    <span class="bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 px-3 py-1 rounded-full text-xs font-medium inline-flex items-center gap-2 border border-indigo-100 dark:border-indigo-800">
                        Sort: {{ str_replace('_', ' ', request('sort')) }}
                        <button onclick="updateFilter('sort', 'newest')" class="hover:text-indigo-900 dark:hover:text-indigo-100 font-bold text-lg leading-none">&times;</button>
                    </span>
                @endif
                <a href="{{ route('admin.manage_events') }}" class="text-red-500 text-xs font-bold hover:underline ml-2">Clear all</a>
            </div>
            @endif
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="eventTable">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Event Title</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($events as $event)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors event-row" data-category="{{ $event->category->name ?? 'Uncategorized' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center text-pink-600 border border-pink-200 dark:border-pink-700">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <a href="{{ route('admin.event_detail', $event->event_id) }}" class="text-sm font-bold text-gray-900 dark:text-white event-title hover:text-blue-600 hover:underline">{{ $event->title }}</a>
                                    @if($event->link)
                                        <a href="{{ $event->link }}" target="_blank" class="text-xs text-blue-500 hover:text-blue-700 truncate block max-w-[150px]">{{ $event->link }}</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                {{ $event->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center max-w-[150px]" title="{{ $event->location }}">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-1.5"></i>
                                <span class="truncate">{{ $event->location }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div>{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                            @if($event->price == 0)
                                <span class="text-blue-600">Free</span>
                            @else
                                <span class="text-emerald-600">${{ number_format($event->price, 2) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form id="delete-form-{{ $event->event_id }}" action="{{ url('/admin/deleteEvent/' . $event->event_id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDeleteEvent('{{ $event->event_id }}')" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-xs font-bold text-white bg-red-600 hover:bg-red-700 transition-colors shadow-sm w-full justify-center" title="Delete">
                                    <i class="fas fa-trash-alt mr-1.5"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4 p-4">
            @foreach ($events as $event)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 shadow-sm event-card" data-category="{{ $event->category->name ?? 'Uncategorized' }}">
                <div class="flex items-start justify-between">
                    <a href="{{ route('admin.event_detail', $event->event_id) }}" class="flex items-center space-x-3 group">
                        <div class="h-10 w-10 rounded-lg bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center text-pink-600 border border-pink-200 dark:border-pink-700 group-hover:bg-pink-200 dark:group-hover:bg-pink-800/50 transition-colors">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white event-title group-hover:text-blue-600 transition-colors">{{ $event->title }}</h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                {{ $event->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                    </a>
                </div>

                <div class="mt-4 space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt w-5 text-gray-400"></i>
                        <span class="ml-2">
                            {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                        <span class="ml-2 truncate">{{ $event->location }}</span>
                    </div>
                    @if($event->link)
                    <div class="flex items-center">
                        <i class="fas fa-link w-5 text-gray-400"></i>
                         <a href="{{ $event->link }}" target="_blank" class="text-blue-500 hover:text-blue-700 truncate ml-2">{{ $event->link }}</a>
                    </div>
                    @endif
                </div>

                <div class="mt-4 pt-4 border-t border-gray-50 dark:border-gray-700 flex justify-between items-center gap-3">
                    @if($event->price == 0)
                        <span class="text-xl font-bold text-blue-600">Free</span>
                    @else
                        <span class="text-xl font-bold text-emerald-600">${{ number_format($event->price, 2) }}</span>
                    @endif

                    <form id="delete-form-mobile-{{ $event->event_id }}" action="{{ url('/admin/deleteEvent/' . $event->event_id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDeleteEvent('mobile-{{ $event->event_id }}')" class="inline-flex items-center px-3 py-1.5 border border-red-200 dark:border-red-700 rounded-lg text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition-colors shadow-sm">
                            <i class="fas fa-trash-alt mr-1.5"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        @if(count($events) == 0)
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">No events found</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Events posted by organizers will appear here.</p>
            </div>
        @endif
    </div>
</div>

@include('backend.partials.modal')

<script>
    function confirmDeleteEvent(eventId) {
        openAdminModal({
            title: 'Delete Event',
            message: 'Are you sure you want to delete this event? This action cannot be undone.',
            type: 'danger',
            formId: `delete-form-${eventId}`,
            confirmText: 'Delete Event'
        });
    }

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
@endsection
