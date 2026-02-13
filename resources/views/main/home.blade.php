@extends('layouts.app')

@section('title', 'Local Events Discovery')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-[#1a1a2e] via-[#16213e] to-[#0f3460] text-white py-20 text-center overflow-hidden">
        <!-- Background Image Overlay -->
        <div class="absolute inset-0 bg-[url('/images/hero-bg.png')] bg-cover bg-center opacity-10 z-0"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-md">Discover Local Events</h1>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">Find distinct events, workshops, and gatherings happening in your city. Join the community today.</p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 h-auto sm:h-[50px] relative items-center" id="hero-button-group">
                <div class="search-container relative h-[50px] w-full sm:w-auto flex items-center justify-center transition-all duration-300">
                    <button id="find-events-btn" class="bg-blue-600 text-white px-8 py-3 rounded-full font-semibold border-2 border-blue-600 hover:bg-blue-700 hover:border-blue-700 hover:-translate-y-0.5 transition-all flex items-center gap-2 h-full whitespace-nowrap z-20 w-full sm:w-auto justify-center" onclick="toggleSearch()">
                        <i class="fas fa-search"></i> <span class="text-base">Find Events</span>
                    </button>
                </div>
                <a href="/events" class="bg-transparent text-white px-8 py-3 rounded-full font-semibold border-2 border-white/50 hover:bg-white hover:text-[#1a1a2e] hover:border-white hover:-translate-y-0.5 transition-all flex items-center gap-2 h-[50px] sm:h-full whitespace-nowrap z-20 btn-explore w-full sm:w-auto justify-center">Explore Now</a>

                <form id="hero-search-form" action="/events" method="GET" class="absolute left-1/2 top-0 -translate-x-1/2 h-[50px] w-full sm:w-[320px] flex items-center bg-white dark:bg-gray-800 rounded-full pl-5 pr-1 shadow-lg z-10 transition-all duration-300 opacity-0 pointer-events-none scale-90">
                    <input type="text" name="search" id="hero-search-input" placeholder="Search events..." class="border-none outline-none p-0 text-base font-medium text-gray-800 dark:text-white flex-1 bg-transparent dark:placeholder-gray-500" onblur="checkBlur()">
                    <button type="submit" class="bg-blue-600 text-white border-none w-10 h-10 rounded-full cursor-pointer flex items-center justify-center transition-colors hover:bg-blue-700 flex-shrink-0 ml-0" aria-label="Search"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </section>

    <script>
        function toggleSearch() {
            const buttonGroup = document.getElementById('hero-button-group');
            const form = document.getElementById('hero-search-form');
            const btns = buttonGroup.querySelectorAll('button:not([type="submit"]), a');
            const input = document.getElementById('hero-search-input');

            // Hide buttons
            btns.forEach(btn => {
                btn.classList.add('opacity-0', 'pointer-events-none', 'scale-90');
            });

            // Show form
            form.classList.remove('opacity-0', 'pointer-events-none', 'scale-90');
            form.classList.add('opacity-100', 'pointer-events-auto', 'scale-100');

            // Focus input after a small delay
            setTimeout(() => {
                input.focus();
            }, 50);
        }

        function checkBlur() {
            setTimeout(() => {
                const buttonGroup = document.getElementById('hero-button-group');
                const form = document.getElementById('hero-search-form');
                const btns = buttonGroup.querySelectorAll('button:not([type="submit"]), a');
                const input = document.getElementById('hero-search-input');

                // Only close if not focused
                if (document.activeElement !== input) {
                    // Hide form
                    form.classList.add('opacity-0', 'pointer-events-none', 'scale-90');
                    form.classList.remove('opacity-100', 'pointer-events-auto', 'scale-100');

                    // Show buttons
                    btns.forEach(btn => {
                        btn.classList.remove('opacity-0', 'pointer-events-none', 'scale-90');
                    });

                    input.value = '';
                }
            }, 200);
        }
    </script>

<div class="py-12 max-w-7xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 text-center relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-[60px] after:h-[3px] after:bg-blue-600 after:rounded-sm">Featured Events</h2>

    @if($featuredEvents->count() > 0)
    <!-- Carousel Container -->
    <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 group" id="featuredCarousel">
        <!-- Slides Wrapper (Grid Stack for Dynamic Height) -->
        <div class="grid grid-cols-1 overflow-hidden" id="carouselSlides">
            @foreach($featuredEvents as $index => $event)
            <div class="col-start-1 row-start-1 transition-opacity duration-700 ease-in-out flex flex-col lg:flex-row {{ $index === 0 ? 'opacity-100 relative z-10' : 'opacity-0 z-0' }}" data-slide="{{ $index }}">
                <!-- Image Side -->
                <div class="lg:w-3/5 h-[250px] lg:h-auto relative overflow-hidden flex-shrink-0">
                    <img src="{{ $event->picture_url ?? '/images/default-event.jpg' }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent"></div>
                    <div class="absolute top-6 left-6">
                        <span class="bg-blue-600/90 backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">
                            <i class="fas fa-star mr-1"></i> Featured
                        </span>
                    </div>
                </div>

                <!-- Content Side -->
                <div class="lg:w-2/5 p-6 pb-16 lg:p-12 flex flex-col justify-center bg-white dark:bg-gray-800 relative min-w-0">
                    <!-- Category -->
                    <div class="flex items-center gap-2 text-blue-600 font-semibold text-sm mb-3">
                        <i class="fas fa-tag"></i>
                        <span>{{ $event->category->name ?? 'Event' }}</span>
                    </div>

                    <!-- Title -->
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-3 lg:mb-4 leading-tight">
                        {{ $event->title }}
                    </h3>

                    <!-- Description -->
                    <p class="text-gray-600 dark:text-gray-400 mb-4 lg:mb-8 leading-relaxed line-clamp-2 lg:line-clamp-3 text-sm lg:text-base">
                        {{ $event->description ?? 'Join us for this amazing event!' }}
                    </p>

                    <!-- Details -->
                    <div class="space-y-3 lg:space-y-4 mb-6 lg:mb-8">
                        <div class="flex items-center gap-2 lg:gap-3 text-gray-700 dark:text-gray-300">
                            <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 shrink-0 text-sm lg:text-base">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase">Date</p>
                                <p class="font-semibold text-xs lg:text-sm">{{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 lg:gap-3 text-gray-700 dark:text-gray-300">
                            <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 shrink-0 text-sm lg:text-base">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase">Location</p>
                                <p class="font-semibold text-xs lg:text-sm truncate max-w-[180px] lg:max-w-[200px]">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <a href="/events/{{ $event->event_id }}" class="inline-flex justify-center items-center gap-2 bg-gray-900 dark:bg-gray-700 text-white px-6 py-3 lg:px-8 lg:py-4 rounded-xl font-bold text-sm lg:text-base transition-all hover:bg-blue-600 hover:-translate-y-1 shadow-lg shadow-gray-200 dark:shadow-gray-900 self-start">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Navigation Buttons (Hidden on Mobile) -->
        <button class="absolute top-1/2 left-4 transform -translate-y-1/2 w-12 h-12 bg-white/80 dark:bg-gray-700/80 hover:bg-white dark:hover:bg-gray-600 backdrop-blur-sm rounded-full shadow-lg hidden lg:flex items-center justify-center text-gray-800 dark:text-gray-200 transition-all z-20 hover:scale-110 focus:outline-none" onclick="prevSlide()" aria-label="Previous Slide">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="absolute top-1/2 right-4 transform -translate-y-1/2 w-12 h-12 bg-white/80 dark:bg-gray-700/80 hover:bg-white dark:hover:bg-gray-600 backdrop-blur-sm rounded-full shadow-lg hidden lg:flex items-center justify-center text-gray-800 dark:text-gray-200 transition-all z-20 hover:scale-110 focus:outline-none" onclick="nextSlide()" aria-label="Next Slide">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
            @foreach($featuredEvents as $index => $event)
            <button class="w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-blue-600 w-8' : 'bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500' }}" onclick="goToSlide({{ $index }})" id="dot-{{ $index }}" aria-label="Go to slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
    </div>
    @else
    <!-- Fallback if no events -->
    <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl p-12 text-center border border-gray-100 dark:border-gray-700">
        <p class="text-gray-500 dark:text-gray-400">No featured events at the moment.</p>
    </div>
    @endif
</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('[data-slide]');
    const dots = document.querySelectorAll('[id^="dot-"]');
    const totalSlides = slides.length;
    let slideInterval;

    function showSlide(index) {
        if (index < 0) index = totalSlides - 1;
        if (index >= totalSlides) index = 0;

        currentSlide = index;

        // Update Slides
        slides.forEach(slide => {
            slide.classList.remove('opacity-100', 'z-10');
            slide.classList.add('opacity-0', 'z-0');
        });
        slides[currentSlide].classList.remove('opacity-0', 'z-0');
        slides[currentSlide].classList.add('opacity-100', 'z-10');

        // Update Dots
        dots.forEach(dot => {
            dot.classList.remove('bg-blue-600', 'w-8');
            dot.classList.add('bg-gray-300');
        });
        const currentDot = document.getElementById(`dot-${currentSlide}`);
        if(currentDot) {
            currentDot.classList.remove('bg-gray-300');
            currentDot.classList.add('bg-blue-600', 'w-8');
        }
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function goToSlide(index) {
        showSlide(index);
        resetInterval();
    }

    function startInterval() {
        slideInterval = setInterval(nextSlide, 5000); // 5 seconds
    }

    function resetInterval() {
        clearInterval(slideInterval);
        startInterval();
    }

    // Initialize
    if (totalSlides > 0) {
        startInterval();

        // Pause on hover
        const carousel = document.getElementById('featuredCarousel');
        carousel.addEventListener('mouseenter', () => clearInterval(slideInterval));
        carousel.addEventListener('mouseleave', startInterval);
    }
</script>

    <!-- Latest Events -->
    <section class="py-16 max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 text-center relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-[60px] after:h-[3px] after:bg-blue-600 after:rounded-sm">Events in Phnom Penh</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events->take(6) as $event)
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                <a href="/events/{{ $event->event_id }}" class="block overflow-hidden">
                    <img src="{{ $event->picture_url ?? '/images/default-event.jpg' }}" alt="{{ $event->title }}" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105">
                </a>
                <div class="p-6 flex-1 flex flex-col">
                    <span class="inline-block bg-blue-50 dark:bg-blue-900/30 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold mb-3 uppercase self-start">{{ $event->category->name ?? 'Event' }}</span>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-gray-100 leading-tight">
                        <a href="/events/{{ $event->event_id }}" class="hover:text-blue-600 transition-colors">{{ $event->title }}</a>
                    </h3>
                    <div class="mt-auto pt-4 flex flex-col gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="flex items-center gap-2"><i class="fas fa-calendar text-blue-500 w-4"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                        <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-blue-500 w-4"></i> {{ Str::limit($event->location, 30) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="/events" class="inline-block bg-white dark:bg-gray-800 text-blue-600 px-8 py-3 rounded-full font-semibold border-2 border-blue-600 hover:bg-blue-600 hover:text-white hover:-translate-y-0.5 transition-all">View All Events</a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="bg-white dark:bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-16">
            <div class="flex-1 w-full">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-left relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-[60px] after:h-[3px] after:bg-blue-600 after:rounded-sm">Browse by Category</h2>
                <div class="flex flex-col">
                    @foreach($categories as $category)
                    <a href="/events?category={{ $category->category_id }}" class="group flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 text-gray-800 dark:text-gray-200 font-medium transition-all hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600 hover:pl-6">
                        {{ $category->name }}
                        <i class="fas fa-arrow-right opacity-0 transition-opacity group-hover:opacity-100"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="flex-1 w-full">
                <img src="/images/mis-datazone.jpg" alt="Events Category" class="w-full rounded-2xl shadow-lg">
            </div>
        </div>
    </section>

    <!-- Trending Section -->
    <section class="py-16 max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 text-center relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-[60px] after:h-[3px] after:bg-blue-600 after:rounded-sm">Trending Now</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events->sortByDesc('created_at')->take(3) as $event)
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                <a href="/events/{{ $event->event_id }}" class="block overflow-hidden">
                    <img src="{{ $event->picture_url ?? '/images/default-event.jpg' }}" alt="{{ $event->title }}" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105">
                </a>
                <div class="p-6 flex-1 flex flex-col">
                    <span class="inline-block bg-blue-50 dark:bg-blue-900/30 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold mb-3 uppercase self-start">{{ $event->category->name ?? 'Event' }}</span>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-gray-100 leading-tight">
                        <a href="/events/{{ $event->event_id }}" class="hover:text-blue-600 transition-colors">{{ $event->title }}</a>
                    </h3>
                    <div class="mt-auto pt-4 flex flex-col gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="flex items-center gap-2"><i class="fas fa-calendar text-blue-500 w-4"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                        <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-blue-500 w-4"></i> {{ Str::limit($event->location, 30) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-br from-blue-600 to-blue-700 text-white text-center py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold mb-4">Want to know more about us?</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">Learn about our mission to connect people through amazing local experiences and events.</p>
            <a href="/aboutus" class="inline-block bg-transparent text-white px-8 py-3 rounded-full font-semibold border-2 border-white hover:bg-white hover:text-blue-600 hover:-translate-y-0.5 transition-all">About Us</a>
        </div>
    </section>
@endsection
