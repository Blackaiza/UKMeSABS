<?php
$currentseat = 'currentValue';
?>

<x-app-layout>
    <!-- Header Section -->
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold dark:text-white text-gray-800 ">
            Select Seat
        </h2>
        <p class="text-center text-gray-500 ">
            <span class="pr-4">Date : {{ $selectedDate }}</span>
            <span>Time : {{ $selectedTime }}</span>.
        </p>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12 ">
                <div class="max-w-lg mx-auto bg-white text-black dark:bg-gray-800 dark:text-white rounded-lg shadow-lg p-6 sm:p-10">
                        <form action="{{ route('user.add.cart') }}" method="POST">
                            {{-- <form action="{{ route('user.checkout',['user_id'=>Auth::id(), 'date'=>$formattedDate,'time_id'=>$timeId,'facility_id'=>$facilityId]) }}" method="POST"> --}}
                            @csrf
                            @method('POST')

                                    <!-- Date Picker -->
                                    <label for="Select Seat" class="block text-lg font-semibold text-black dark:bg-gray-800 dark:text-white text-center">
                                        Choose Seat
                                    </label>

                                    <!-- Legend -->
                                    <div class="legend mt-6 text-center">
                                        <span class="inline-block w-4 h-4 bg-purple-700 border border-black mr-2 "></span> Selected
                                        <span class="inline-block w-4 h-4 bg-yellow-400 border border-black ml-4 mr-2"></span> Occupied
                                        <span class="inline-block w-4 h-4 bg-red-500 border border-black ml-4"></span> Maintained
                                    </div>

                                    <!-- Seat Grid -->
                                    <div class="seat-grid">
                                        @if ($seatsCount->count() > 0)
                                            @foreach ($seatsCount as $seat)
                                                <div
                                                    class="seat-box"
                                                    data-seat="{{ $seat->id }}"
                                                    data-price="{{ $seat->price }}"
                                                    onclick="selectSeat(this)"
                                                >
                                                    {{ $seat->seat_number }}
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-center text-gray-300 mt-6">
                                                No seats available. Please check back later.
                                            </p>
                                        @endif
                                    </div>

                <!-- Hidden Inputs -->
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="date" value="{{ $formattedDate }}">
                <input type="hidden" name="time_id" id="time_id" value="{{ $timeId }}">
                <input type="hidden" name="facility_id" value="{{ $facilityId }}">
                <input type="hidden" name="seat_id" id="seat_id" value="" >

                <!-- Next Button -->
                <div class="mt-6 flex justify-center">
                    <button id="next-button" class="bg-purple-600 text-white w-40 py-2 rounded-md hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed">
                        Add To Cart
                    </button>
                </div>
            </form>

            <script>
                // JavaScript
                const seatBoxes = document.querySelectorAll('.seat-box');
                const seatIdInput = document.getElementById('seat_id');
                const nextButton = document.getElementById('next-button');

                // Set the value when a seat is clicked
                seatBoxes.forEach(seat => {
                    seat.addEventListener('click', () => {
                        const selectedSeatId = seat.getAttribute('data-seat'); // Get data attribute
                        seatIdInput.value = selectedSeatId; // Assign value to hidden input
                        console.log(`Assigned Seat ID: ${seatIdInput.value}`); // Log for debugging

                        // Optionally, you can highlight the selected seat
                        seatBoxes.forEach(s => s.classList.remove('selected')); // Remove selected class from all seats
                        seat.classList.add('selected'); // Add selected class to the clicked seat

                        // Enable the Next button if a seat is selected
                        nextButton.disabled = false; // Enable the button
                    });
                });

                // // Optional: Check value on button click for debugging
                // nextButton.addEventListener('click', () => {
                //     const currentValue = seatIdInput.value; // Access the value
                //     alert(`Current Selected Seat ID: ${currentValue}`);
                // });
            </script>

             {{-- <script>
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
            </script> --}}

        </div>
    </div>

    <style>
        .seat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
            gap: 10px;
            margin-top: 20px;
        }

        .seat-box {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
        }

        .seat-box.selected {
    background-color: #63b3ed; /* Blue */
    color: #ffffff;
    border-color: #63b3ed;
}


                                    /* Page Background */
                                    .bg-gradient {
                    background: linear-gradient(to bottom right, #2d3748, #4a5568);
                    min-height: 100vh;
                    padding: 2rem 0;
                }

                /* Form Container */
                .form-container {
                    background-color: #ffffff;
                    border-radius: 16px;
                    padding: 3rem;
                    max-width: 600px;
                    margin: 1rem auto;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                    text-align: center;
                }

                /* Header Styling */
                .header h2 {
                    font-size: 2.5rem;
                    color: #2d3748;
                    font-weight: bold;
                }

                .header p {
                    font-size: 1.1rem;
                    color: #4a5568;
                    margin-top: 0.5rem;
                }

                /* Seat Grid */
                .seat-grid {
                    display: grid;
                    grid-template-columns: repeat(5, 1fr);
                    gap: 16px;
                    margin-top: 2rem;
                }

                .seat-box {
                    width: 70px;
                    height: 70px;
                    background-color: #edf2f7;
                    border: 2px solid #cbd5e0;
                    border-radius: 12px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    font-weight: bold;
                    font-size: 16px;
                    transition: all 0.3s ease;
                    cursor: pointer;
                }

                .seat-box:hover {
                    background-color: #e2e8f0;
                    transform: scale(1.05);
                }

                .seat-box.selected {
                    background-color: #63b3ed; /* Blue */
                    color: #ffffff;
                    border-color: #63b3ed;
                }

                /* Price Display */
                .price-container {
                    margin-top: 12px; /* Reduced margin-top */
                    font-size: 1.2rem;
                    color: #2d3748;
                    display: none;
                }

                /* Next Button */
                .next-btn {
                    background: linear-gradient(to right, #6b46c1, #553c9a);
                    color: white;
                    padding: 14px;
                    font-size: 1.2rem;
                    border-radius: 8px;
                    width: 100%;
                    margin-top: 0.5px; /* Reduced margin-top to bring the button closer to the price */
                    cursor: pointer;
                    transition: all 0.3s ease;
                    opacity: 0.5;
                }

                .next-btn:hover {
                    background: linear-gradient(to right, #553c9a, #44337a);
                }

                .next-btn:disabled {
                    background-color: #cbd5e0;
                    cursor: not-allowed;
                    opacity: 0.5;
                }

                /* Adjust margin-top for Next Button once a seat is selected */
                .next-btn-enabled {
                    margin-top: 0.5px; /* Even smaller margin after selecting a seat */
                    opacity: 1;
                }
    </style>

</x-app-layout>




            <!-- JavaScript -->
            {{-- <script>
                const seatBoxes = document.querySelectorAll('.seat-box');
                const nextBtn = document.getElementById('next-btn');
                const priceContainer = document.querySelector('.price-container');
                const seatPrice = document.getElementById('seat-price');
                let selectedSeat = null;

                seatBoxes.forEach(seat => {
                    seat.addEventListener('click', () => {
                        // Remove selected class from all seats
                        seatBoxes.forEach(s => s.classList.remove('selected'));

                        // Add selected class to the clicked seat
                        seat.classList.add('selected');
                        selectedSeat = seat;

                        // Display the price
                        const price = seat.getAttribute('data-price');
                        seatPrice.textContent = `Price: RM ${price}`;

                        // Show the price container
                        priceContainer.style.display = 'block';

                        // Enable the Next button and adjust layout
                        nextBtn.disabled = false;
                        nextBtn.classList.add('next-btn-enabled');
                    });
                });

                // Next Button functionality
                nextBtn.addEventListener('click', () => {
                    // if (selectedSeat) {
                    //     alert(`You selected seat: ${selectedSeat.getAttribute('data-seat')} with a price of RM ${selectedSeat.getAttribute('data-price')}`);
                    //     // You can replace this with form submission or navigation logic
                    // }
                });
            </script> --}}

