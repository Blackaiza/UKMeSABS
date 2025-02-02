<x-app-layout>
    <!-- Header Section -->
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold text-black dark:text-white mt-4">
            List of Registered Users
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">

        <!-- Staff List -->
        <div class="bh-white rounded-xl p-6 shadow-lg">
            <h3 class="text-2xl text-dark mb-6 font-semibold">
                List of Registered Users
            </h3>

            @if($staffMembers->count() > 0)
                <table class="w-full text-sm text-center text-gray-400">
                    <thead class="text-xs uppercase bg-purple-700 text-gray-300">
                        <tr>
                            <th scope="col" class="py-3 px-6">ID</th>
                            <th scope="col" class="py-3 px-6">Name</th>
                            <th scope="col" class="py-3 px-6">Email</th>
                            <th scope="col" class="py-3 px-6">Role</th>
                            {{-- <th scope="col" class="py-3 px-6">Account Created</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffMembers as $staff)
                            <tr
                                class="border-b border-gray-600 hover:bg-gray-600 transition
                                {{ $staff->role === 'staff' ? 'bg-blue-800' : 'odd:bg-gray-900 even:bg-gray-800' }}">
                                <td class="py-4 px-6">{{ $staff->id }}</td>
                                <td class="py-4 px-6">{{ $staff->name }}</td>
                                <td class="py-4 px-6">{{ $staff->email }}</td>
                                <td class="py-4 px-6">{{ ucfirst($staff->role) }}</td>
                                {{-- <td class="py-4 px-6">{{ $staff->created_at->format('M d, Y') }}</td> --}}

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $staffMembers->links('pagination::tailwind') }}
                </div>
            @else
                <p class="text-center text-gray-300 mt-6">No staff members found. Add some staff!</p>
            @endif
        </div>
    </div>
</x-app-layout>
