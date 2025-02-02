<x-app-layout>
    <!-- Header Section -->
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold  text-black dark:text-white mt-4">
            CHOOSE FACILITY TO MANAGE
        </h2>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Facility Cards Section -->
            <div id="cards-container" class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Card 1 -->
                <div data-card-id="gaming-pc" class="card bg-white-800 text-grey rounded-lg shadow-md p-4 transform transition-transform hover:scale-105 cursor-pointer">
                    <img src="{{ asset('images/gamingpc.jpg') }}" alt="Gaming PC"
                         class="rounded-md mb-4 w-full h-48 object-cover">
                    <h3 class="text-lg font-bold">Gaming PC</h3>
                    <p class="text-sm text-gray-400">Our signature</p>
                </div>

                <!-- Card 2 -->
                <div data-card-id="playstation-5" class="card bg-white-800 text-grey rounded-lg shadow-md p-4 transform transition-transform hover:scale-105 cursor-pointer">
                    <img src="{{ asset('images/ps5.jpg') }}" alt="PlayStation 5"
                         class="rounded-md mb-4 w-full h-48 object-cover">
                    <h3 class="text-lg font-bold">PlayStation 5</h3>
                    <p class="text-sm text-gray-400">Optional Choice</p>
                </div>

                <!-- Card 3 -->
                <div data-card-id="snooker-table-a" class="card bg-white-800 text-grey rounded-lg shadow-md p-4 transform transition-transform hover:scale-105 cursor-pointer">
                    <img src="{{ asset('images/snooker.png') }}" alt="Snooker Table A"
                         class="rounded-md mb-4 w-full h-48 object-cover">
                    <h3 class="text-lg font-bold">Snooker Table A</h3>
                    <p class="text-sm text-gray-400">Skill</p>
                </div>

                <!-- Card 4 -->
                <div data-card-id="snooker-table-b" class="card bg-white-800 text-grey rounded-lg shadow-md p-4 transform transition-transform hover:scale-105 cursor-pointer">
                    <img src="{{ asset('images/snookerB.jpg') }}" alt="Snooker Table B"
                         class="rounded-md mb-4 w-full h-48 object-cover">
                    <h3 class="text-lg font-bold">Snooker Table B</h3>
                    <p class="text-sm text-gray-400">Skill</p>
                </div>

                <!-- Card 5 -->
                <div data-card-id="racing-simulator" class="card bg-white-800 text-grey rounded-lg shadow-md p-4 transform transition-transform hover:scale-105 cursor-pointer">
                    <img src="{{ asset('images/racing.jpg') }}" alt="Racing Simulator"
                         class="rounded-md mb-4 w-full h-48 object-cover">
                    <h3 class="text-lg font-bold">Racing Simulator</h3>
                    <p class="text-sm text-gray-400">Ultimate Race</p>
                </div>
            </div>

            <!-- Next Button -->
            <div class="mt-6 flex justify-center">
                <button id="next-button" class="bg-purple-600 text-white w-40 py-2 rounded-md hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Next
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript for Facility Cards Selection -->
    <script>
        // Get all cards and the Next button
        const cards = document.querySelectorAll('.card');
        const nextButton = document.getElementById('next-button');
        let selectedCardId = null;

        // Map the selected card ID to the Blade view routes
        // const pageRoutes = {
        //     'gaming-pc': '/admin/gaming-pc/manage-seats',  // Redirect to gaming-pc.blade.php
        //     'playstation-5': '/admin/playstation-5/manage-seats',
        //     'snooker-table-a': '/admin/snooker-table-a/manage-seats',
        //     'snooker-table-b': '/admin/snooker-table-b/manage-seats',
        //     'racing-simulator': '/admin/racing-simulator/manage-seats'
        // };

        const pageRoutes = {
            'gaming-pc': '/admin/gamingpc',  // Redirect to gamingpc.blade.php
            'playstation-5': '/admin/playstation5',
            'snooker-table-a': '/admin/snooker-a',
            'snooker-table-b': '/admin/snooker-b',
            'racing-simulator': '/admin/racing-simulator'
        };

        // Add click event to each card
        cards.forEach(card => {
            card.addEventListener('click', () => {
                // Remove "selected" style from previously selected card
                cards.forEach(c => c.classList.remove('scale-110', 'border-4', 'border-purple-600'));

                // Add "selected" style to clicked card
                card.classList.add('scale-110', 'border-4', 'border-purple-600');

                // Update the selected card ID
                selectedCardId = card.getAttribute('data-card-id');

                // Enable the Next button
                nextButton.disabled = false;
            });
        });

        // Handle Next button click
        nextButton.addEventListener('click', () => {
            if (selectedCardId) {
                // Redirect to the appropriate page based on selected card
                window.location.href = pageRoutes[selectedCardId] || '/'; // Default to '/' if no match
            }
        });
    </script>

    <!-- Seat Management Section -->
   {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($seats as $seat)
                    <div class="card bg-gray-800 text-white rounded-lg shadow-md p-4">
                        <h3 class="text-lg font-bold">{{ $seat->name }}</h3>
                        <p class="text-sm text-gray-400">Status: {{ ucfirst($seat->status) }}</p>

                        <form action="{{ route('seats.updateStatus', $seat->id) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()">
                                <option value="available" {{ $seat->status == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="reserved" {{ $seat->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                <option value="occupied" {{ $seat->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                            </select>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

</x-app-layout>