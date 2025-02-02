<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<x-app-layout>
    <!-- Header Section -->
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold dark:text-white text-gray-900 mt-4">
            CHOOSE ACCOUNT TO MANAGE
        </h2>
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

        @if (session('staffUpdateSuccess'))
            <div class="mb-4">
                <p class="bg-green-100 text-green-700 p-3 rounded-lg">{{ session('staffUpdateSuccess') }}</p>
            </div>
        @endif

        <!-- Filter and Add New Staff Button -->
        <div class="mb-6 flex justify-between items-center">
            <form method="GET" action="{{ route('admin.managestaff') }}" class="flex items-center space-x-4">
                <select
                    name="role"
                    id="role"
                    class="border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    onchange="this.form.submit()">
                    <option value="" {{ $roleFilter === null ? 'selected' : '' }}>All Roles</option>
                    <option value="admin" {{ $roleFilter === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $roleFilter === 'user' ? 'selected' : '' }}>User</option>
                </select>
            </form>

            <a href="{{ route('admin.staff.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                Add New Account
            </a>
        </div>

        <!-- Staff Table -->
        <div class="bg-gray-800 dark:bg-gray-800 rounded-xl p-6 shadow-lg">
            <h3 class="text-xl text-gray-300 mb-6 font-semibold">
                List of Registered Account
            </h3>

            @if ($staffMembers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-700 text-gray-300 rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-600">
                                <th class="px-4 py-2 text-left">#</th>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Email</th>
                                <th class="px-4 py-2 text-left">Role</th>
                                <th class="px-4 py-2 text-left">Joined On</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffMembers as $key => $staff)
                                <tr class="border-b border-gray-600">
                                    <td class="px-4 py-2">{{ $key + 1 + ($staffMembers->currentPage() - 1) * 10 }}</td>
                                    <td class="px-4 py-2">{{ $staff->name }}</td>
                                    <td class="px-4 py-2">{{ $staff->email }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($staff->role ?? 'N/A') }}</td>
                                    <td class="px-4 py-2">{{ $staff->created_at ? $staff->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('admin.staff.edit', $staff->id) }}"
                                           class="mx-4 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg shadow-md transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow-md transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $staffMembers->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            @else
                <p class="text-center text-gray-300 mt-6">No members found!!</p>
            @endif
        </div>
    </div>
</x-app-layout>
