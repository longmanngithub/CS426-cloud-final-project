@extends('layouts.app')

@section('title', 'Sign Up - Organizer')

@section('hide-global-errors', true)

@section('content')
    <div class="flex items-center justify-center py-16 px-4 min-h-[calc(100vh-80px)] bg-gradient-to-br from-gray-50 to-gray-200 dark:from-gray-900 dark:to-gray-800">
        <div class="bg-white dark:bg-gray-800 w-full max-w-3xl rounded-2xl shadow-xl overflow-hidden relative">
            <div class="bg-[#1a1a2e] text-white p-8 text-center">
                <h2 class="text-3xl font-bold m-0">Organizer Registration</h2>
                <p class="mt-2 opacity-80 text-base">Start managing events and growing your audience</p>
            </div>

            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg relative text-sm" role="alert">
                        <ul class="list-disc list-inside m-0 pl-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg relative text-sm" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="/organizer/register">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-6 space-y-0 text-left">
                        <div class="col-span-1 md:col-span-2 text-lg font-semibold text-[#1a1a2e] dark:text-white mt-4 mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                            <i class="fas fa-building text-blue-600"></i> Organization Details
                        </div>

                        <div class="space-y-2 col-span-1 md:col-span-2">
                            <label for="organization-name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Organization Name <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="text" id="organization-name" name="organization_name" class="w-full py-3.5 pl-11 pr-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all box-border" placeholder="Organization / Group Name" required>
                            </div>
                        </div>

                        <div class="space-y-2 min-w-0">
                            <label for="company-name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Company Name</label>
                            <div class="relative">
                                <i class="fas fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="text" id="company-name" name="company_name" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg py-3.5 pl-11 pr-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border text-base" placeholder="Registered Company Name (Optional)">
                            </div>
                        </div>

                        <div class="space-y-2 min-w-0">
                            <label for="business-reg-no" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Business Reg. No.</label>
                            <div class="relative">
                                <i class="fas fa-file-contract absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="text" id="business-reg-no" name="business_reg_no" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg py-3.5 pl-11 pr-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border text-base" placeholder="e.g., KHR12345">
                            </div>
                        </div>

                        <div class="space-y-2 col-span-1 md:col-span-2">
                            <label for="website" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Website</label>
                            <div class="relative">
                                <i class="fas fa-globe absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="text" id="website" name="website" class="w-full min-w-0 py-3.5 pl-11 pr-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all box-border" placeholder="https://www.yourorganization.com">
                            </div>
                        </div>

                        <div class="col-span-1 md:col-span-2 text-lg font-semibold text-[#1a1a2e] dark:text-white mt-4 mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                            <i class="fas fa-user-shield text-blue-600"></i> Administrator Details
                        </div>

                        <div class="space-y-2 min-w-0">
                            <label for="first-name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">First Name <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="text" id="first-name" name="first_name" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg py-3.5 pl-11 pr-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border text-base" placeholder="Admin First Name" required>
                            </div>
                        </div>

                        <div class="space-y-2 min-w-0">
                            <label for="last-name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Last Name <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="text" id="last-name" name="last_name" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg py-3.5 pl-11 pr-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border text-base" placeholder="Admin Last Name" required>
                            </div>
                        </div>

                        <div class="space-y-2 min-w-0">
                            <label for="date-of-birth" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Date of Birth <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="text" id="date-of-birth" name="date_of_birth" placeholder="Date of Birth" onfocus="(this.type='date')" onblur="(this.value ? this.type='date' : this.type='text')" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg py-3.5 pl-11 pr-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border text-base" required>
                            </div>
                        </div>

                         <div class="space-y-2 min-w-0">
                            <label for="phone-number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Phone Number</label>
                            <div class="relative">
                                <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="tel" id="phone-number" name="phone_number" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg py-3.5 pl-11 pr-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border text-base" placeholder="+855...">
                            </div>
                        </div>

                        <!-- Hidden Role Field -->
                        <input type="hidden" name="role" value="Organizer">

                        <div class="col-span-1 md:col-span-2 text-lg font-semibold text-[#1a1a2e] dark:text-white mt-4 mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                            <i class="fas fa-lock text-blue-600"></i> Account Credentials
                        </div>

                        <div class="space-y-2 col-span-1 md:col-span-2">
                            <label for="email-address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Email Address <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="email" id="email-address" name="email" class="w-full min-w-0 py-3.5 pl-11 pr-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all box-border" placeholder="admin@organization.com" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="password" id="password" name="password" class="w-full min-w-0 py-3.5 pl-11 pr-12 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all box-border" placeholder="Create password" required>
                                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="confirm-password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Confirm Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 text-center"></i>
                                <input type="password" id="confirm-password" name="password_confirmation" class="w-full min-w-0 py-3.5 pl-11 pr-12 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all box-border" placeholder="Confirm password" required>
                                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold text-base hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg transition-all mt-6 cursor-pointer">Register as Organizer</button>

                    <div class="text-center mt-6 text-sm text-gray-600 dark:text-gray-400">
                        <p>Already have an account? <a href="/login" class="text-blue-600 font-semibold no-underline hover:underline">Log In</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
