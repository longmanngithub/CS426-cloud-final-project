@extends('layouts.app')

@section('title', 'Contact Us')

@section('hide-global-errors', true)

@section('content')
    <main class="flex-grow">
        <section class="max-w-4xl mx-auto px-4 py-12 md:py-20">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden md:flex">
                <div class="bg-blue-600 text-white p-8 md:w-1/3 flex flex-col justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-6">Contact Us</h1>
                        <p class="mb-8 text-blue-100">Have questions or feedback? We'd love to hear from you.</p>

                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="bg-blue-500 w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-lg text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg leading-tight">Email</h3>
                                    <p class="text-blue-100 text-sm">info@localevents.com</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="bg-blue-500 w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone text-lg text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg leading-tight">Phone</h3>
                                    <p class="text-blue-100 text-sm">+855 12 345 678</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="bg-blue-500 w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-lg text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg leading-tight">Address</h3>
                                    <p class="text-blue-100 text-sm">Phnom Penh, Cambodia</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 md:mt-0">
                        <div class="flex gap-4">
                            <a href="#" class="bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors text-white">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="#" class="bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors text-white">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            <a href="#" class="bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors text-white">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-8 md:w-2/3">
                    @if (session('success'))
                        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg relative text-sm" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg relative text-sm" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg relative text-sm" role="alert">
                            <ul class="list-disc list-inside m-0 pl-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/contactus/send" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Name</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" placeholder="John Doe">
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Email</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" placeholder="john.doe@example.com">
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                            <textarea id="message" name="message" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-h-[150px] resize-y" placeholder="Your message"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-700 transform hover:-translate-y-0.5 transition-all duration-200">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
