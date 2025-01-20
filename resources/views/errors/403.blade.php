<x-guest-layout>
    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6">
        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
            {{ __('Back') }}
        </a>
    </div>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-6">{{ __('Your Account is Suspended') }}</h2>

            @if (session('suspension_type') === 'forever')
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                    Your account is permanently suspended. Please contact us via email for further assistance.
                </p>
            @else
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                    Your account is suspended until <strong>{{ session('suspended_until') }}</strong>.
                    Please contact us via email for further assistance.
                </p>
            @endif

            <p class="mt-2 text-gray-600 dark:text-gray-400">Email us at: <strong>info@baltictransfer.com</strong></p>
        </div>
    </div>
</x-guest-layout>
