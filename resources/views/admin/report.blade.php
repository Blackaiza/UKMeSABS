<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Header Section -->
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold text-white mt-4">
            REPORT
        </h2>
    </x-slot>

    <!-- Charts Section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top Row: Total Users Registered, Total Revenue, Most Popular Facility -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Total Users Registered -->
                <div class="bg-white p-8 rounded-lg shadow-lg text-center border-2 border-gray-100 hover:border-blue-500 transition transform hover:scale-105 hover:shadow-lg flex items-center justify-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-700 mb-4 tracking-wide">Total Users Registered</h2>
                        <h1 class="text-7xl font-bold text-blue-600 tracking-wide">{{ $totalUsers }}</h1>
                    </div>
                </div>

                <!-- Total Revenue Card with Month and Year Filters -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center border-2 border-gray-100 hover:border-blue-500 transition transform hover:scale-105 hover:shadow-lg flex flex-col items-center justify-between">
                    <div>
                        <h2 class="text-lg font-medium text-gray-700 mb-2 tracking-wide">Revenue by Month</h2>
                        
                        <h1 class="text-4xl font-bold text-black-600 tracking-wide">
                            RM {{ number_format($totalRevenue, 2) }}
                        </h1>
                    </div>

                    <!-- Month and Year Filters-->
                    <div class="mt-4">
                        <form method="GET" action="{{ route('admin.report') }}" class="flex justify-center space-x-4">
                            <!-- Month Dropdown -->
                            <select name="month" class="px-4 py-2 bg-blue-500 text-white rounded-lg">
                                <option value="1" {{ $selectedMonth == 1 ? 'selected' : '' }}>January</option>
                                <option value="2" {{ $selectedMonth == 2 ? 'selected' : '' }}>February</option>
                                <option value="3" {{ $selectedMonth == 3 ? 'selected' : '' }}>March</option>
                                <option value="4" {{ $selectedMonth == 4 ? 'selected' : '' }}>April</option>
                                <option value="5" {{ $selectedMonth == 5 ? 'selected' : '' }}>May</option>
                                <option value="6" {{ $selectedMonth == 6 ? 'selected' : '' }}>June</option>
                                <option value="7" {{ $selectedMonth == 7 ? 'selected' : '' }}>July</option>
                                <option value="8" {{ $selectedMonth == 8 ? 'selected' : '' }}>August</option>
                                <option value="9" {{ $selectedMonth == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $selectedMonth == 10 ? 'selected' : '' }}>October</option>
                                <option value="11" {{ $selectedMonth == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $selectedMonth == 12 ? 'selected' : '' }}>December</option>
                            </select>
                            
                            <!-- Year Dropdown -->
                            <select name="year" class="px-4 py-2 bg-blue-500 text-white rounded-lg">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Filter</button>
                        </form>
                    </div>
                </div>

                <!-- Most Popular Facility -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center border-2 border-gray-100 hover:border-blue-500 transition transform hover:scale-105 hover:shadow-lg flex flex-col items-center justify-between">
                    <div>
                        <h2 class="text-lg font-medium text-gray-700 mb-2 tracking-wide">Most Popular Facility by Month</h2>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-600 tracking-wide">
                            @if(count($facilities) > 0)
                                {{ $facilities->sortByDesc('carts_count')->first()->name }}
                            @else
                                N/A
                            @endif
                        </h1>
                        <p class="text-lg text-gray-500 mt-4">
                            @if($mostPopularFacility)
                                Revenue: RM {{ number_format($mostPopularFacilityRevenue, 2) }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Revenue (Overall) Card -->
            <div class="mt-3 bg-white p-6 rounded-lg shadow-lg text-center border-2 border-gray-100 hover:border-blue-500 transition transform hover:scale-105 hover:shadow-lg">
                <h2 class="text-lg font-medium text-gray-700 mb-2">Total Revenue (Overall)</h2>
                <h1 class="text-4xl font-bold text-green-600 tracking-wide">
                    RM {{ number_format($overallTotalRevenue, 2) }}
                </h1>
            </div>

            <!-- Second Row: User Registration Breakdown and Booked Facility -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <!-- User Registration Breakdown (30%) -->
                <div class="col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border-2 border-gray-100 hover:border-blue-500 transition transform hover:scale-105 hover:shadow-lg">
                    <div class="p-6 text-white dark:text-white">
                        <h5 class="text-center text-xl font-semibold text-white">User Registration Breakdown</h5>
                        <canvas id="fourthChart" class="mt-4" style="max-height: 400px;"></canvas>
                    </div>
                </div>

                <!-- Most Booked Facilities (70%) -->
                <div class="col-span-2 bg-white dark:bg-white overflow-hidden shadow-lg rounded-lg border-2 border-gray-100 hover:border-blue-500 transition transform hover:scale-105 hover:shadow-lg">
                    <div class="p-6 text-white dark:text-gray-100">
                        <h5 class="text-center text-xl font-semibold text-white">Booked Facilities by Month</h5>
                        <canvas id="lineChart" class="mt-4" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Third Row: Booking Time Distribution -->
            <div class="grid grid-cols-1 gap-4 mt-4">
                <div class="bg-white dark:bg-white overflow-hidden shadow-lg rounded-lg border-2 border-gray-100 hover:border-blue-500 transition transform hover:scale-105 hover:shadow-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h5 class="text-center text-xl font-semibold text-white">Booking Time Distribution by Month</h5>
                        <canvas id="bookingTimeChart" class="mt-4" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Booked Facility Chart
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($linelabels) !!},
                datasets: [{
                    label: 'Number Of Booking',  // This changes the label at the top
                    data: {!! json_encode($linedata) !!},
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.3)',
                    tension: 0.4
                }]
            }
        });

        // Booking Time Distribution (with colorful bars)
        const ctxThird = document.getElementById('bookingTimeChart').getContext('2d');
        new Chart(ctxThird, {
            type: 'bar',
            data: {
                labels: {!! json_encode($timeLabels) !!},
                datasets: [{
                    label: 'Booking Time',  // This changes the label at the top
                    data: {!! json_encode($bookingCounts) !!},
                    backgroundColor: 'rgba(54, 162, 235, 1)'
                }]
            }
        });

        // User Registration Breakdown
        const ctxFourth = document.getElementById('fourthChart').getContext('2d');
        new Chart(ctxFourth, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($fourthLabels) !!},
                datasets: [{
                    data: {!! json_encode($fourthData) !!},
                    backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' // Set label color to white
                        }
                    }
                }
            }
        });

    });
    </script>
</x-app-layout>
