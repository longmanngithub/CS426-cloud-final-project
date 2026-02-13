@extends('layouts.app')

@section('title', 'My Events - Organizer Dashboard')

@section('content')
    <section class="bg-gradient-to-br from-[#1a1a2e] via-[#16213e] to-[#0f3460] text-white py-12 text-center relative overflow-hidden">
        <div class="relative z-10 px-4">
            <h1 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-md"><i class="fas fa-calendar-check mr-3"></i> My Events</h1>
            <p class="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Manage and track all your posted events in one place</p>

            <a href="/orgpostevents" class="inline-flex items-center gap-2 bg-white text-blue-900 px-6 py-3 rounded-full text-sm font-bold hover:bg-blue-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 no-underline">
                <i class="fas fa-plus-circle text-lg"></i> Create New Event
            </a>
        </div>
    </section>

    <div class="py-12 pb-20">
        <div class="max-w-7xl mx-auto px-4">

            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 p-4 md:p-6 rounded-xl shadow-sm mb-8 flex flex-col md:flex-row gap-4 items-stretch md:items-center border border-gray-100 dark:border-gray-700">
                <form id="search-form" class="contents" method="GET" action="/orgmyevents">
                    <div class="flex-1 min-w-[200px] relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" placeholder="Search your events..." value="{{ request('search') }}" class="w-full py-3 pl-11 pr-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:outline-none focus:border-blue-500 transition-colors dark:placeholder-gray-500">
                    </div>
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

                <button type="submit" form="search-form" class="bg-blue-600 text-white py-3 px-8 rounded-lg font-semibold text-sm hover:bg-blue-700 transition-colors cursor-pointer w-full md:w-auto shadow-sm">Search</button>
            </div>

            <!-- Active Filters -->
            @if(request('category') || request('search') || request('price_type'))
            <div class="flex items-center gap-3 flex-wrap mb-6 px-1">
                <span class="text-sm text-gray-500 dark:text-gray-400">Active filters:</span>
                @if(request('category'))
                    @php $activeCategory = \App\Models\Category::find(request('category')); @endphp
                    <span class="bg-blue-600 text-white px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-2">
                        {{ $activeCategory->name ?? 'Category' }}
                        <a href="#" onclick="updateFilter('category', '')" class="text-white hover:text-white/80 font-bold text-base leading-none">&times;</a>
                    </span>
                @endif
                @if(request('search'))
                    <span class="bg-green-600 text-white px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-2">
                        "{{ request('search') }}"
                        <a href="#" onclick="updateFilter('search', '')" class="text-white hover:text-white/80 font-bold text-base leading-none">&times;</a>
                    </span>
                @endif
                @if(request('price_type'))
                    <span class="bg-purple-600 text-white px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-2">
                        {{ ucfirst(request('price_type')) }}
                        <a href="#" onclick="updateFilter('price_type', '')" class="text-white hover:text-white/80 font-bold text-base leading-none">&times;</a>
                    </span>
                @endif
                <a href="/orgmyevents" class="text-red-500 text-sm hover:underline font-medium ml-2">Clear all</a>
            </div>
            @endif

                @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                    <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col group">
                        <a href="/events/{{ $event->event_id }}" class="block h-48 overflow-hidden relative">
                            <img src="{{ $event->picture_url ?? '/images/default-event.jpg' }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </a>
                        <div class="p-5 flex-1 flex flex-col">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-blue-600 mb-3 self-start uppercase">{{ $event->category->name ?? 'Event' }}</span>
                            <h3 class="text-lg font-bold mb-2 leading-tight">
                                <a href="/events/{{ $event->event_id }}" class="text-gray-900 dark:text-white hover:text-blue-600 transition-colors no-underline">{{ $event->title }}</a>
                            </h3>
                            <div class="flex flex-col gap-1.5 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-2"><i class="fas fa-calendar text-blue-500 w-4"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                                <span class="flex items-center gap-2"><i class="fas fa-clock text-blue-500 w-4"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') ?? 'TBA' }}</span>
                                <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-blue-500 w-4"></i> {{ Str::limit($event->location, 25) }}</span>
                            </div>

                            <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700 mt-auto">
                                <span class="font-bold text-lg {{ $event->price == 0 ? 'text-blue-600' : 'text-green-600' }}">
                                    {{ $event->price == 0 ? 'Free' : '$' . number_format($event->price, 2) }}
                                </span>
                                <div class="flex gap-2">
                                    <a href="/events/{{ $event->event_id }}/edit" class="inline-flex items-center gap-1 px-3 py-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors text-sm font-medium" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="/events/{{ $event->event_id }}" method="POST" class="contents" id="delete-form-{{ $event->event_id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="inline-flex items-center gap-1 px-3 py-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/50 rounded-lg transition-colors cursor-pointer text-sm font-medium" title="Delete" onclick="openDeleteModal('delete-form-{{ $event->event_id }}')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-20 px-4">
                    <div class="w-24 h-24 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center text-4xl text-gray-300 dark:text-gray-600 mx-auto mb-6">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">No Events Yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">You haven't posted any events. Start reaching your audience today!</p>
                    <a href="/orgpostevents" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition-all hover:shadow-lg hover:-translate-y-1 no-underline">
                        <i class="fas fa-plus"></i> Create Your First Event
                    </a>
                </div>
                @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div id="modalBackdrop" class="fixed inset-0 bg-black/20 transition-opacity duration-300 opacity-0 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div id="modalPanel" class="relative transform overflow-hidden rounded-2xl sm:rounded-[32px] bg-white dark:bg-gray-800 text-left shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 opacity-0 scale-90 w-[90%] mx-auto sm:w-full sm:max-w-[420px]">
                    <div class="p-6 sm:p-8 text-center bg-white dark:bg-gray-800">
                        <div class="mx-auto flex h-16 w-16 sm:h-20 sm:w-20 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50 mb-5 sm:mb-6">
                            <i class="fas fa-trash-alt text-red-500 text-2xl sm:text-3xl"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold leading-tight text-gray-900 dark:text-white mb-2 sm:mb-3 tracking-tight" id="modal-title">Delete Event</h3>
                        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 leading-relaxed max-w-[260px] sm:max-w-[300px] mx-auto">
                            Are you sure you want to delete this event? This action cannot be undone.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-5 pb-5 sm:px-6 sm:pb-6 flex flex-col gap-3">
                        <button type="button" id="confirmDeleteBtn" class="w-full inline-flex justify-center items-center rounded-xl sm:rounded-2xl bg-[#FF3B30] px-4 py-3.5 sm:py-4 text-base sm:text-lg font-bold text-white shadow-sm hover:bg-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-transform active:scale-95">
                                Delete Event
                        </button>
                        <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center items-center rounded-xl sm:rounded-2xl bg-gray-100 dark:bg-gray-700 px-4 py-3.5 sm:py-4 text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-transform active:scale-95">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteFormId = null;

        function openDeleteModal(formId) {
            deleteFormId = formId;
            const modal = document.getElementById('deleteModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');

            modal.classList.remove('hidden');
            void modal.offsetWidth;

            backdrop.classList.remove('opacity-0');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');

            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');

            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'scale-100');
            panel.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                deleteFormId = null;
                document.body.style.overflow = '';
            }, 300);
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteFormId) {
                const btn = this;
                btn.classList.add('opacity-75', 'cursor-wait');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Deleting...';
                btn.disabled = true;

                document.getElementById(deleteFormId).submit();
            }
        });

        function updateFilter(key, value) {
            const url = new URL(window.location.href);
            if (value) {
                url.searchParams.set(key, value);
            } else {
                url.searchParams.delete(key);
            }
            window.location.href = url.toString();
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
@endsection
