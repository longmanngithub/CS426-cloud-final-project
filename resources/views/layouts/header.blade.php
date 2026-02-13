<header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm py-3 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center relative h-16">

        <!-- Left Side: Logo -->
        <div class="flex items-center shrink-0">
            <a href="/" class="flex items-center text-decoration-none transition-transform hover:scale-105">
                <img src="/images/logo.jpg" alt="LED Logo" class="h-10 w-auto">
            </a>
        </div>

        <!-- Center: Desktop Navigation (Pill Style) -->
        <nav class="hidden md:flex items-center gap-1 absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gray-50/50 dark:bg-gray-700/50 p-1 rounded-full border border-gray-100/50 dark:border-gray-600/50 backdrop-blur-sm">
            <a href="/" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->is('/') ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm ring-1 ring-gray-100 dark:ring-gray-500' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100/80 dark:hover:bg-gray-600/80' }}">
                Home
            </a>
            <a href="/events" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->is('events*') ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm ring-1 ring-gray-100 dark:ring-gray-500' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100/80 dark:hover:bg-gray-600/80' }}">
                Events
            </a>
        </nav>

        <!-- Right Side: Actions & Mobile Toggle -->
        <div class="flex items-center gap-3 md:gap-4">

            <!-- Theme Toggle Button -->
            <button onclick="toggleTheme()" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors focus:outline-none" aria-label="Toggle theme">
                <i class="fas fa-sun theme-icon-sun hidden"></i>
                <i class="fas fa-moon theme-icon-moon"></i>
            </button>

            @if(Auth::guard('web')->check() || Auth::guard('organizer')->check())
                @php
                    $isOrg = Auth::guard('organizer')->check();
                    $user = $isOrg ? Auth::guard('organizer')->user() : Auth::guard('web')->user();
                    $name = $isOrg ? ($user->organization_name ?? 'Organizer') : ($user->first_name ?? 'User');
                    $roleLabel = $isOrg ? 'Organizer' : 'User';
                    $roleColor = $isOrg ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
                    $profileLink = $isOrg ? '/orgpf' : '/userpf';
                @endphp

                <!-- Desktop: Post Event Button (Organizer Only) -->
                @if($isOrg)
                    <a href="/orgpostevents" class="hidden md:inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-full font-semibold text-sm transition-all hover:bg-blue-700 hover:-translate-y-px">
                        <i class="fas fa-plus"></i> Post Event
                    </a>
                @endif

                <!-- Profile Dropdown (Unified) -->
                <div class="relative group" id="profileDropdownContainer">
                    <!-- Trigger -->
                    <button class="flex items-center gap-2 focus:outline-none" id="profileMenuToggle">
                        <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold border border-gray-200 dark:border-gray-600 hover:border-blue-300 transition-colors">
                            {{ substr($name, 0, 1) }}
                        </div>
                        <!-- Desktop Name/Label -->
                        <div class="text-left hidden lg:block">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white leading-none">{{ $name }}</p>
                            <span class="text-xs font-medium {{ $roleColor }} px-2 py-0.5 rounded-full mt-1 inline-block">{{ $roleLabel }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-500 text-xs ml-1 hidden lg:block"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 invisible opacity-0 transform translate-y-2 transition-all duration-200 z-50" id="profileDropdown">
                        <!-- Mobile User Info Header inside dropdown -->
                        <div class="p-4 border-b border-gray-50 dark:border-gray-700 lg:hidden bg-gray-50 dark:bg-gray-700 rounded-t-xl">
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $name }}</p>
                            <span class="text-xs font-medium {{ $roleColor }} px-2 py-0.5 rounded-full mt-1 inline-block">{{ $roleLabel }}</span>
                        </div>

                        <div class="py-2">
                            <a href="{{ $profileLink }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center gap-3">
                                <span class="w-6 text-center"><i class="fas fa-user-circle text-gray-400 dark:text-gray-500"></i></span> My Profile
                            </a>
                            @if($isOrg)
                                <a href="/orgmyevents" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center gap-3">
                                    <span class="w-6 text-center"><i class="fas fa-calendar-check text-gray-400 dark:text-gray-500"></i></span> My Events
                                </a>
                                <a href="/orgpostevents" class="md:hidden block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center gap-3">
                                    <span class="w-6 text-center"><i class="fas fa-plus-circle text-gray-400 dark:text-gray-500"></i></span> Post Event
                                </a>
                            @else
                                <a href="/userfav" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center gap-3">
                                    <span class="w-6 text-center"><i class="fas fa-heart text-gray-400 dark:text-gray-500"></i></span> Favorites
                                </a>
                            @endif
                        </div>
                        <div class="border-t border-gray-50 dark:border-gray-700 py-2">
                            <form method="POST" action="/logout" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors flex items-center gap-3">
                                    <span class="w-6 text-center"><i class="fas fa-sign-out-alt text-red-400"></i></span> Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Desktop Login/Signup -->
                <div class="hidden md:flex items-center gap-4">
                    <a href="/login" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 font-medium text-sm transition-colors">Log In</a>
                    <a href="/userororg" class="bg-blue-600 text-white px-5 py-2.5 rounded-full font-semibold text-sm transition-all hover:bg-blue-700 hover:-translate-y-px">Sign Up</a>
                </div>
            @endif

    <style>
        /* Animated Hamburger Styles */
        .hamburger-icon {
            width: 24px;
            height: 20px;
            position: relative;
            transform: rotate(0deg);
            transition: .5s ease-in-out;
            cursor: pointer;
        }
        .hamburger-icon span {
            display: block;
            position: absolute;
            height: 2px;
            width: 100%;
            background: #374151; /* gray-700 */
            border-radius: 9px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }
        html.dark .hamburger-icon span {
            background: #d1d5db; /* gray-300 */
        }
        .hamburger-icon span:nth-child(1) { top: 0px; }
        .hamburger-icon span:nth-child(2), .hamburger-icon span:nth-child(3) { top: 9px; }
        .hamburger-icon span:nth-child(4) { top: 18px; }

        .hamburger-icon.open span:nth-child(1) {
            top: 9px;
            width: 0%;
            left: 50%;
        }
        .hamburger-icon.open span:nth-child(2) {
            transform: rotate(45deg);
        }
        .hamburger-icon.open span:nth-child(3) {
            transform: rotate(-45deg);
        }
        .hamburger-icon.open span:nth-child(4) {
            top: 9px;
            width: 0%;
            left: 50%;
        }
    </style>

            <!-- Mobile Menu Toggle (Animated Hamburger) -->
            <button class="block md:hidden w-10 h-10 flex items-center justify-center text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600 transition-colors hover:bg-gray-100 dark:hover:bg-gray-600 relative z-50" id="mobileMenuToggle" aria-label="Toggle Menu">
                <div class="hamburger-icon" id="hamburgerIcon">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Menu (Absolute Slide-down) -->
    <div class="absolute top-full left-0 right-0 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-xl md:hidden z-40 transform origin-top overflow-hidden max-h-0 opacity-0 pointer-events-none transition-all duration-300 ease-in-out" id="mobileNav">
        <div class="p-4 space-y-2">
            <a href="/" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors flex items-center gap-3">
                <span class="w-6 text-center"><i class="fas fa-home text-blue-500"></i></span> Home
            </a>
            <a href="/events" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors flex items-center gap-3">
                <span class="w-6 text-center"><i class="fas fa-calendar-alt text-blue-500"></i></span> Events
            </a>

            @if((!Auth::guard('web')->check() && !Auth::guard('organizer')->check()))
                <div class="border-t border-gray-100 dark:border-gray-700 my-2 pt-2">
                    <a href="/login" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors flex items-center gap-3">
                        <span class="w-6 text-center"><i class="fas fa-sign-in-alt text-gray-400"></i></span> Log In
                    </a>
                    <a href="/userororg" class="block px-4 py-3 mt-2 rounded-lg bg-blue-600 text-white text-center font-semibold transition-transform active:scale-95">
                        Sign Up
                    </a>
                </div>
            @endif

        </div>
    </div>
</header>
<script>
    // Elements
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileNav = document.getElementById('mobileNav');
    const hamburgerIcon = document.getElementById('hamburgerIcon');

    const profileMenuToggle = document.getElementById('profileMenuToggle');
    const profileDropdown = document.getElementById('profileDropdown');
    const profileContainer = document.getElementById('profileDropdownContainer');

    // Helper functions to close menus
    function closeMobileMenu() {
        if (mobileNav && mobileNav.classList.contains('max-h-screen')) {
            mobileNav.classList.remove('max-h-screen', 'opacity-100');
            mobileNav.classList.add('max-h-0', 'opacity-0', 'pointer-events-none');
            if (hamburgerIcon) {
                hamburgerIcon.classList.remove('open');
            }
        }
    }

    function closeProfileMenu() {
        if (profileDropdown && !profileDropdown.classList.contains('invisible')) {
            profileDropdown.classList.add('invisible', 'opacity-0', 'transform', 'translate-y-2');
            profileDropdown.classList.remove('translate-y-0');
        }
    }

    // Toggle Mobile Nav with Animation
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            closeProfileMenu();

            const isClosed = mobileNav.classList.contains('max-h-0');

            if (isClosed) {
                mobileNav.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none');
                mobileNav.classList.add('max-h-screen', 'opacity-100');
                hamburgerIcon.classList.add('open');
            } else {
                mobileNav.classList.remove('max-h-screen', 'opacity-100');
                mobileNav.classList.add('max-h-0', 'opacity-0', 'pointer-events-none');
                hamburgerIcon.classList.remove('open');
            }
        });
    }

    // Toggle Profile Dropdown
    if (profileMenuToggle) {
        profileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            closeMobileMenu();

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

    // Close menus when clicking outside
    document.addEventListener('click', function(event) {
        if (mobileNav && !mobileNav.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
            closeMobileMenu();
        }

        if (profileDropdown && !profileContainer.contains(event.target)) {
            closeProfileMenu();
        }
    });
</script>
