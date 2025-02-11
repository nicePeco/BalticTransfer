<x-guest-layout>
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6">
        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
            {{ __('Back') }}
        </a>
    </div>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-2xl shadow-md rounded-lg p-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center mb-6">{{ __('Terms of Service') }}</h2>

            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-6">1. Introduction</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                Welcome to <strong>Baltsfer</strong>. By using our services, you agree to these Terms of Service. Please read them carefully.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-6">2. Use of Our Services</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                You must use our services in compliance with all applicable laws and not for any unlawful or prohibited activity.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-6">3. User Responsibilities</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                Users are responsible for maintaining the confidentiality of their account information and agree not to share their access credentials with others.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-6">4. Limitation of Liability</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                We do not guarantee that our services will always be available, uninterrupted, or error-free. We are not liable for any losses resulting from your use of our services.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-6">5. Modifications</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                We reserve the right to update or modify these Terms at any time. Any changes will be posted on this page.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-6">6. Contact Us</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                If you have any questions about these Terms, please contact us at <strong>info@baltsfer.com</strong>.
            </p>
        </div>
    </div>
</x-guest-layout>
