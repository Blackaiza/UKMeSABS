<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold text-black dark:text-white mt-4">
            MAKE BOOKING
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('Cancelled'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',  // Danger icon
                title: 'Booking Canceled',
                text: 'You have canceled the booking and it will not be recorded.',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Facility Cards Section -->
            <div id="cards-container" class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
               @foreach($facilities as $facility)
                    <div
                        data-card-id="{{ $facility['slug'] }}"
                        class="card bg-white text-black dark:bg-gray-800 dark:text-white rounded-lg shadow-md p-4 transform transition-transform hover:scale-105 cursor-pointer">
                        <img src="{{ asset('images/' . $facility['image']) }}" alt="{{ $facility['name'] }}" class="rounded-md mb-4 w-full h-48 object-cover">
                        <h3 class="text-lg font-bold">{{ $facility['name'] }}</h3>
                        <p class="text-sm text-gray-400">{{ $facility['slogan'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Next Button -->
            <div class="mt-6 flex justify-center">
                <button id="next-button" class="bg-purple-600 text-white w-40 py-2 rounded-md hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Next
                </button>
            </div>
        </div>
    </div>

    <script>
        const cards = document.querySelectorAll('.card');
        const nextButton = document.getElementById('next-button');
        let selectedCardId = null;

        // Attach click events
        cards.forEach(card => {
            card.addEventListener('click', () => {
                cards.forEach(c => c.classList.remove('scale-110', 'border-4', 'border-purple-600'));
                card.classList.add('scale-110', 'border-4', 'border-purple-600');
                selectedCardId = card.getAttribute('data-card-id');
                nextButton.disabled = false;
            });
        });

        // Redirect on "Next" button click
        nextButton.addEventListener('click', () => {
            if (selectedCardId && pageRoutes[selectedCardId]) {
                window.location.href = pageRoutes[selectedCardId];
            }
        });

        const pageRoutes = @json(collect($facilities)->mapWithKeys(function ($facility) {
    return [$facility['slug'] => route('user.date-time', ['facility_id' => $facility['id']])];
}));
    </script>
</x-app-layout>
