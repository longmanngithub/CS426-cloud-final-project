<footer class="bg-[#1a1a2e] dark:bg-gray-800 text-[#ecf0f1] dark:text-gray-200 pt-12 pb-6 mt-auto">
    <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-between items-start gap-8 pb-8 border-b border-gray-700 dark:border-gray-600">
        <!-- Logo & Description -->
        <div class="flex-1 min-w-[250px]">
            <a href="/" class="block mb-4">
                <img src="/images/logo.jpg" alt="LED Logo" class="h-10 rounded">
            </a>
            <p class="text-[#a0a0a0] text-sm leading-relaxed mb-6">
                Discover the best local events, workshops, and gatherings in your community. Join us to connect, learn, and grow.
            </p>
            <div class="flex gap-4">
                <a href="#" class="flex items-center justify-center w-9 h-9 bg-white/10 rounded-full transition-all text-white hover:bg-blue-600 hover:-translate-y-1">
                    <i class="fab fa-facebook-f text-sm"></i>
                </a>
                <a href="#" class="flex items-center justify-center w-9 h-9 bg-white/10 rounded-full transition-all text-white hover:bg-blue-600 hover:-translate-y-1">
                    <i class="fab fa-twitter text-sm"></i>
                </a>
                <a href="#" class="flex items-center justify-center w-9 h-9 bg-white/10 rounded-full transition-all text-white hover:bg-blue-600 hover:-translate-y-1">
                    <i class="fab fa-instagram text-sm"></i>
                </a>
                <a href="#" class="flex items-center justify-center w-9 h-9 bg-white/10 rounded-full transition-all text-white hover:bg-blue-600 hover:-translate-y-1">
                    <i class="fab fa-linkedin-in text-sm"></i>
                </a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="flex-1 min-w-[200px]">
            <h4 class="font-semibold mb-5 text-white text-lg">Quick Links</h4>
            <ul class="space-y-3">
                <li><a href="/" class="text-[#a0a0a0] no-underline transition-all text-[0.95rem] hover:text-white hover:pl-1">Home</a></li>
                <li><a href="/events" class="text-[#a0a0a0] no-underline transition-all text-[0.95rem] hover:text-white hover:pl-1">All Events</a></li>
                <li><a href="/aboutus" class="text-[#a0a0a0] no-underline transition-all text-[0.95rem] hover:text-white hover:pl-1">About Us</a></li>
                <li><a href="/contact" class="text-[#a0a0a0] no-underline transition-all text-[0.95rem] hover:text-white hover:pl-1">Contact Support</a></li>
            </ul>
        </div>

        <!-- Categories -->
        <div class="flex-1 min-w-[200px]">
            <h4 class="font-semibold mb-5 text-white text-lg">Categories</h4>
            <ul class="space-y-3">
                <li><a href="/events?category=1" class="text-[#a0a0a0] no-underline transition-all text-[0.95rem] hover:text-white hover:pl-1">Music & Concerts</a></li>
                <li><a href="/events?category=2" class="text-[#a0a0a0] no-underline transition-all text-[0.95rem] hover:text-white hover:pl-1">Arts & Theatre</a></li>
                <li><a href="/events?category=3" class="text-[#a0a0a0] no-underline transition-all text-[0.95rem] hover:text-white hover:pl-1">Food & Drink</a></li>
                <li><a href="/events?category=4" class="text-[#a0a0a0] no-underline transition-all text-[0.95rem] hover:text-white hover:pl-1">Sports & Outdoors</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="flex-1 min-w-[200px]">
            <h4 class="font-semibold mb-5 text-white text-lg">Contact Us</h4>
            <div class="space-y-3">
                <p class="text-[#a0a0a0] mb-3 text-[0.95rem] flex items-start gap-3">
                    <i class="fas fa-map-marker-alt mt-1 text-blue-500"></i>
                    <span>123 Event Street, City Center,<br>Phnom Penh, Cambodia</span>
                </p>
                <p class="text-[#a0a0a0] mb-3 text-[0.95rem] flex items-center gap-3">
                    <i class="fas fa-phone text-blue-500"></i>
                    <span>+855 12 345 678</span>
                </p>
                <p class="text-[#a0a0a0] mb-3 text-[0.95rem] flex items-center gap-3">
                    <i class="fas fa-envelope text-blue-500"></i>
                    <span>support@localevents.com</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="max-w-7xl mx-auto px-4 pt-6 flex flex-col md:flex-row justify-between items-center text-[#777] text-sm">
        <p>&copy; {{ date('Y') }} Local Events Discovery. All rights reserved.</p>
        <div class="flex gap-6 mt-4 md:mt-0">
            <a href="/privacy" class="text-[#777] hover:text-white transition-colors">Privacy Policy</a>
            <a href="/terms" class="text-[#777] hover:text-white transition-colors">Terms of Service</a>
            <a href="/cookie" class="text-[#777] hover:text-white transition-colors">Cookie Policy</a>
        </div>
    </div>
</footer>
