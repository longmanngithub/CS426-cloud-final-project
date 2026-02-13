<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Local Events Discovery</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="font-sans text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-900 m-0 min-h-screen flex flex-col">
    <div class="flex-1 flex items-center justify-center p-4 bg-gradient-to-br from-gray-50 to-gray-200 dark:from-gray-900 dark:to-gray-800">
        <a href="/" class="absolute top-8 left-8 text-gray-500 dark:text-gray-400 font-medium flex items-center gap-2 hover:text-blue-600 transition-colors">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-xl overflow-hidden relative">
            <div class="text-center pt-10 pb-4 px-8">
                <h2 class="text-3xl font-bold mb-2 text-[#1a1a2e] dark:text-white">Welcome Back</h2>
                <p class="text-gray-500 dark:text-gray-400 m-0">Please log in to continue</p>
            </div>

            @if ($errors->any())
                <div class="mx-8 mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mx-8 mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg relative" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex px-8 border-b-2 border-gray-50 dark:border-gray-700 mb-6">
                <button id="user-tab" class="flex-1 py-4 font-semibold text-blue-600 border-b-2 border-blue-600 transition-colors cursor-pointer bg-transparent focus:outline-none" onclick="showForm('user')">User</button>
                <button id="org-tab" class="flex-1 py-4 font-semibold text-gray-400 border-b-2 border-transparent hover:text-blue-600 transition-colors cursor-pointer bg-transparent focus:outline-none" onclick="showForm('organizer')">Organizer</button>
            </div>

            <!-- User Login Form -->
            <div id="user-form" class="px-8 pb-10 animate-fade-in block">
                <form method="POST" action="/login">
                    @csrf
                    <div class="mb-5">
                        <label for="user-email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="email" id="user-email" name="email" placeholder="Enter your email" required class="w-full py-3.5 pl-11 pr-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="user-password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" id="user-password" name="password" placeholder="Enter your password" required class="w-full py-3.5 pl-11 pr-12 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-end mb-5">
                        <a href="/forgot-password" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold text-base hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg transition-all mt-2 cursor-pointer">Log In</button>
                    <div class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
                        <p>Don't have an account? <a href="/userororg" class="text-blue-600 font-semibold no-underline hover:underline">Sign up</a></p>
                    </div>
                </form>
            </div>

            <!-- Organizer Login Form -->
            <div id="organizer-form" class="px-8 pb-10 animate-fade-in hidden">
                <form method="POST" action="/organizer/login">
                    @csrf
                    <div class="mb-5">
                        <label for="org-email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Organizer Email</label>
                        <div class="relative">
                            <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="email" id="org-email" name="email" placeholder="Enter organizer email" required class="w-full py-3.5 pl-11 pr-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="org-password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" id="org-password" name="password" placeholder="Enter your password" required class="w-full py-3.5 pl-11 pr-12 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-end mb-5">
                        <a href="/forgot-password" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold text-base hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg transition-all mt-2 cursor-pointer">Log In as Organizer</button>
                    <div class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
                        <p>Want to host events? <a href="/userororg" class="text-blue-600 font-semibold no-underline hover:underline">Register as Organizer</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showForm(type) {
            const userForm = document.getElementById('user-form');
            const orgForm = document.getElementById('organizer-form');
            const userTab = document.getElementById('user-tab');
            const orgTab = document.getElementById('org-tab');

            if (type === 'user') {
                userForm.classList.remove('hidden');
                orgForm.classList.add('hidden');

                userTab.classList.add('text-blue-600', 'border-blue-600');
                userTab.classList.remove('text-gray-400', 'border-transparent');

                orgTab.classList.remove('text-blue-600', 'border-blue-600');
                orgTab.classList.add('text-gray-400', 'border-transparent');
            } else {
                orgForm.classList.remove('hidden');
                userForm.classList.add('hidden');

                orgTab.classList.add('text-blue-600', 'border-blue-600');
                orgTab.classList.remove('text-gray-400', 'border-transparent');

                userTab.classList.remove('text-blue-600', 'border-blue-600');
                userTab.classList.add('text-gray-400', 'border-transparent');
            }
        }
    </script>
</body>
</html>
