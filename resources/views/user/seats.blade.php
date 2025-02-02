<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold text-white mt-4">
            Select Date and Time
        </h2>
    </x-slot>
    <div class="py-12">
        <form method="GET" action="/user/seats">
            <!-- Pass facility as a hidden input -->
            <input type="hidden" name="facility" value="{{ $facility }}">

            <!-- Select Date and Time -->
            <label for="datetime" class="block text-white">Select Date and Time:</label>
            <input type="datetime-local" id="datetime" name="datetime" required class="mt-2 p-2 rounded-lg">

            <!-- Next Button -->
            <div class="mt-6 flex justify-center">
                <button id="next-button" type="submit" class="bg-purple-600 text-white w-40 py-2 rounded-md hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    Next
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
