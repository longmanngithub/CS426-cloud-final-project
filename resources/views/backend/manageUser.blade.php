@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">User Management</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">View and manage all registered users.</p>
        </div>
        <div class="flex gap-2">
            <a href="/admin/manageUser" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                <i class="fas fa-user mr-2"></i> Users
            </a>
            <a href="/admin/manageOrganizer" class="inline-flex items-center px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all">
                <i class="fas fa-briefcase mr-2"></i> Organizers
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="relative w-full md:w-96">
                <form action="{{ route('admin.manage_users') }}" method="GET" class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 dark:text-white focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all shadow-sm" placeholder="Search by name, email..." onchange="this.form.submit()">
                </form>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                <span>Total Users: <span class="font-bold text-gray-900 dark:text-white">{{ count($users) }}</span></span>
                @if(request('search'))
                    <a href="{{ route('admin.manage_users') }}" class="text-red-500 hover:text-red-700 text-xs font-bold underline ml-2">Clear Search</a>
                @endif
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="userTable">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Phone Number</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Join Date</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors user-row">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.user_detail', $user->user_id) }}" class="flex items-center group">
                                <div class="shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 font-bold border border-blue-200 dark:border-blue-700 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50 transition-colors">
                                        {{ substr($user->first_name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white user-name group-hover:text-blue-600 transition-colors">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                </div>
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/30">
                                {{ $user->role ?? 'User' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->phone_number ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form id="ban-form-{{ $user->user_id }}" action="{{ route('admin.user.toggle_ban', $user->user_id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="button" onclick="confirmBan('{{ $user->user_id }}', '{{ addslashes($user->first_name . ' ' . $user->last_name) }}', {{ $user->is_banned }})" class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium transition-colors shadow-sm text-white {{ $user->is_banned ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }}">
                                    <i class="fas fa-{{ $user->is_banned ? 'check-circle' : 'ban' }} mr-1.5"></i> {{ $user->is_banned ? 'Unban' : 'Ban' }}
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
            @foreach ($users as $user)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 shadow-sm user-card">
                <div class="flex items-start justify-between">
                    <a href="{{ route('admin.user_detail', $user->user_id) }}" class="flex items-center space-x-3 group">
                        <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 font-bold border border-blue-200 dark:border-blue-700 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50 transition-colors">
                            {{ substr($user->first_name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white user-name group-hover:text-blue-600 transition-colors">{{ $user->first_name }} {{ $user->last_name }}</h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                {{ $user->role ?? 'User' }}
                            </span>
                        </div>
                    </a>
                </div>

                <div class="mt-4 space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center">
                        <i class="fas fa-envelope w-5 text-gray-400"></i>
                        <span class="ml-2 truncate">{{ $user->email }}</span>
                    </div>
                    @if($user->age)
                    <div class="flex items-center">
                        <i class="fas fa-birthday-cake w-5 text-gray-400"></i>
                        <span class="ml-2">{{ $user->age }} years old</span>
                    </div>
                    @endif
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt w-5 text-gray-400"></i>
                        <span class="ml-2">Joined {{ $user->created_at ? $user->created_at->format('M d, Y') : '-' }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-50 dark:border-gray-700 flex justify-end gap-3">
                    <form id="ban-form-mobile-{{ $user->user_id }}" action="{{ route('admin.user.toggle_ban', $user->user_id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="button" onclick="confirmBan('mobile-{{ $user->user_id }}', '{{ addslashes($user->first_name . ' ' . $user->last_name) }}', {{ $user->is_banned }})" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-xs font-medium text-white shadow-sm {{ $user->is_banned ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} transition-colors">
                            <i class="fas fa-{{ $user->is_banned ? 'check-circle' : 'ban' }} mr-1.5"></i> {{ $user->is_banned ? 'Unban' : 'Ban' }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        @if(count($users) == 0)
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <i class="fas fa-users-slash text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">No users found</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Get started by creating a new user or wait for signups.</p>
            </div>
        @endif
    </div>
</div>

@include('backend.partials.modal')

<script>
    function confirmBan(userId, userName, isBanned) {
        const action = isBanned ? 'Unban' : 'Ban';
        const type = isBanned ? 'success' : 'danger';
        const message = isBanned
            ? `Are you sure you want to unban ${userName}? They will be able to log in again.`
            : `Are you sure you want to ban ${userName}? They will no longer be able to log in.`;

        openAdminModal({
            title: `${action} User`,
            message: message,
            type: type,
            formId: `ban-form-${userId}`,
            confirmText: `${action} User`
        });
    }
</script>

@endsection
