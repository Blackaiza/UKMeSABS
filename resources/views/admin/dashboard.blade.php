<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- News Section -->
            <div class="mt-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Event News</h3>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($news as $item) <!-- Loop through news data -->
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4">
                        <!-- Display picture -->
                        <img src="{{ $item->picture ? Storage::url($item->picture) : asset('images/placeholder.png') }}" alt="{{ $item->title }}" class="rounded-md w-full h-40 object-cover mb-4">
                        
                        <!-- Title -->
                        <h4 class="text-lg font-semibold">{{ $item->title }}</h4>

                        <!-- Description -->
                        <p class="text-sm text-gray-400 mt-2">{{ $item->description }}</p>

                        <!-- Date -->
                        <p class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($item->date)->format('F j, Y') }}</p>

                        <!-- Display created_at and updated_at timestamps -->
                        <!-- <div class="mt-4 text-xs text-gray-500">
                            <p>Created At: {{ \Carbon\Carbon::parse($item->created_at)->format('F j, Y, g:i A') }}</p>
                            <p>Updated At: {{ \Carbon\Carbon::parse($item->updated_at)->format('F j, Y, g:i A') }}</p>
                        </div> -->
                    </div>
                @endforeach
            </div>
        </div>


            <!-- Achievements Section -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Achievements of UKM E-Sport Team</h3>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4">
                        <img src="{{ asset('images/DashboardSlider/5.png') }}" alt="Achievement 1" class="rounded-md w-full h-40 object-cover mb-4">
                        <h4 class="text-lg font-semibold">MLBB Ladies</h4>
                        <p class="text-sm text-gray-400 mt-2">Our team won in the MLBB Ladies tournament.</p>
                    </div>
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4">
                        <img src="{{ asset('images/DashboardSlider/8.png') }}" alt="Achievement 2" class="rounded-md w-full h-40 object-cover mb-4">
                        <h4 class="text-lg font-semibold">Best Team Award</h4>
                        <p class="text-sm text-gray-400 mt-2">Our captain won the Best Player Award for exceptional performance.</p>
                    </div>
                </div>
            </div>

            <!-- Authority Section -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Position of Authority</h3>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4 text-center">
                        <img src="{{ asset('images/JawatanKuasa/ydp.jpg') }}" alt="Authority 1" class="rounded-full w-32 h-32 mx-auto object-cover mb-4">
                        <h4 class="text-lg font-semibold">Aiman</h4>
                        <p class="text-sm text-gray-400">Yang Dipertua</p>
                    </div>
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4 text-center">
                        <img src="{{ asset('images/JawatanKuasa/nydp1.jpg') }}" alt="Authority 2" class="rounded-full w-32 h-32 mx-auto object-cover mb-4">
                        <h4 class="text-lg font-semibold">Firdaus</h4>
                        <p class="text-sm text-gray-400">Naib Dipertuan I</p>
                    </div>
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4 text-center">
                        <img src="{{ asset('images/JawatanKuasa/nydp2.jpg') }}" alt="Authority 3" class="rounded-full w-32 h-32 mx-auto object-cover mb-4">
                        <h4 class="text-lg font-semibold">Mustaqim</h4>
                        <p class="text-sm text-gray-400">Naib Dipertua II</p>
                    </div>
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4 text-center">
                        <img src="{{ asset('images/JawatanKuasa/nydp3.jpg') }}" alt="Authority 3" class="rounded-full w-32 h-32 mx-auto object-cover mb-4">
                        <h4 class="text-lg font-semibold">Hafiza</h4>
                        <p class="text-sm text-gray-400">Naib Dipertua III</p>
                    </div>
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4 text-center">
                        <img src="{{ asset('images/JawatanKuasa/su.jpg') }}" alt="Authority 3" class="rounded-full w-32 h-32 mx-auto object-cover mb-4">
                        <h4 class="text-lg font-semibold">Ailiana</h4>
                        <p class="text-sm text-gray-400">Setiausaha</p>
                    </div>
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4 text-center">
                        <img src="{{ asset('images/JawatanKuasa/tsu.jpg') }}" alt="Authority 3" class="rounded-full w-32 h-32 mx-auto object-cover mb-4">
                        <h4 class="text-lg font-semibold">Meisarah</h4>
                        <p class="text-sm text-gray-400">Timbalan Setiausaha</p>
                    </div>
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4 text-center">
                        <img src="{{ asset('images/JawatanKuasa/bend.jpg') }}" alt="Authority 3" class="rounded-full w-32 h-32 mx-auto object-cover mb-4">
                        <h4 class="text-lg font-semibold">Khairina</h4>
                        <p class="text-sm text-gray-400">Bendahari</p>
                    </div>
                    <div class="bg-gray-800 text-white rounded-lg shadow-md p-4 text-center">
                        <img src="{{ asset('images/JawatanKuasa/tbend.jpg') }}" alt="Authority 3" class="rounded-full w-32 h-32 mx-auto object-cover mb-4">
                        <h4 class="text-lg font-semibold">Syafiqah</h4>
                        <p class="text-sm text-gray-400">Timbalan Bendahari</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>