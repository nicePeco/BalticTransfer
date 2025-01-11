<x-app-layout>
    <div class="py-10">
        <section class="relative bg-center bg-cover bg-no-repeat h-screen" style="background-image: url('https://www.company-registration-latvia.lv/wp-content/uploads/2021/06/vita-notturna-Riga-Latvia-n-1024x614-1-1.jpg');">
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
        <div class="flex flex-wrap justify-center gap-8 py-16 px-6 bg-gray-100 dark:bg-gray-800">
            <figure class="relative group max-w-sm transition-all duration-300">
                <img class="rounded-lg shadow-xl w-[350px] h-[250px] object-cover group-hover:scale-105 transform transition-transform duration-500" src="https://c.files.bbci.co.uk/E0C6/production/_103724575_prius-64-plate-006_toyota.jpg" alt="Pick a ride">
                <figcaption class="absolute bottom-4 left-4 bg-black bg-opacity-75 px-6 py-3 text-lg text-white rounded-lg shadow-md">
                    Pick a Ride
                </figcaption>
            </figure>
            <figure class="relative group max-w-sm transition-all duration-300">
                <img class="rounded-lg shadow-xl w-[350px] h-[250px] object-cover group-hover:scale-105 transform transition-transform duration-500" src="https://hips.hearstapps.com/hmg-prod/images/2024-hyundai-elantra-limited-106-64ef85e2044f5.jpg?crop=0.661xw:0.496xh;0.197xw,0.381xh&resize=1200:*" alt="Pick a driver">
                <figcaption class="absolute bottom-4 left-4 bg-black bg-opacity-75 px-6 py-3 text-lg text-white rounded-lg shadow-md">
                    Pick a Driver
                </figcaption>
            </figure>
            <figure class="relative group max-w-sm transition-all duration-300">
                <img class="rounded-lg shadow-xl w-[350px] h-[250px] object-cover group-hover:scale-105 transform transition-transform duration-500" src="https://hips.hearstapps.com/hmg-prod/images/2025-volkswagen-jetta-107-6679be9c4f143.jpg?crop=0.821xw:0.615xh;0.0897xw,0.272xh&resize=1200:*" alt="Pick the price">
                <figcaption class="absolute bottom-4 left-4 bg-black bg-opacity-75 px-6 py-3 text-lg text-white rounded-lg shadow-md">
                    Pick the Price
                </figcaption>
            </figure>
        </div>
        <div class="text-center py-20 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 text-white">
            <h1 class="text-6xl font-extrabold leading-tight mb-4 animate-pulse">
                And Enjoy Your Journey!
            </h1>
            <p class="text-lg font-medium mb-6">
                Experience the comfort, safety, and ease of traveling with us.
            </p>
            <!-- <div>
                <a href="{{ route('offers.index') }}" class="inline-block px-8 py-4 text-lg font-bold text-blue-700 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition">
                    Start Your Ride
                </a>
            </div> -->
            <div>
                <a href="{{ route('offers.test') }}" class="inline-block px-8 py-4 text-lg font-bold text-blue-700 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition">
                    Start Your Ride
                </a>
            </div>
        </div>
    </div>
</x-app-layout>