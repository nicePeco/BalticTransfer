<x-guest-layout>
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6">
        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
            {{ __('Back') }}
        </a>
    </div>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-2xl shadow-md rounded-lg p-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center mb-6">{{ __('Privacy Policy') }}</h2>

            <p class="text-lg text-gray-600 dark:text-gray-400">
                At <strong>Baltsfer</strong>, we respect your privacy and are committed to protecting your personal data. This Privacy Policy explains how we collect, use, and safeguard your information.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-6">Information We Collect</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                We may collect personal information such as your name, email, phone number, and any details you provide when using our services.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-6">How We Use Your Information</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                We use your data to provide, improve, and personalize our services. We do not sell or share your personal information with third parties.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-6">Your Rights</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                You have the right to access, update, or request the deletion of your data. For any concerns, contact us at <strong>info@baltsfer.com</strong>.
            </p>

            <p class="text-lg text-gray-600 dark:text-gray-400 mt-6">
                This Privacy Policy is subject to updates. Please review it periodically for any changes.
            </p>
        </div>
    </div>
</x-guest-layout>
