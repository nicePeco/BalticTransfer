<x-guest-layout>
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6">
        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
            {{ __('Back') }}
        </a>
    </div>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="text-center">
            <h1 class="text-7xl font-extrabold text-gray-800 dark:text-gray-200">404</h1>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-4">{{ __('Page Not Found') }}</h2>
            
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                The page you are looking for does not exist or has been moved.
            </p>

            <div class="mt-6">
                <a href="{{ url('/') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-md text-lg font-semibold hover:bg-indigo-700 transition">
                    {{ __('Go Home') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
