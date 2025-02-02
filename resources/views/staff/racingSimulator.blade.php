<x-app-layout>
    <!-- Header Section -->
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold text-white mt-4">
            CHOOSE SEATS TO MANAGE
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 sm:p-6 lg:p-8">
        <!-- Seats List -->
        <div class="bg-white rounded-xl p-6 shadow-lg">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">
                List of Seats
            </h3>

            @if($seatsCount->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-600 text-white">
                        <tr>
                            <th scope="col" class="py-3 px-6">ID</th>
                            <th scope="col" class="py-3 px-6">Facility ID</th>
                            <th scope="col" class="py-3 px-6">Seat Number</th>
                            <th scope="col" class="py-3 px-6">Status</th>
                            <th scope="col" class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($seatsCount as $seats)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200">
                                <td class="py-4 px-6 text-gray-600">{{ $seats->id }}</td>
                                <td class="py-4 px-6 text-gray-800">{{ $seats->Facility->name }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $seats->seat_number }}</td>
                                <td class="py-4 px-6 text-gray-800">{{ ucfirst($seats->status) }}</td>
                                <td class="py-4 px-6 text-center space-x-4">
                                    <div class="flex justify-center space-x-4">
                                        <!-- Edit Button -->
                                        <a href="{{ route('staff.seats.edit', $seats->id) }}"
                                           class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg shadow-md transition duration-300">
                                           Edit
                                        </a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('staff.seats.destroy', $seats->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white font-medium px-4 py-2 rounded-lg shadow-md transition duration-300">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $seatsCount->links('pagination::tailwind') }}
                </div>
            </div>
            @else
                <p class="text-center text-gray-400 mt-6">No seats available. Please add some seats!</p>
            @endif
        </div>
    </div>
</x-app-layout>
