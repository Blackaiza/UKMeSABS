<x-app-layout>
    <!-- Header Section -->
    <x-slot name="header">
        <!-- Flex container to align the back button and header -->
        <div class="flex justify-between items-center">
            <!-- Back Button -->
            <a href="{{ route('admin.manageNews') }}" class="flex items-center bg-purple-600 text-white text-sm font-semibold py-2 px-4 rounded-md shadow-md transition-all hover:bg-purple-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 transform transition-transform hover:translate-x-1">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7M5 12h13"></path>
    </svg>
    Back
</a>



            <!-- Header Title -->
            <h2 class="text-center text-3xl font-bold text-black dark:text-white mt-4">
                EDIT NEWS
            </h2>

            <!-- Placeholder for alignment -->
            <div class="w-16"></div>
        </div>
        <!--<p class="text-center text-gray-500 mx-auto">
            Choose your preferred date and time for the facility.
        </p>-->
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8 px-6 py-4 bg-gray-800 text-gray-200 rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold mb-6">Edit News</h1>

        <form action="{{ route('admin.updateNews', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium mb-2">Title</label>
                <input type="text" id="title" name="title" class="w-full px-4 py-2 bg-gray-900 text-gray-200 border border-gray-700 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none" value="{{ $news->title }}" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 bg-gray-900 text-gray-200 border border-gray-700 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none" required>{{ $news->description }}</textarea>
            </div>

            <!-- Date -->
            <div class="mb-4">
                <label for="date" class="block text-sm font-medium mb-2">Date</label>
                <input type="date" id="date" name="date" class="w-full px-4 py-2 bg-gray-900 text-gray-200 border border-gray-700 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none" value="{{ $news->date }}" required>
            </div>

            <!-- Picture -->
            <div class="mb-4">
                <label for="picture" class="block text-sm font-medium mb-2">Picture</label>
                <input type="file" id="picture" name="picture" class="w-full bg-gray-900 text-gray-200 border border-gray-700 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none">
                @if ($news->picture)
                    <div class="mt-4">
                        <label class="block text-sm mb-2">Current Picture:</label>
                        <img src="{{ Storage::url($news->picture) }}" width="150" alt="Current Picture" class="rounded-lg border border-gray-700">
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-500">
                    Update News
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
