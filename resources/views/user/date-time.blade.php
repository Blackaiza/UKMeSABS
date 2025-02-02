<x-app-layout>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    </head>
    <!-- Header Section -->
    <x-slot name="header">
        <!-- Flex container to align the back button and header -->
        <div class="flex justify-between items-center">
            <!-- Back Button -->
            <a href="{{ route('user.booking') }}" class="flex items-center bg-purple-600 text-white text-sm font-semibold py-2 px-4 rounded-md shadow-md transition-all hover:bg-purple-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 transform transition-transform hover:translate-x-1">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7M5 12h13"></path>
    </svg>
    Back
</a>


    
            <!-- Header Title -->
            <h2 class="text-center text-3xl font-bold text-black dark:text-white mt-4">
                Select Date and Time
            </h2>

            <!-- Placeholder for alignment -->
            <div class="w-16"></div>
        </div>
        <!--<p class="text-center text-gray-500 mx-auto">
            Choose your preferred date and time for the facility.
        </p>-->
    </x-slot>

    <!-- Main Content -->
    <div class="py-12 ">
        <div class="max-w-lg mx-auto bg-white text-black dark:bg-gray-800 dark:text-white rounded-lg shadow-lg p-6 sm:p-10">
            <form method="POST" action="{{ route('user.gamingpc', ['facility_id' => $facilityId]) }}">
                @csrf
                @method('GET')

                <!-- Date Picker -->
                <label for="datetime" class="block text-lg font-semibold my-9 bg-white text-black dark:bg-gray-800 dark:text-white">
                    Select Date :
                </label>

                <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        {{-- Gambar icon date --}}
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>

                    <input
                        id="datepicker-autohide"
                        name="date"
                        type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date"
                    />
                </div>

                <label for="datetime" class="block text-lg font-semibold my-9 bg-white text-black dark:bg-gray-800 dark:text-white">
                    Select Time :
                </label>

                @if($timeRanges->count() > 0)
                <div class="mt-6 flex flex-wrap gap-4 justify-center">
                    @foreach ($timeRanges as $time)
                        <button
                            type="button"
                            class="time-button bg-gray-300  hover:bg-purple-700 hover:text-white text-black font-medium px-4 py-2 rounded-lg shadow-md transition"
                            onclick="selectTime('{{ $time->timerange }}', this)"
                        >
                            {{ $time->timerange }}
                        </button>
                    @endforeach
                </div>
                <!-- Hidden Input to Store Selected Time -->
                <input type="hidden" name="time" id="selected-time" required>
            @else
                <p class="text-center text-gray-300 mt-6">
                    No session times assigned in the database yet! Please contact Admin.
                </p>
            @endif
                    <!-- Next Button -->
                    <div class="mt-6 flex justify-center">
                        <button id="next-button" class="bg-purple-600 text-white w-40 py-2 rounded-md hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next
                        </button>
                    </div>
                </div>
            </form>

            <script>
                function selectTime(time, button) {
                    // Set the selected time in the hidden input field
                    document.getElementById('selected-time').value = time;
            
                    // Remove the selected style from all time buttons
                    document.querySelectorAll('.time-button').forEach(btn => {
                        btn.classList.remove('bg-purple-600', 'text-white');
                        btn.classList.add('bg-gray-300', 'text-black');
                    });
            
                    // Highlight the clicked button
                    button.classList.add('bg-purple-600', 'text-white');
                    button.classList.remove('bg-gray-300', 'text-black');
                }
            
                document.addEventListener("DOMContentLoaded", function () {
                    const datepicker = new Datepicker(document.getElementById("datepicker-autohide"), {
                        autohide: true,
                        format: "dd/mm/yyyy", // Display date as DD/MM/YYYY
                        minDate: new Date(), // Set the minimum date to today
                    });
                });
            </script>

        </div>
    </div>
</x-app-layout>
