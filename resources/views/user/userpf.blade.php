@extends('layouts.app')

@section('title', 'My Profile - User Dashboard')

@section('content')
    <section class="bg-gradient-to-br from-[#1a1a2e] via-[#16213e] to-[#0f3460] text-white py-12 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-2"><i class="fas fa-user-circle mr-2"></i> My Profile</h1>
        <p class="text-white/80">Manage your account information</p>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <section class="min-h-screen w-full">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                <div class="mb-8 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold flex items-center gap-2 dark:text-white">
                        <i class="fas fa-user-edit text-blue-600"></i> Account Information
                    </h2>
                </div>

                <form id="userProfileForm" method="POST" action="/userpf" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fas fa-user text-blue-500 w-5"></i> First Name <span class="text-red-500">*</span></label>
                        <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all read-only:cursor-default read-only:focus:border-gray-200 dark:read-only:focus:border-gray-600 read-only:focus:ring-0">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fas fa-user text-blue-500 w-5"></i> Last Name <span class="text-red-500">*</span></label>
                        <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}" readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all read-only:cursor-default read-only:focus:border-gray-200 dark:read-only:focus:border-gray-600 read-only:focus:ring-0">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fas fa-birthday-cake text-blue-500 w-5"></i> Date of Birth</label>
                        <input type="text" id="date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('M d, Y') : '' }}" data-date="{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '' }}" readonly class="w-full max-w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all read-only:cursor-default read-only:focus:border-gray-200 dark:read-only:focus:border-gray-600 read-only:focus:ring-0 pointer-events-none appearance-none min-w-0">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fas fa-calendar-alt text-blue-500 w-5"></i> Age</label>
                        <input type="text" id="age" name="age" value="{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->age . ' years old' : 'N/A' }}" disabled readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-400 cursor-not-allowed">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fas fa-phone text-blue-500 w-5"></i> Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ $user->phone_number }}" readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all read-only:cursor-default read-only:focus:border-gray-200 dark:read-only:focus:border-gray-600 read-only:focus:ring-0">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fas fa-id-badge text-blue-500 w-5"></i> Role</label>
                        <input type="text" id="role" name="role" value="User" disabled readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-400 cursor-not-allowed">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fas fa-envelope text-blue-500 w-5"></i> Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" readonly class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all read-only:cursor-default read-only:focus:border-gray-200 dark:read-only:focus:border-gray-600 read-only:focus:ring-0">
                    </div>

                    <div class="md:col-span-2 flex justify-center gap-4 mt-6">
                        <button type="button" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors cursor-pointer" id="editBtn">
                            <i class="fas fa-edit"></i> Edit Profile
                        </button>
                        <button type="button" class="hidden inline-flex items-center gap-2 bg-red-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-600 transition-colors cursor-pointer" id="cancelBtn">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="hidden inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors cursor-pointer" id="saveBtn">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8 mt-8">
                <div class="mb-8 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold flex items-center gap-2 dark:text-white">
                        <i class="fas fa-lock text-blue-600"></i> Security
                    </h2>
                </div>

                @if (session('success') && str_contains(session('success'), 'Password'))
                    <div class="mb-6 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg relative text-sm" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('current_password'))
                    <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg relative text-sm" role="alert">
                        {{ $errors->first('current_password') }}
                    </div>
                @endif


                @if ($errors->has('password'))
                    <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg relative text-sm" role="alert">
                        {{ $errors->first('password') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('user.updatePassword') }}" class="space-y-6 max-w-2xl">
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

                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors cursor-pointer">
                        Change Password
                    </button>
                </form>
            </div>
        </section>
    </div>

    <script>
        const editBtn = document.getElementById('editBtn');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const form = document.getElementById('userProfileForm');
        const inputs = form.querySelectorAll('input:not([disabled])');

        let originalValues = {};

        editBtn.addEventListener('click', function() {
            // Save original values
            inputs.forEach(input => {
                originalValues[input.id] = input.value;
            });

            // Enable inputs
            inputs.forEach(input => {
                input.removeAttribute('readonly');
                // Remove readonly styles
                input.classList.remove('bg-gray-50', 'text-gray-500', 'dark:bg-gray-700', 'dark:text-gray-400');
                input.classList.add('bg-white', 'text-gray-900', 'dark:bg-gray-600', 'dark:text-white');
            });

            editBtn.classList.add('hidden');
            saveBtn.classList.remove('hidden');
            cancelBtn.classList.remove('hidden');

            // Handle switching Date of Birth to date input
            const dobInput = document.getElementById('date_of_birth');
            dobInput.classList.remove('pointer-events-none');
            // Store the display text value if not already stored in originalValues (it is by logic below)
            // But we need to switch type and value for editing
            originalValues['dob_display'] = dobInput.value; // Store "Jan 1, 2000"
            dobInput.type = 'date';
            dobInput.value = dobInput.dataset.date; // Set "2000-01-01"
        });

        cancelBtn.addEventListener('click', function() {
            // Revert changes
            inputs.forEach(input => {
                // handle special logic for DOB which changes type
                if(input.id === 'date_of_birth') return;

                if (originalValues[input.id] !== undefined) {
                    input.value = originalValues[input.id];
                }
                input.setAttribute('readonly', true);
                input.classList.add('bg-gray-50', 'text-gray-500', 'dark:bg-gray-700', 'dark:text-gray-400');
                input.classList.remove('bg-white', 'text-gray-900', 'dark:bg-gray-600', 'dark:text-white');
            });

            // Revert DOB manually
            const dobInput = document.getElementById('date_of_birth');
            dobInput.type = 'text';
            dobInput.value = originalValues['dob_display']; // Restore "Jan 1, 2000"
            dobInput.setAttribute('readonly', true);
            dobInput.classList.add('bg-gray-50', 'text-gray-500', 'pointer-events-none', 'dark:bg-gray-700', 'dark:text-gray-400');
            dobInput.classList.remove('bg-white', 'text-gray-900', 'dark:bg-gray-600', 'dark:text-white');

            editBtn.classList.remove('hidden');
            saveBtn.classList.add('hidden');
            cancelBtn.classList.add('hidden');
        });
    </script>
@endsection
