<footer class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 pt-12 pb-6 mt-auto border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-between items-start gap-8 pb-8 border-b border-gray-200 dark:border-gray-700">
        <!-- Logo & Description -->
        <div class="flex-1 min-w-[250px]">
            <a href="/" class="block mb-4">
                <img src="/images/logo.jpg" alt="LED Logo" class="h-10 rounded">
            </a>
            <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-6">
                Discover the best local events, workshops, and gatherings in your community. Join us to connect, learn, and grow.
            </p>
            <div class="flex gap-4">
                <a href="#" class="flex items-center justify-center w-9 h-9 bg-gray-100 dark:bg-white/10 rounded-full transition-all text-gray-600 dark:text-white hover:bg-blue-600 hover:text-white hover:-translate-y-1">
                    <i class="fab fa-facebook-f text-sm"></i>
                </a>
                <a href="#" class="flex items-center justify-center w-9 h-9 bg-gray-100 dark:bg-white/10 rounded-full transition-all text-gray-600 dark:text-white hover:bg-blue-600 hover:text-white hover:-translate-y-1">
                    <i class="fab fa-twitter text-sm"></i>
                </a>
                <a href="#" class="flex items-center justify-center w-9 h-9 bg-gray-100 dark:bg-white/10 rounded-full transition-all text-gray-600 dark:text-white hover:bg-blue-600 hover:text-white hover:-translate-y-1">
                    <i class="fab fa-instagram text-sm"></i>
                </a>
                <a href="#" class="flex items-center justify-center w-9 h-9 bg-gray-100 dark:bg-white/10 rounded-full transition-all text-gray-600 dark:text-white hover:bg-blue-600 hover:text-white hover:-translate-y-1">
                    <i class="fab fa-linkedin-in text-sm"></i>
                </a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="flex-1 min-w-[200px]">
            <h4 class="font-semibold mb-5 text-gray-900 dark:text-white text-lg">Quick Links</h4>
            <ul class="space-y-3">
                <li><a href="/" class="text-gray-500 dark:text-gray-400 no-underline transition-all text-[0.95rem] hover:text-blue-600 dark:hover:text-white hover:pl-1">Home</a></li>
                <li><a href="/events" class="text-gray-500 dark:text-gray-400 no-underline transition-all text-[0.95rem] hover:text-blue-600 dark:hover:text-white hover:pl-1">All Events</a></li>
                <li><a href="/aboutus" class="text-gray-500 dark:text-gray-400 no-underline transition-all text-[0.95rem] hover:text-blue-600 dark:hover:text-white hover:pl-1">About Us</a></li>
                <li><a href="/contact" class="text-gray-500 dark:text-gray-400 no-underline transition-all text-[0.95rem] hover:text-blue-600 dark:hover:text-white hover:pl-1">Contact Support</a></li>
            </ul>
        </div>

        <!-- Categories -->
        <div class="flex-1 min-w-[200px]">
            <h4 class="font-semibold mb-5 text-gray-900 dark:text-white text-lg">Categories</h4>
            <ul class="space-y-3">
                <li><a href="/events?category=1" class="text-gray-500 dark:text-gray-400 no-underline transition-all text-[0.95rem] hover:text-blue-600 dark:hover:text-white hover:pl-1">Music & Concerts</a></li>
                <li><a href="/events?category=2" class="text-gray-500 dark:text-gray-400 no-underline transition-all text-[0.95rem] hover:text-blue-600 dark:hover:text-white hover:pl-1">Arts & Theatre</a></li>
                <li><a href="/events?category=3" class="text-gray-500 dark:text-gray-400 no-underline transition-all text-[0.95rem] hover:text-blue-600 dark:hover:text-white hover:pl-1">Food & Drink</a></li>
                <li><a href="/events?category=4" class="text-gray-500 dark:text-gray-400 no-underline transition-all text-[0.95rem] hover:text-blue-600 dark:hover:text-white hover:pl-1">Sports & Outdoors</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="flex-1 min-w-[200px]">
            <h4 class="font-semibold mb-5 text-gray-900 dark:text-white text-lg">Contact Us</h4>
            <div class="space-y-3">
                <p class="text-gray-500 dark:text-gray-400 mb-3 text-[0.95rem] flex items-start gap-3">
                    <i class="fas fa-map-marker-alt mt-1 text-blue-500"></i>
                    <span>123 Event Street, City Center,<br>Phnom Penh, Cambodia</span>
                </p>
                <p class="text-gray-500 dark:text-gray-400 mb-3 text-[0.95rem] flex items-center gap-3">
                    <i class="fas fa-phone text-blue-500"></i>
                    <span>+855 12 345 678</span>
                </p>
                <p class="text-gray-500 dark:text-gray-400 mb-3 text-[0.95rem] flex items-center gap-3">
                    <i class="fas fa-envelope text-blue-500"></i>
                    <span>support@localevents.com</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="max-w-7xl mx-auto px-4 pt-6 flex flex-col md:flex-row justify-between items-center text-gray-500 dark:text-gray-500 text-sm">
        <p>&copy; {{ date('Y') }} Local Events Discovery. All rights reserved.</p>
        <div class="flex gap-6 mt-4 md:mt-0">
            <a href="/privacy" class="text-gray-500 dark:text-gray-500 hover:text-blue-600 dark:hover:text-white transition-colors">Privacy Policy</a>
            <a href="/terms" class="text-gray-500 dark:text-gray-500 hover:text-blue-600 dark:hover:text-white transition-colors">Terms of Service</a>
            <a href="/cookie" class="text-gray-500 dark:text-gray-500 hover:text-blue-600 dark:hover:text-white transition-colors">Cookie Policy</a>
        </div>
    </div>
</footer>