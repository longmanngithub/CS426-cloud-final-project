@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-4 py-12 md:py-20 flex flex-col md:flex-row gap-12 items-start">
            <div class="flex-2 w-full md:w-2/3">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-6 relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-20 after:h-1 after:bg-blue-600 after:rounded-full">About Us</h1>

                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mt-8 mb-4">Team Members:</h2>
                <div class="mb-8">
                    <ul class="list-none p-0 m-0 space-y-2">
                        <li class="flex items-center gap-2 text-lg font-medium text-pink-600 bg-pink-50 dark:bg-pink-900/30 inline-block px-4 py-2 rounded-full border border-pink-100 dark:border-pink-800 w-fit">
                            <i class="fas fa-user-circle"></i> Kimsan kangloem
                        </li>
                        <li class="flex items-center gap-2 text-lg font-medium text-pink-600 bg-pink-50 dark:bg-pink-900/30 inline-block px-4 py-2 rounded-full border border-pink-100 dark:border-pink-800 w-fit">
                            <i class="fas fa-user-circle"></i> Sambath Vathana Chi
                        </li>
                        <li class="flex items-center gap-2 text-lg font-medium text-pink-600 bg-pink-50 dark:bg-pink-900/30 inline-block px-4 py-2 rounded-full border border-pink-100 dark:border-pink-800 w-fit">
                            <i class="fas fa-user-circle"></i> Chan Sophallika Chea
                        </li>
                    </ul>
                </div>

                <div class="prose prose-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                    <p>
                        The objective of this project is to create an accessible and user-friendly platform that help connect user with the local events throughout the community. This platform will be an easy way for people to know about the local events by allowing them to search, discover, and bookmark events based on their interests, location, and schedule. Moreover, it also helps the organizers by offering them a space to promote and showcase their events, as well as, reaching more audiences.
                    </p>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-600 p-6 rounded-r-lg">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fas fa-envelope text-blue-600"></i> Contact Us
                    </h2>
                    <div class="space-y-2 text-gray-700 dark:text-gray-300">
                        <p class="flex items-center gap-3"><i class="fas fa-at text-blue-500 w-5 text-center"></i> Eventdiscovery@gmail.com</p>
                        <p class="flex items-center gap-3"><i class="fas fa-phone text-blue-500 w-5 text-center"></i> 0123456789</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 w-full md:w-1/3 flex justify-center items-start pt-8">
                <img src="https://png.pngtree.com/png-vector/20221130/ourmid/pngtree-happy-business-characters-friendly-concept-set-people-head-project-vector-png-image_41202740.jpg" alt="Team discussing" class="max-w-full h-auto rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            </div>
        </section>
    </main>
@endsection
