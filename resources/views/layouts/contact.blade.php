<x-guest-layout>
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6">
        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
            {{ __('Back') }}
        </a>
    </div>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-2xl shadow-md rounded-lg p-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center mb-6">{{ __('About Us') }}</h2>

            <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed">
                Welcome to <strong>Baltic Transfer</strong>, your trusted partner in seamless and reliable transportation services. 
                We specialize in providing efficient and secure transfers across various destinations, ensuring comfort and 
                peace of mind for our valued clients.
            </p>

            <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed mt-4">
                With a dedicated team, modern vehicles, and a commitment to customer satisfaction, Baltic Transfer stands out as a leader in the 
                industry. Thank you for choosing us – we look forward to serving you!
            </p>

            <div class="text-center mt-6">
                <p class="text-gray-600 dark:text-gray-400">{{ __('For inquiries, reach us at:') }} <strong>info@baltsfer.com</strong></p>
            </div>
        </div>
    </div>
</x-guest-layout>