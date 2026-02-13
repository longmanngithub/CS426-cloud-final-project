@extends('layouts.app')

@section('title', $user->first_name . ' ' . $user->last_name . ' - User Details')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen pb-12">
    <div class="max-w-7xl mx-auto px-4 pt-8">
        <a href="{{ route('admin.manage_users') }}" class="inline-flex items-center gap-2 text-blue-600 font-medium py-4 hover:underline mb-4">
            <i class="fas fa-arrow-left"></i> Back to User Management
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: User Profile Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center border border-gray-100 dark:border-gray-700">
                    <div class="w-24 h-24 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 text-3xl font-bold border-4 border-white dark:border-gray-700 shadow-md mx-auto mb-4">
                        {{ substr($user->first_name, 0, 1) }}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 mt-2 border border-blue-100 dark:border-blue-800">
                        {{ $user->role ?? 'User' }}
                    </span>

                    <div class="mt-8 grid grid-cols-1 gap-3 text-left">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-envelope w-6 text-gray-400"></i>
                            <span class="ml-2 truncate">{{ $user->email }}</span>
                        </div>
                        @if($user->phone_number)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-phone w-6 text-gray-400"></i>
                            <span class="ml-2">{{ $user->phone_number }}</span>
                        </div>
                        @endif
                        @if($user->age)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-birthday-cake w-6 text-gray-400"></i>
                            <span class="ml-2">{{ $user->age }} years old</span>
                        </div>
                        @endif
                        @if($user->date_of_birth)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-calendar-alt w-6 text-gray-400"></i>
                            <span class="ml-2">DOB: {{ \Carbon\Carbon::parse($user->date_of_birth)->format('M d, Y') }}</span>
                        </div>
                        @endif
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-user-clock w-6 text-gray-400"></i>
                            <span class="ml-2">Member Since: {{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700 grid grid-cols-1 gap-3">
                        <form id="ban-user-form" action="{{ route('admin.user.toggle_ban', $user->user_id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="button" onclick="confirmBan({{ $user->is_banned ? 1 : 0 }})" class="w-full flex items-center justify-center gap-2 bg-{{ $user->is_banned ? 'green' : 'red' }}-600 hover:bg-{{ $user->is_banned ? 'green' : 'red' }}-700 text-white rounded-lg py-3 font-semibold transition-all shadow-sm">
                                <i class="fas fa-{{ $user->is_banned ? 'check-circle' : 'ban' }}"></i> {{ $user->is_banned ? 'Unban User' : 'Ban User' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Activity / Favorites -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fas fa-heart text-red-500"></i> Favorite Events
                        </h3>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $user->favorites->count() }} items</span>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($user->favorites as $favorite)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12 rounded-lg bg-gray-100 dark:bg-gray-700 overflow-hidden flex-shrink-0">
                                        <img src="{{ $favorite->event->picture_url ?? '/images/default-event.jpg' }}" alt="" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                            <a href="{{ route('admin.event_detail', $favorite->event->event_id) }}">{{ $favorite->event->title }}</a>
                                        </h4>
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ \Carbon\Carbon::parse($favorite->event->start_date)->format('M d, Y') }}
                                            <span class="mx-2">&bull;</span>
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ Str::limit($favorite->event->location, 30) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-bold px-2 py-0.5 bg-gray-50 dark:bg-gray-700 rounded shadow-sm {{ $favorite->event->price == 0 ? 'text-blue-600' : 'text-emerald-600' }}">
                                        {{ $favorite->event->price == 0 ? 'Free' : '$' . number_format($favorite->event->price, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="far fa-heart text-gray-300 dark:text-gray-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">This user hasn't favorited any events yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.partials.modal')

<script>
    function confirmBan(isBanned) {
        const action = isBanned ? 'Unban' : 'Ban';
        const type = isBanned ? 'success' : 'danger';
        const userName = "{{ addslashes($user->first_name . ' ' . $user->last_name) }}";
        const message = isBanned
            ? `Are you sure you want to unban ${userName}? They will be able to log in again.`
            : `Are you sure you want to ban ${userName}? They will no longer be able to log in.`;

        openAdminModal({
            title: `${action} User`,
            message: message,
            type: type,
            formId: 'ban-user-form',
            confirmText: `${action} User`
        });
    }
</script>
@endsection
