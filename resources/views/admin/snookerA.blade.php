<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<x-app-layout>
    <!-- Header Section -->
    <x-slot name="header">
    <!-- Flex container to align the back button and header -->
    <div class="flex justify-between items-center">
        <!-- Back Button -->
        <button type="button" onclick="window.location.href='{{ route('admin.managefacility') }}';" class="flex items-center bg-purple-600 text-white text-sm font-semibold py-2 px-4 rounded-md shadow-md transition-all hover:bg-purple-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 transform transition-transform hover:translate-x-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7M5 12h13"></path>
            </svg>
            Back
        </button>

        <!-- Header Title -->
        <h2 class="text-center text-3xl font-bold text-black dark:text-white mt-4">
            CHOOSE SEATS TO MANAGE
        </h2>

        <!-- Placeholder for alignment -->
        <div class="w-16"></div>
    </div>
</x-slot>


    <div class="container mx-auto p-6 sm:p-6 lg:p-8">
    @if ($errors->any())
            <div class="mb-4">
                <ul class="bg-red-100 text-red-700 p-3 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('UpdateSuccessSeats'))
            <div class="mb-4">
                <p class="bg-green-100 text-green-700 p-3 rounded-lg">{{ session('UpdateSuccessSeats') }}</p>
            </div>
        @endif
        
        <!-- Staff List -->
        <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
            <h3 class="text-xl text-gray-100 mb-6 font-semibold">
                List of Seats
            </h3>

            @if($seatsCount->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs uppercase bg-purple-700 text-gray-300">
                        <tr>
                            <th scope="col" class="py-3 px-6">ID</th>
                            <th scope="col" class="py-3 px-6">Facility Name</th>
                            <th scope="col" class="py-3 px-6">Seat Number</th>
                            <th scope="col" class="py-3 px-6">Price</th>
                            <th scope="col" class="py-3 px-6">Status</th>
                            <th scope="col" class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($seatsCount as $seat)
                            <tr class="border-b border-gray-600 hover:bg-gray-600 transition 
                                {{ $seat->status === 'maintenance' ? 'bg-red-900 dark:bg-red-900 hover:bg-red-600' : '' }}">
                                <td class="py-4 px-6">{{ $seat->id }}</td>
                                <td class="py-4 px-6">{{ $seat->Facility->name }}</td>
                                <td class="py-4 px-6">{{ $seat->seat_number }}</td>
                                <td class="py-4 px-6 text-white">RM {{ number_format($seat->price, 2) }}</td>
                                <td class="py-4 px-6">{{ $seat->status }}</td>
                                <td class="py-4 px-6 text-center space-x-4">
                                    <div class="flex justify-center space-x-4">
                                        <a href="{{ route('admin.seats.edit', $seat->id) }}"
                                            class="inline-flex items-center justify-center w-24 h-10 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg shadow-md transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.seats.destroy', $seat->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-24 h-10 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg shadow-md transition">
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
            @else
                <p class="text-center text-gray-300 mt-6">No seats found. Add some seats!</p>
            @endif
            </div>
        </div>
    </div>
</x-app-layout>