<header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm py-3 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center relative h-16">

        <!-- Left Side: Logo -->
        <div class="flex items-center shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center text-decoration-none transition-transform hover:scale-105">
                <img src="/images/logo.jpg" alt="LED Logo" class="h-10 w-auto">
                <span class="ml-3 text-lg font-bold text-gray-900 dark:text-white hidden sm:block">Admin Panel</span>
            </a>
        </div>

    <!-- Center: Desktop Navigation (Pill Style) -->
    @auth('admin')
    <nav class="hidden md:flex items-center gap-1 absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gray-50/50 dark:bg-gray-700/50 p-1 rounded-full border border-gray-100/50 dark:border-gray-600/50 backdrop-blur-sm">
        <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm ring-1 ring-gray-100 dark:ring-gray-500' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100/80 dark:hover:bg-gray-600/80' }}">
            Overview
        </a>
        <a href="{{ route('admin.manage_events') }}" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.manage_events') ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm ring-1 ring-gray-100 dark:ring-gray-500' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100/80 dark:hover:bg-gray-600/80' }}">
            Events
        </a>
        <a href="{{ route('admin.manage_users') }}" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.manage_users') ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm ring-1 ring-gray-100 dark:ring-gray-500' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100/80 dark:hover:bg-gray-600/80' }}">
            Users
        </a>
        <a href="{{ route('admin.manage_organizers') }}" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.manage_organizers') ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm ring-1 ring-gray-100 dark:ring-gray-500' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100/80 dark:hover:bg-gray-600/80' }}">
            Organizers
        </a>

    </nav>
    @endauth

    <!-- Right Side: Actions & Mobile Toggle -->
    <div class="flex items-center gap-3 md:gap-4">

        <!-- Theme Toggle Button -->
        <button id="themeToggle" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500 transition-colors focus:outline-none" aria-label="Toggle Theme">
            <i class="fas fa-moon text-sm dark:hidden"></i>
            <i class="fas fa-sun text-sm hidden dark:inline"></i>
        </button>

        @auth('admin')
        <!-- Profile Dropdown -->
        <div class="relative group" id="profileDropdownContainer">
            <button class="flex items-center gap-2 focus:outline-none" id="profileMenuToggle">
                <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-500 transition-colors">
                    {{ substr(Auth::guard('admin')->user()->first_name ?? 'A', 0, 1) }}
                </div>
                <div class="text-left hidden lg:block">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white leading-none">{{ Auth::guard('admin')->user()->first_name ?? 'Admin' }}</p>
                    <span class="text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full mt-1 inline-block">Administrator</span>
                </div>
                <i class="fas fa-chevron-down text-gray-400 dark:text-gray-500 text-xs ml-1 hidden lg:block"></i>
            </button>

            <!-- Dropdown Menu -->
            <div class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 invisible opacity-0 transform translate-y-2 transition-all duration-200 z-50" id="profileDropdown">
                <div class="p-4 border-b border-gray-50 dark:border-gray-700 lg:hidden bg-gray-50 dark:bg-gray-700 rounded-t-xl">
                    <p class="text-base font-bold text-gray-900 dark:text-white">{{ Auth::guard('admin')->user()->first_name ?? 'Admin' }}</p>
                    <span class="text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full mt-1 inline-block">Administrator</span>
                </div>

                <div class="py-2">
                    <a href="{{ route('admin.profile') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center gap-3">
                        <span class="w-6 text-center"><i class="fas fa-user-circle text-gray-400 dark:text-gray-500"></i></span> My Profile
                    </a>
                </div>

                <div class="border-t border-gray-50 dark:border-gray-700 py-2">
                    <form method="POST" action="{{ route('admin.logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors flex items-center gap-3">
                            <span class="w-6 text-center"><i class="fas fa-sign-out-alt text-red-400 dark:text-red-500"></i></span> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Toggle (Animated Hamburger) -->
        <button class="block md:hidden w-10 h-10 flex items-center justify-center text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600 transition-colors hover:bg-gray-100 dark:hover:bg-gray-600 relative z-50" id="mobileMenuToggle" aria-label="Toggle Menu">
            <i class="fas fa-bars text-lg"></i>
        </button>
        @endauth
    </div>
</div>

<!-- Mobile Navigation Menu (Absolute Slide-down) -->
@auth('admin')
<div class="absolute top-full left-0 right-0 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-xl md:hidden z-40 transform origin-top overflow-hidden max-h-0 opacity-0 pointer-events-none transition-all duration-300 ease-in-out" id="mobileNav">
    <div class="p-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors flex items-center gap-3">
            <span class="w-6 text-center"><i class="fas fa-tachometer-alt text-blue-500"></i></span> Dashboard
        </a>
        <a href="{{ route('admin.manage_users') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors flex items-center gap-3">
            <span class="w-6 text-center"><i class="fas fa-users text-blue-500"></i></span> Users
        </a>
        <a href="{{ route('admin.manage_organizers') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors flex items-center gap-3">
            <span class="w-6 text-center"><i class="fas fa-briefcase text-blue-500"></i></span> Organizers
        </a>
        <a href="{{ route('admin.manage_events') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors flex items-center gap-3">
            <span class="w-6 text-center"><i class="fas fa-calendar-alt text-blue-500"></i></span> Events
        </a>

    </div>
</div>
@endauth
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileMenuToggle = document.getElementById('profileMenuToggle');
        const profileDropdown = document.getElementById('profileDropdown');
        const profileContainer = document.getElementById('profileDropdownContainer');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileNav = document.getElementById('mobileNav');

        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', toggleTheme);
        }

        // Toggle Profile Dropdown
        if (profileMenuToggle) {
            profileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Close mobile menu if open
                if (mobileNav && !mobileNav.classList.contains('max-h-0')) {
                    mobileNav.classList.remove('max-h-screen', 'opacity-100');
                    mobileNav.classList.add('max-h-0', 'opacity-0', 'pointer-events-none');
                }

                const isHidden = profileDropdown.classList.contains('invisible');

                if (isHidden) {
                    profileDropdown.classList.remove('invisible', 'opacity-0', 'transform', 'translate-y-2');
                    profileDropdown.classList.add('translate-y-0');
                } else {
                    profileDropdown.classList.add('invisible', 'opacity-0', 'transform', 'translate-y-2');
                    profileDropdown.classList.remove('translate-y-0');
                }
            });
        }

        // Toggle Mobile Navigation
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                // Close profile dropdown if open
                if (profileDropdown && !profileDropdown.classList.contains('invisible')) {
                    profileDropdown.classList.add('invisible', 'opacity-0', 'transform', 'translate-y-2');
                    profileDropdown.classList.remove('translate-y-0');
                }

                const isClosed = mobileNav.classList.contains('max-h-0');
                if (isClosed) {
                    mobileNav.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none');
                    mobileNav.classList.add('max-h-screen', 'opacity-100');
                } else {
                    mobileNav.classList.remove('max-h-screen', 'opacity-100');
                    mobileNav.classList.add('max-h-0', 'opacity-0', 'pointer-events-none');
                }
            });
        }

        // Close menus when clicking outside
        document.addEventListener('click', function(event) {
            // Close profile dropdown if open and click is outside
            if (profileDropdown && !profileContainer.contains(event.target)) {
                profileDropdown.classList.add('invisible', 'opacity-0', 'transform', 'translate-y-2');
                profileDropdown.classList.remove('translate-y-0');
            }

            // Close mobile nav if open and click is outside
            if (mobileNav && !mobileNav.contains(event.target) && mobileMenuToggle && !mobileMenuToggle.contains(event.target)) {
                mobileNav.classList.remove('max-h-screen', 'opacity-100');
                mobileNav.classList.add('max-h-0', 'opacity-0', 'pointer-events-none');
            }
        });
    });

</script>
