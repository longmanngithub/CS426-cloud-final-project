<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Choose Role</title>
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

        <div class="bg-white dark:bg-gray-800 w-full max-w-3xl rounded-2xl shadow-xl overflow-hidden text-center p-8 md:p-12 relative">
            <h2 class="text-3xl font-bold mb-4 text-[#1a1a2e] dark:text-white">Join Our Community</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-12 text-lg">Choose how you want to get started</p>

            <div class="flex flex-col md:flex-row justify-center gap-8">
                <a href="/user_signup" class="flex-1 min-w-[250px] bg-white dark:bg-gray-700 border-2 border-gray-100 dark:border-gray-600 rounded-2xl p-8 no-underline text-gray-800 dark:text-gray-200 transition-all hover:border-blue-500 hover:-translate-y-1 hover:shadow-lg flex flex-col items-center gap-4 group">
                    <div class="w-20 h-20 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-3xl text-blue-600 mb-2 transition-colors group-hover:bg-blue-600 group-hover:text-white">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="text-xl font-bold">As a User</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Discover events, bookmark your favorites, and join the local community.</div>
                </a>

                <a href="/org_signup" class="flex-1 min-w-[250px] bg-white dark:bg-gray-700 border-2 border-gray-100 dark:border-gray-600 rounded-2xl p-8 no-underline text-gray-800 dark:text-gray-200 transition-all hover:border-blue-500 hover:-translate-y-1 hover:shadow-lg flex flex-col items-center gap-4 group">
                    <div class="w-20 h-20 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-3xl text-blue-600 mb-2 transition-colors group-hover:bg-blue-600 group-hover:text-white">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="text-xl font-bold">As an Organizer</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Create events, manage registrations, and reach a wider audience.</div>
                </a>
            </div>

            <p class="mt-8 mb-0 text-sm text-gray-500 dark:text-gray-400">
                Already have an account? <a href="/login" class="text-blue-600 font-semibold no-underline hover:underline">Log In</a>
            </p>
        </div>
    </div>
</body>
</html>
