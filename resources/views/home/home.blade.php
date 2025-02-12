<x-app-layout>
        <section class="relative bg-center bg-cover bg-no-repeat h-screen" style="background-image: url('{{ asset('images/homeBlade.jpg') }}');">
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/30"></div>
            <div class="relative px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
                <h1 class="mb-6 text-5xl font-extrabold tracking-tight leading-tight text-white sm:text-6xl lg:text-7xl">
                    Travel Comfortably from City to City
                </h1>
                <p class="mb-8 text-lg text-gray-300 font-medium lg:text-xl">
                    Choose your destination, driver, and price for the perfect journey.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('offers.test') }}" class="inline-flex items-center px-8 py-4 text-lg font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition shadow-lg">
                        Get Started
                        <svg class="w-5 h-5 ml-2 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
        <section class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <div class="py-20 max-w-6xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold mb-6">How It Works</h2>
            <p class="text-lg mb-10">Simple steps to get your perfect ride.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg transform hover:scale-105 transition">
                    <span class="block text-5xl font-bold text-blue-600 mb-3">1</span>
                    <h3 class="text-2xl font-semibold mb-2">Choose Your Destination</h3>
                    <p class="text-gray-600 dark:text-gray-400">Enter your pick-up and drop-off locations.</p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg transform hover:scale-105 transition">
                    <span class="block text-5xl font-bold text-blue-600 mb-3">2</span>
                    <h3 class="text-2xl font-semibold mb-2">Pick a Driver</h3>
                    <p class="text-gray-600 dark:text-gray-400">Browse drivers and select the best fit for you.</p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg transform hover:scale-105 transition">
                    <span class="block text-5xl font-bold text-blue-600 mb-3">3</span>
                    <h3 class="text-2xl font-semibold mb-2">Enjoy the Ride</h3>
                    <p class="text-gray-600 dark:text-gray-400">Sit back, relax, and enjoy your trip!</p>
                </div>
            </div>
        </div>
        <div class="py-20 max-w-6xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold mb-6 text-gray-900 dark:text-white">What Our Riders Say</h2>
            <p class="text-lg mb-10 text-gray-600 dark:text-gray-300">Hear from happy customers who have used our service.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition">
                    <p class="text-lg font-semibold">"The best travel experience I've had! Highly recommend."</p>
                    <p class="text-gray-500 mt-2">- Alex</p>
                </div>

                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition">
                    <p class="text-lg font-semibold">"Easy to use, great drivers, and safe rides. Love it!"</p>
                    <p class="text-gray-500 mt-2">- Sarah</p>
                </div>

                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition">
                    <p class="text-lg font-semibold">"Affordable prices and comfortable trips. Would use again!"</p>
                    <p class="text-gray-500 mt-2">- Michael</p>
                </div>
            </div>
        </div>

        <div class="py-16 bg-blue-600 text-white text-center">
            <h2 class="text-5xl font-extrabold mb-4">Ready to Ride?</h2>
            <p class="text-lg mb-6">Book your trip now and travel with comfort.</p>
            <a href="{{ route('offers.test') }}" 
            class="inline-block px-8 py-4 text-lg font-bold bg-white text-blue-700 rounded-lg shadow-lg hover:bg-gray-100 transition">
                Start Your Journey
            </a>
        </div>
    </section>
</x-app-layout>