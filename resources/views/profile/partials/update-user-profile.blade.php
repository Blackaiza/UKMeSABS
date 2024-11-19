<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('A Happy user ensure got happy face.') }}
        </p>
    </header>

    {{-- <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put') --}}

        {{-- <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update Picture') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Done Update.') }}</p>
            @endif
        </div>   --}}
    {{-- </form> --}}
</section>
