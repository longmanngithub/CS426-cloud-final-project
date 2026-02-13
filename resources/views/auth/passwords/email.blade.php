<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Admin Panel</title>
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
        <a href="{{ route('admin.login') }}" class="absolute top-8 left-8 text-gray-500 dark:text-gray-400 font-medium flex items-center gap-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>

        <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-xl overflow-hidden relative">
            <div class="text-center pt-10 pb-4 px-8">
                <div class="mx-auto h-16 w-16 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-key text-blue-600 text-3xl"></i>
                </div>
                <h2 class="text-3xl font-bold mb-2 text-[#1a1a2e] dark:text-white">Forgot Password?</h2>
                <p class="text-gray-500 dark:text-gray-400 m-0">Enter your email to reset your administrative password</p>
            </div>

            @if (session('status'))
                <div class="mx-8 mb-6 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg relative" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-8 mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="px-8 pb-10 animate-fade-in block">
                <form method="POST" action="{{ route('admin.password.email') }}">
                    @csrf
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="email" id="email" name="email" placeholder="admin@example.com" required class="w-full py-3.5 pl-11 pr-4 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold text-base hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg transition-all mt-2 cursor-pointer">
                        Send Password Reset Link
                    </button>
                </form>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 px-8 py-4 text-center border-t border-gray-100 dark:border-gray-600">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} Local Events Discovery. Admin Access Only.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
