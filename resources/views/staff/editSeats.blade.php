<x-app-layout>
    <!-- Header Section -->
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold text-white mt-4">
            EDIT SEATS
        </h2>
    </x-slot>

    <!-- Main Content Section -->
    <div class="max-w-2xl mx-auto mt-8 bg-gray-300 p-4 rounded-lg shadow-md">
        @if ($errors->any())
            <div class="mb-4">
                <ul class="bg-red-100 text-red-700 p-3 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4">
                <p class="bg-green-100 text-green-700 p-3 rounded-lg">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('staff.seats.update', $seats->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Include this for PUT requests -->

            <!-- Status Section -->
            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-bold mb-2">Status:</label>
                <select 
                    id="status" 
                    name="status" 
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                    required>
                    <option value="available" {{ $seats->role == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="maintenance" {{ $seats->role == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                <!--
                <label class="block text-gray-700 font-bold mb-2">Status:</label>
                <input
                    type="hidden"
                    id="status"
                    name="status"
                    value="{{ old('status', $seats->price) }}">
                <div class="flex gap-2">
                    <button type="button" id="availableButton"
                            class="status-button bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600"
                            onclick="setStatus('Available', this)">Available</button>
                    <button type="button" id="maintainButton"
                            class="status-button bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-600"
                            onclick="setStatus('Maintain', this)">Maintain</button>
                </div>
                -->
            </div>

            <!-- Time Section -->
            <!--
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Time:</label>
                <input
                    type="hidden"
                    id="time"
                    name="time"
                    value="{{ old('time', $seats->price) }}">
                <div class="flex gap-2 flex-wrap">
                    <button type="button" class="time-button bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600"
                            onclick="setTime('9 AM - 10 AM', this)">9 AM - 10 AM</button>
                    <button type="button" class="time-button bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600"
                            onclick="setTime('10 AM - 11 AM', this)">10 AM - 11 AM</button>
                    <button type="button" class="time-button bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600"
                            onclick="setTime('11 AM - 12 PM', this)">11 AM - 12 PM</button>
                </div>
            </div>
            -->

            <!-- JavaScript -->
            <!--
            <script>
                function setStatus(value, button) {
                    // Set the hidden input value
                    document.getElementById('status').value = value;

                    // Reset all status buttons' styles
                    document.querySelectorAll('.status-button').forEach(btn => {
                        btn.classList.remove('bg-green-700', 'bg-red-700');
                        btn.classList.add('bg-green-500', 'bg-red-500');
                    });

                    // Highlight the clicked button
                    button.classList.add('bg-green-700', 'bg-red-700');
                }

                function setTime(value, button) {
                    // Set the hidden input value
                    document.getElementById('time').value = value;

                    // Reset all time buttons' styles
                    document.querySelectorAll('.time-button').forEach(btn => {
                        btn.classList.remove('bg-blue-700');
                        btn.classList.add('bg-gray-500');
                    });

                    // Highlight the clicked button
                    button.classList.add('bg-blue-700');
                }
            </script>
            -->

            <!-- Price Field -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price:</label>
                <input
                    type="text"
                    id="price"
                    name="price"
                    value="{{ old('price', $seats->price) }}"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-3 bg-purple-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
