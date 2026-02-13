@extends('layouts.app')

@section('title', 'Edit Event - Organizer Dashboard')

@section('content')
    <section class="bg-gradient-to-br from-[#1a1a2e] via-[#16213e] to-[#0f3460] text-white py-12 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-2"><i class="fas fa-edit mr-2"></i> Edit Event</h1>
        <p class="text-white/80">Update your event details and manage information</p>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <section class="w-full">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                <div class="mb-8 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold flex items-center gap-2 dark:text-white">
                        <i class="fas fa-calendar-check text-blue-600"></i> Event Details: {{ $event->title }}
                    </h2>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg relative text-sm" role="alert">
                        <ul class="list-disc list-inside m-0 pl-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/events/{{ $event->event_id }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @csrf
                    @method('PUT')

                    <!-- Left Column: Poster Upload -->
                    <div class="lg:col-span-1 lg:order-first flex flex-col gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Event Poster</label>
                            <div class="relative w-full overflow-hidden">
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl flex flex-col items-center justify-center h-[400px] bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 hover:border-blue-500 transition-all cursor-pointer relative overflow-hidden group" id="posterContainer">
                                    <img id="imagePreview" src="{{ $event->picture_url ?: '#' }}" alt="Preview" class="{{ $event->picture_url ? '' : 'hidden' }} w-full h-full object-contain bg-gray-100 dark:bg-gray-700">
                                    <div class="text-center p-6 {{ $event->picture_url ? 'hidden' : '' }}" id="uploadPlaceholder">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 dark:text-gray-600 mb-3 group-hover:text-blue-500 transition-colors"></i>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm"><strong>Click to replace</strong><br>or drag and drop</p>
                                        <p class="text-xs text-gray-400 mt-2">SVG, PNG, JPG or GIF</p>
                                    </div>
                                    <input type="file" name="picture_file" id="picture_file" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10">
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="text" name="picture_url" id="picture_url" value="{{ $event->getRawOriginal('picture_url') }}" placeholder="Or paste image URL here" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all text-sm dark:placeholder-gray-500">
                        </div>
                    </div>

                    <!-- Right Column: Form Fields -->
                    <div class="lg:col-span-2 flex flex-col gap-5">
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Event Title <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" value="{{ $event->title }}" placeholder="Enter event title" required class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all dark:placeholder-gray-500">
                        </div>

                        <div class="space-y-2">
                            <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Category <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="category_id" name="category_id" required class="w-full px-4 py-3 pr-10 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all appearance-none bg-white">
                                    <option value="">Select a category</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->category_id }}" {{ $event->category_id == $category->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2 min-w-0">
                                <label for="start_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Start Date <span class="text-red-500">*</span></label>
                                <input type="{{ $event->start_date ? 'date' : 'text' }}" id="start_date" name="start_date" value="{{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') : '' }}" required placeholder="Select Start Date" onfocus="(this.type='date')" onblur="(this.value ? this.type='date' : this.type='text')" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border dark:placeholder-gray-500">
                            </div>
                            <div class="space-y-2 min-w-0">
                                <label for="start_time" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Start Time <span class="text-red-500">*</span></label>
                                <input type="{{ $event->start_time ? 'time' : 'text' }}" id="start_time" name="start_time" value="{{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '' }}" required placeholder="Select Start Time" onfocus="(this.type='time')" onblur="(this.value ? this.type='time' : this.type='text')" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border dark:placeholder-gray-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2 min-w-0">
                                <label for="end_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">End Date (Optional)</label>
                                <input type="{{ $event->end_date ? 'date' : 'text' }}" id="end_date" name="end_date" value="{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d') : '' }}" placeholder="Select End Date" onfocus="(this.type='date')" onblur="(this.value ? this.type='date' : this.type='text')" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border dark:placeholder-gray-500">
                            </div>
                            <div class="space-y-2 min-w-0">
                                <label for="end_time" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">End Time (Optional)</label>
                                <input type="{{ $event->end_time ? 'time' : 'text' }}" id="end_time" name="end_time" value="{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '' }}" placeholder="Select End Time" onfocus="(this.type='time')" onblur="(this.value ? this.type='time' : this.type='text')" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border dark:placeholder-gray-500">
                            </div>
                        </div>

                        <div class="space-y-2 min-w-0">
                            <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Location <span class="text-red-500">*</span></label>
                            <input type="text" id="location" name="location" value="{{ $event->location }}" placeholder="Event location or venue" required class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border dark:placeholder-gray-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2 min-w-0">
                                <label for="price" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Price <span class="text-red-500">*</span></label>
                                <input type="number" id="price" name="price" value="{{ $event->price }}" placeholder="Enter 0 for free events" min="0" step="0.01" required class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border dark:placeholder-gray-500">
                            </div>
                            <div class="space-y-2 min-w-0">
                                <label for="link" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Registration Link (Optional)</label>
                                <input type="text" id="link" name="link" value="{{ $event->link }}" placeholder="e.g. Google Form link" class="appearance-none block w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-w-0 box-border dark:placeholder-gray-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Description</label>
                            <textarea id="description" name="description" placeholder="Describe your event..." class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-h-[120px] resize-y dark:placeholder-gray-500">{{ $event->description }}</textarea>
                        </div>

                        <div class="flex gap-4 mt-2">
                            <a href="/orgmyevents" class="flex-1 bg-red-50 dark:bg-red-900/50 text-red-600 dark:text-red-400 px-6 py-4 rounded-lg font-semibold hover:bg-red-100 dark:hover:bg-red-900/70 transition-colors flex items-center justify-center gap-2 no-underline">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="flex-[3] bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fas fa-save"></i> Update Event
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('picture_file').addEventListener('change', function(event) {
            const [file] = event.target.files;
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        });

        document.getElementById('picture_url').addEventListener('input', function(event) {
            const url = event.target.value;
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');

            if (url) {
                preview.src = url;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                document.getElementById('picture_file').value = '';
            } else if (!document.getElementById('picture_file').files.length) {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        });
    </script>
@endsection
