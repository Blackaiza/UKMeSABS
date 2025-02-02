<x-app-layout>
    <head>
        <!-- Add Flatpickr CSS -->
        <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
        <!-- Add Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <style>
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
                grid-template-columns: repeat(3, 1fr);  /* 3 columns for 3 seats */
                gap: 16px;
                margin-top: 2rem;
                justify-items: center;  /* Center the items within the grid */
            }

            .seat-box {
                width: 100px;
                height: 100px;
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
    </head>

    <body class="bg-gradient">
        <div class="form-container">
            <!-- Header Section -->
            <div class="header">
                <h2>Gaming PC - Selected Date: {{ $datetime }}</h2>
                <p>Select your preferred gaming seat and click "Next".</p>
            </div>

            <!-- Seat Grid -->
            <div class="seat-grid">
                <!-- Seat Boxes -->
                <div class="seat-box" data-seat="a1" data-price="20">A1</div>
                <div class="seat-box" data-seat="a2" data-price="20">A2</div>
                <div class="seat-box" data-seat="a3" data-price="20">A3</div>
            </div>

            <!-- Price Display -->
            <div class="price-container">
                <p id="seat-price">Price: RM 0.00</p>
            </div>

            <!-- Next Button -->
            <button type="button" 
                    id="next-btn" 
                    class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 text-lg rounded-full shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed" 
                    style="margin-top: 30px;" 
                    disabled>Next</button>

        </div>

        <!-- JavaScript -->
        <script>
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
                if (selectedSeat) {
                    alert(`You selected seat: ${selectedSeat.getAttribute('data-seat')} with a price of RM ${selectedSeat.getAttribute('data-price')}`);
                    // You can replace this with form submission or navigation logic
                }
            });
        </script>
    </body>
</x-app-layout>
