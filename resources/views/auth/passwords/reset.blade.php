<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password - Local Events Discovery</title>
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
        <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-xl overflow-hidden relative">
            <div class="text-center pt-10 pb-4 px-8">
                <h2 class="text-3xl font-bold mb-2 text-[#1a1a2e] dark:text-white">Set New Password</h2>
                <p class="text-gray-500 dark:text-gray-400 m-0">Create a secure password for your account</p>
            </div>

            @if ($errors->any())
                <div class="mx-8 mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg relative text-sm" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/password/reset" class="px-8 pb-10">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->email }}">
                <input type="hidden" name="role" value="{{ request()->role }}">

                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" id="password" name="password" placeholder="Enter new password" required class="w-full py-3.5 pl-11 pr-12 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="password-confirm" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" id="password-confirm" name="password_confirmation" placeholder="Confirm new password" required class="w-full py-3.5 pl-11 pr-12 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-base focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold text-base hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg transition-all mt-2 cursor-pointer">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</body>
</html>
