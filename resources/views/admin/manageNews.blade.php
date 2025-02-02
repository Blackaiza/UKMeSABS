<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-3xl font-bold text-gray-100 mt-4">
            ADD NEW NEWS
        </h2>
    </x-slot>

        <!-- Include SweetAlert Script -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Display Success Message -->
        @if(session('NewsCreate'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Create News Successful !!',
                    text: 'We already recorded your news!!',
                    confirmButtonText: 'OK'
                });
            });
        </script>
        @endif

    <!-- Display update Message -->
        @if(session('NewsUpdate'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'News updated successfully!',
                        text: 'News recorded!!',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

        <!-- Display delete Message -->
        @if(session('NewsDelete'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'News Deleted',
                    text: '',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Create News Button -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.createNews') }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Create News
            </a>
        </div>

        <!-- News Table -->
        <div class="overflow-hidden rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-700 bg-gray-800 text-gray-200">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($news as $item)
                        <tr class="hover:bg-gray-700">
                            <td class="px-6 py-4">
                                {{ $item->title }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->date }}
                            </td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('admin.editNews', $item->id) }}"
                                   class="px-3 py-1 text-sm font-medium bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                    Edit
                                </a>
                                <form action="{{ route('admin.destroyNews', $item->id) }}" method="POST" style="display:inline;" class="delete-news-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="px-3 py-1 text-sm font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 delete-news-btn">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-news-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Confirm Delete?',
                        text: 'Are you sure you want to delete this news item?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        } else {
                            Swal.fire('Cancelled', 'The news item was not deleted.', 'info');
                        }
                    });
                });
            });
        });
    </script>

</x-app-layout>
