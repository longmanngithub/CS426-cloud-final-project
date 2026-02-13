<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Local Events Discovery</title>
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
<body class="font-sans text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-900 m-0 min-h-screen flex flex-col items-center justify-center p-4">
    <div class="text-center max-w-lg">
        <div class="mb-8 relative inline-block">
            <span class="text-9xl font-bold text-gray-200 dark:text-gray-700">404</span>
            <div class="absolute inset-0 flex items-center justify-center">
                <i class="fas fa-search text-5xl text-blue-500 opacity-80 animate-bounce"></i>
            </div>
        </div>

        <h1 class="text-3xl md:text-4xl font-bold mb-4 text-[#1a1a2e] dark:text-white">Page Not Found</h1>
        <p class="text-gray-500 dark:text-gray-400 text-lg mb-8">Oops! The page you're looking for doesn't exist or has been moved.</p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/" class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all hover:-translate-y-1">
                <i class="fas fa-home"></i> Go Home
            </a>
            <a href="javascript:history.back()" class="inline-flex items-center justify-center gap-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all hover:-translate-y-1">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
</body>
</html>
