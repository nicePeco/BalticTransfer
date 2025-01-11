<x-app-layout>
    <body>
        <div class="bg-cover bg-center min-h-screen" style="background-image: url('https://www.tallinn.ee/themes/main_site/public/images/old_town_kaupo_kalda_2018_5_optimized.jpg');">
            <form method="post" action="{{ route('offers.update', $offers) }}">
                @csrf
                @method('patch')
                <section class="max-w-4xl mx-auto py-12 px-6 bg-gray-100 bg-opacity-90 dark:bg-gray-900 dark:bg-opacity-90 rounded-lg shadow-lg backdrop-filter backdrop-blur-lg">
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Ride Details</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Update the information for your ride offer below.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col">
                            <label for="location_one" class="text-sky-500 font-medium">From Country</label>
                            <input 
                                id="location_one" 
                                name="location_one" 
                                value="{{ $offers->location_one }}" 
                                class="mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-sky-200 dark:focus:ring-sky-600 focus:outline-none text-gray-800 dark:text-gray-100 dark:bg-gray-800">
                        </div>

                        <div class="flex flex-col">
                            <label for="city_one" class="text-sky-500 font-medium">From City, Address</label>
                            <input 
                                id="city_one" 
                                name="city_one" 
                                value="{{ $offers->city_one }}" 
                                class="mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-sky-200 dark:focus:ring-sky-600 focus:outline-none text-gray-800 dark:text-gray-100 dark:bg-gray-800">
                        </div>

                        <div class="flex flex-col">
                            <label for="location_two" class="text-cyan-500 font-medium">To Country</label>
                            <input 
                                id="location_two" 
                                name="location_two" 
                                value="{{ $offers->location_two }}" 
                                class="mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-cyan-200 dark:focus:ring-cyan-600 focus:outline-none text-gray-800 dark:text-gray-100 dark:bg-gray-800">
                        </div>

                        <div class="flex flex-col">
                            <label for="city_two" class="text-cyan-500 font-medium">To City, Address</label>
                            <input 
                                id="city_two" 
                                name="city_two" 
                                value="{{ $offers->city_two }}" 
                                class="mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-cyan-200 dark:focus:ring-cyan-600 focus:outline-none text-gray-800 dark:text-gray-100 dark:bg-gray-800">
                        </div>

                        <div class="flex flex-col col-span-full">
                            <label for="information" class="text-yellow-500 font-medium">Information</label>
                            <textarea id="information" name="information" class="mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-200 dark:focus:ring-yellow-600 focus:outline-none text-gray-800 dark:text-gray-100 dark:bg-gray-800 h-28">{{ $offers->information }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 space-x-4">
                        <a href="{{ route('offers.show', $offers) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md">
                            @lang('Cancel')
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md">
                            @lang('Save')
                        </button>
                    </div>
                </section>
            </form>
        </div>
    </body>
</x-app-layout>