@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-8">

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white"><i class="fas fa-user-shield mr-3 text-blue-600"></i>My Profile</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Manage your admin account settings and security.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: User Info (Read Only) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                <div class="mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold flex items-center gap-2 text-gray-900 dark:text-white">
                        <i class="fas fa-id-card text-blue-500"></i> Account Information
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                        <input type="text" value="{{ $admin->first_name }}" readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none cursor-default">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                        <input type="text" value="{{ $admin->last_name }}" readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none cursor-default">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                        <input type="text" value="{{ $admin->email }}" readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none cursor-default">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                        <input type="text" value="{{ $admin->phone_number }}" readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none cursor-default">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($admin->date_of_birth)->format('M d, Y') }}" readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none cursor-default">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <span class="inline-flex items-center px-4 py-3 rounded-lg border border-blue-100 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium w-full">
                            <i class="fas fa-shield-alt mr-2"></i> Administrator
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Change Password -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8 sticky top-24">
                <div class="mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold flex items-center gap-2 text-gray-900 dark:text-white">
                        <i class="fas fa-lock text-blue-500"></i> Change Password
                    </h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg relative text-sm animate-fade-in" role="alert">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg relative text-sm animate-fade-in" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="password" required class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="password_confirmation" required class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg transition-all cursor-pointer">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
