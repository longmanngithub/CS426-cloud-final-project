@extends('layouts.app')

@section('title', ($organizer->organization_name ?? $organizer->first_name . ' ' . $organizer->last_name) . ' - Organizer Details')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen pb-12">
    <div class="max-w-7xl mx-auto px-4 pt-8">
        <a href="{{ route('admin.manage_organizers') }}" class="inline-flex items-center gap-2 text-blue-600 font-medium py-4 hover:underline mb-4">
            <i class="fas fa-arrow-left"></i> Back to Organizer Management
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Organizer Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center border border-gray-100 dark:border-gray-700">
                    <div class="w-24 h-24 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 text-3xl font-bold border-4 border-white dark:border-gray-700 shadow-md mx-auto mb-4">
                        {{ substr($organizer->first_name, 0, 1) }}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $organizer->first_name }} {{ $organizer->last_name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $organizer->organization_name ?? 'Individual Organizer' }}</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 mt-4 border border-purple-100 dark:border-purple-800">
                        Organizer Account
                    </span>

                    <div class="mt-8 grid grid-cols-1 gap-3 text-left">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-envelope w-6 text-gray-400"></i>
                            <span class="ml-2 truncate">{{ $organizer->email }}</span>
                        </div>
                        @if($organizer->phone_number)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-phone w-6 text-gray-400"></i>
                            <span class="ml-2">{{ $organizer->phone_number }}</span>
                        </div>
                        @endif
                        @if($organizer->website)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-globe w-6 text-gray-400"></i>
                            <a href="{{ $organizer->website }}" target="_blank" class="ml-2 text-blue-600 hover:underline truncate">{{ $organizer->website }}</a>
                        </div>
                        @endif
                        @if($organizer->business_reg_no)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-id-card w-6 text-gray-400"></i>
                            <span class="ml-2">Reg: {{ $organizer->business_reg_no }}</span>
                        </div>
                        @endif
                        @if($organizer->company_name)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-building w-6 text-gray-400"></i>
                            <span class="ml-2">{{ $organizer->company_name }}</span>
                        </div>
                        @endif
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-calendar-alt w-6 text-gray-400"></i>
                            <span class="ml-2">Joined on: {{ $organizer->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700 grid grid-cols-1 gap-3">
                        <form id="ban-organizer-form" action="{{ route('admin.organizer.toggle_ban', $organizer->organizer_id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="button" onclick="confirmBanOrganizer('{{ $organizer->organizer_id }}', '{{ addslashes($organizer->organization_name ?? $organizer->first_name . ' ' . $organizer->last_name) }}', {{ $organizer->is_banned }})" class="w-full flex items-center justify-center gap-2 bg-{{ $organizer->is_banned ? 'green' : 'red' }}-600 hover:bg-{{ $organizer->is_banned ? 'green' : 'red' }}-700 text-white rounded-lg py-3 font-semibold transition-all shadow-sm">
                                <i class="fas fa-{{ $organizer->is_banned ? 'check-circle' : 'ban' }}"></i> {{ $organizer->is_banned ? 'Unban Organizer' : 'Ban Organizer' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Organized Events -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fas fa-calendar-check text-purple-500"></i> Organized Events
                        </h3>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $organizer->events->count() }} events posted</span>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($organizer->events as $event)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12 rounded-lg bg-gray-100 dark:bg-gray-700 overflow-hidden flex-shrink-0">
                                        <img src="{{ $event->picture_url ?? '/images/default-event.jpg' }}" alt="" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                            <a href="{{ route('admin.event_detail', $event->event_id) }}">{{ $event->title }}</a>
                                        </h4>
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                            <span class="mx-2">&bull;</span>
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ Str::limit($event->location, 30) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-bold px-3 py-1 bg-gray-50 dark:bg-gray-700 rounded-lg {{ $event->price == 0 ? 'text-blue-600' : 'text-emerald-600' }}">
                                        {{ $event->price == 0 ? 'Free' : '$' . number_format($event->price, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="far fa-calendar text-gray-300 dark:text-gray-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">This organizer hasn't posted any events yet.</p>
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
    function confirmBanOrganizer(orgId, orgName, isBanned) {
        const action = isBanned ? 'Unban' : 'Ban';
        const type = isBanned ? 'success' : 'danger';
        const message = isBanned
            ? `Are you sure you want to unban ${orgName}? They will be able to log in and manage events again.`
            : `Are you sure you want to ban ${orgName}? They will no longer be able to log in or manage events.`;

        openAdminModal({
            title: `${action} Organizer`,
            message: message,
            type: type,
            formId: `ban-organizer-form`,
            confirmText: `${action} Organizer`
        });
    }
</script>
@endsection
