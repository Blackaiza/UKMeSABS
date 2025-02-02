<x-app-layout>
    <!-- Page Header -->
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold text-black dark:text-white mt-4">
            USER HISTORY
        </h2>
    </x-slot>

    <!-- Include SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Display Success Message -->
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Booking Successful',
                text: 'We already recorded your Booking!',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    <!-- Include Font Awesome for icons -->
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>

    <!-- Styling -->
    <style>
        #cards-container {
            background-color: #2d3748;
            padding: 20px;
            border-radius: 10px;
        }

        .ticket {
            background-color: #fff;
            border-radius: 8px;
            margin-bottom: 16px;
            padding: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border-left: 8px solid #4C51BF;
        }

        .ticket:hover {
            transform: translateY(-5px);
        }

        .ticket img {
            border-radius: 8px;
        }

        .ticket-reference {
            font-size: 0.9rem;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .ticket-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .ticket-list::-webkit-scrollbar {
            width: 6px;
        }

        .ticket-list::-webkit-scrollbar-thumb {
            background-color: #CBD5E0;
            border-radius: 6px;
        }

        .ticket-list::-webkit-scrollbar-track {
            background: #F7FAFC;
        }
    </style>

    <!-- Page Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Today Tickets Section -->
            <div class="ticket-section">
                <h3 class="text-2xl font-bold text-white mb-4">Today</h3>
                <div class="ticket-list">
                    @foreach ($carts->filter(function($cart) {
                        return \Carbon\Carbon::parse($cart->date)->isToday();
                    }) as $cart)
                    <div class="ticket facility-{{ $cart->facility->id }}">
                        <div class="grid grid-cols-4 gap-4 items-center">
                            <!-- Column 1: Title with Picture -->
                            <div class="col-span-1 flex flex-col items-center">
                                <img 
                                    src="{{ asset('images/' . strtolower(str_replace(' ', '_', $cart->facility->id)) . '.jpg') }}" 
                                    alt="{{ $cart->facility->name }}" 
                                    class="w-full h-32 object-cover rounded-lg"
                                />
                                <h1 class="text-lg font-bold text-gray-800 mt-2">{{ $cart->facility->name }}</h1>
                            </div>

                            <!-- Column 2: Location -->
                            <div class="col-span-1 text-center">
                                <p class="text-sm font-semibold text-gray-500">Location</p>
                                <p class="text-base font-bold text-gray-800">{{ $cart->seat->seat_number}}</p>
                            </div>

                            <!-- Column 3: Date & Time -->
                            <div class="col-span-1 text-center">
                                <p class="text-sm font-semibold text-gray-500">Date & Time</p>
                                <p class="text-base font-bold text-gray-800">
                                    {{ \Carbon\Carbon::parse($cart->date)->format('F jS, Y') }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $cart->time->timerange }}</p>
                            </div>

                            <!-- Column 4: Ticket Reference -->
                            <div class="col-span-1 flex flex-col items-center">
                                <p class="text-sm font-semibold text-gray-500">Ticket Ref</p>
                                <div class="ticket-reference bg-green-500 text-white text-sm font-bold px-4 py-2 rounded-full">
                                    #{{ $cart->booking_id_succesful }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Upcoming Tickets Section -->
            <div class="ticket-section">
                <h3 class="text-2xl font-bold text-white mb-4">Upcoming Booking</h3>
                <div class="ticket-list">
                    @foreach ($carts->filter(function($cart) {
                        return \Carbon\Carbon::parse($cart->date)->isFuture();
                    }) as $cart)
                    <div class="ticket facility-{{ $cart->facility->id }}">
                        <div class="grid grid-cols-4 gap-4 items-center">
                            <!-- Same structure as above -->
                            <div class="col-span-1 flex flex-col items-center">
                                <img 
                                    src="{{ asset('images/' . strtolower(str_replace(' ', '_', $cart->facility->id)) . '.jpg') }}" 
                                    alt="{{ $cart->facility->name }}" 
                                    class="w-full h-32 object-cover rounded-lg"
                                />
                                <h1 class="text-lg font-bold text-gray-800 mt-2">{{ $cart->facility->name }}</h1>
                            </div>
                            <div class="col-span-1 text-center">
                                <p class="text-sm font-semibold text-gray-500">Location</p>
                                <p class="text-base font-bold text-gray-800">{{ $cart->seat->seat_number }}</p>
                            </div>
                            <div class="col-span-1 text-center">
                                <p class="text-sm font-semibold text-gray-500">Date & Time</p>
                                <p class="text-base font-bold text-gray-800">
                                    {{ \Carbon\Carbon::parse($cart->date)->format('F jS, Y') }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $cart->time->timerange }}</p>
                            </div>
                            <div class="col-span-1 flex flex-col items-center">
                                <p class="text-sm font-semibold text-gray-500">Ticket Ref</p>
                                <div class="ticket-reference bg-yellow-500 text-white text-sm font-bold px-4 py-2 rounded-full">
                                    #{{ $cart->booking_id_succesful }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        <!-- Expired Tickets Section -->
<div class="ticket-section">
    <h3 class="text-2xl font-bold text-white mb-4 flex justify-between items-center">
        <span>Expired Booking</span>
        <!-- Toggle Button -->
        <button id="toggleExpiredTickets" class="text-blue-500">
            <i id="toggleIcon" class="fas fa-chevron-down"></i>
        </button>
    </h3>
    <!-- Collapsible Content -->
    <div id="expiredTicketsContent" class="ticket-list">
        @foreach ($carts->filter(function($cart) {
            return \Carbon\Carbon::parse($cart->date)->isPast();
        }) as $cart)
        <div class="ticket facility-{{ $cart->facility->id }}">
            <div class="grid grid-cols-4 gap-4 items-center">
                <!-- Same structure as above -->
                <div class="col-span-1 flex flex-col items-center">
                    <img 
                        src="{{ asset('images/' . strtolower(str_replace(' ', '_', $cart->facility->id)) . '.jpg') }}" 
                        alt="{{ $cart->facility->name }}" 
                        class="w-full h-32 object-cover rounded-lg"
                    />
                    <h1 class="text-lg font-bold text-gray-800 mt-2">{{ $cart->facility->name }}</h1>
                </div>
                <div class="col-span-1 text-center">
                    <p class="text-sm font-semibold text-gray-500">Location</p>
                    <p class="text-base font-bold text-gray-800">{{ $cart->seat->seat_number }}</p>
                </div>
                <div class="col-span-1 text-center">
                    <p class="text-sm font-semibold text-gray-500">Date & Time</p>
                    <p class="text-base font-bold text-gray-800">
                        {{ \Carbon\Carbon::parse($cart->date)->format('F jS, Y') }}
                    </p>
                    <p class="text-sm text-gray-600">{{ $cart->time->timerange }}</p>
                </div>
                <div class="col-span-1 flex flex-col items-center">
                    <p class="text-sm font-semibold text-gray-500">Ticket Ref</p>
                    <div class="ticket-reference bg-red-500 text-white text-sm font-bold px-4 py-2 rounded-full">
                        #{{ $cart->booking_id_succesful }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- JavaScript to toggle the section -->
<script>
    document.getElementById('toggleExpiredTickets').addEventListener('click', function() {
        const content = document.getElementById('expiredTicketsContent');
        const icon = document.getElementById('toggleIcon');
        
        // Toggle visibility
        content.classList.toggle('hidden');
        
        // Change icon based on visibility
        if (content.classList.contains('hidden')) {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        } else {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        }
    });
</script>

</x-app-layout>