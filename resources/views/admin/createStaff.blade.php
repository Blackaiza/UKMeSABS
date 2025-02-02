<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<x-app-layout>
    <!-- Header Section -->
    <x-slot name="header">
        <!-- Flex container to align the back button and header -->
        <div class="flex justify-between items-center">
            <!-- Back Button -->
            <button type="button" onclick="window.history.back();" class="flex items-center bg-purple-600 text-white text-sm font-semibold py-2 px-4 rounded-md shadow-md transition-all hover:bg-purple-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 transform transition-transform hover:translate-x-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7M5 12h13"></path>
                </svg>
                Back
            </button>
            
            <!-- Header Title -->
            <h2 class="text-center text-3xl font-bold text-black dark:text-white mt-4">
                ADD NEW ACCOUNT
            </h2>

            <!-- Placeholder for alignment -->
            <div class="w-16"></div>
        </div>
    </x-slot>

    <!-- Main Content Section -->
    <div class="max-w-2xl mx-auto mt-8 bg-gray-300 p-4 rounded-lg shadow-md">
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf

            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter name"
                    required>
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter email"
                    required>
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter password"
                    required
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                    title="Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.">
            </div>

            <!-- Confirmation Password Field -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Re-enter password"
                    required>
            </div>

            <!-- Role Field -->
            <div class="mb-4">
                <label for="role" class="block text-gray-700 font-bold mb-2">Role:</label>
                <select
                    id="role"
                    name="role"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-3 bg-purple-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Submit
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
