<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-500 to-blue-700 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-3xl w-full bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 text-center">
                🚗 Welcome to Our Driver Network!
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-center mt-3">
                Thank you for signing up as a driver! Before we can approve your account, 
                please complete the verification steps below.
            </p>
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                    <svg class="w-6 h-6 text-blue-500 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Steps to Complete Verification:
                </h3>
                <ul class="mt-2 space-y-3 text-gray-700 dark:text-gray-300">
                    <li class="flex items-center">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-md mr-3">1</span>
                        Upload your <strong>Driver's License</strong> → 
                        <a href="{{ route('driver.verify') }}" class="text-blue-500 hover:underline ml-1">Click Here</a>
                    </li>
                    <li class="flex items-center">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-md mr-3">2</span>
                        Upload <strong>Photos of Your Car</strong> & License Plate → 
                        <a href="{{ route('driver.edit') }}" class="text-blue-500 hover:underline ml-1">Click Here</a>
                    </li>
                </ul>
            </div>
            <p class="mt-6 text-gray-600 dark:text-gray-400 text-center">
                ✅ Once you've submitted the required documents, just sit back and relax!  
                Our team will review your details and notify you when verification is complete.
            </p>
            <p class="mt-4 text-gray-600 dark:text-gray-400 text-center">
                Thank you for choosing us! If you have any questions, feel free to contact our support.
            </p>
            <div class="mt-6 flex justify-center space-x-4">
                <a href="{{ route('profile.edit') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-blue-700">
                    {{ __('Edit Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-5 py-2 rounded-lg shadow-md hover:bg-red-600">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
