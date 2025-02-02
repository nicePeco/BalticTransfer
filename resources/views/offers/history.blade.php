<x-app-layout>
    <div class="container mx-auto py-12 px-6">
        <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-10 tracking-wide">
            🚗 Ride History
        </h1>

        @forelse ($completedOffers as $offer)
            <div class="bg-white shadow-lg rounded-xl overflow-hidden transition-transform hover:scale-[1.02] hover:shadow-xl duration-300 mb-8 w-full max-w-4xl mx-auto">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-5 flex flex-wrap items-center justify-between gap-3">
                    <h2 class="text-2xl font-semibold text-white break-words leading-tight w-full sm:w-auto">
                        {{ $offer->location_one }} ➝ {{ $offer->city_one }}
                    </h2>
                    <span class="text-base text-white bg-black bg-opacity-30 px-4 py-2 rounded-lg font-medium">
                        {{ $offer->updated_at->format('F j, Y H:i') }}
                    </span>
                </div>
                <div class="p-8 space-y-5 text-gray-700 text-lg">
                    <p class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-semibold">Status:</span> 
                        <span class="text-green-600 font-bold">Completed</span>
                    </p>
                    
                    @if ($offer->rides->isNotEmpty())
                        <p class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.866 0-7 3.134-7 7h14c0-3.866-3.134-7-7-7z"></path>
                            </svg>
                            <span class="font-semibold">Price:</span> 
                            <span class="text-blue-600 font-bold text-xl">€{{ number_format($offer->rides->first()->price, 2) }}</span>
                        </p>
                    @endif
                </div>
                <div class="px-8 py-5 flex gap-4">
                    @if (Auth::id() === $offer->offers_id && !$offer->user_rated_driver)
                        <a href="{{ route('offers.rate', ['hashid' => $offer->hashed_id]) }}" 
                           class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow-md font-bold text-lg transition-all">
                            ⭐ Rate Driver
                        </a>
                    @endif
                    @if (Auth::user()->driver && Auth::user()->driver->id === $offer->accepted_driver_id && !$offer->driver_rated_user)
                        <a href="{{ route('offers.rateUser', ['hashid' => $offer->hashed_id]) }}" 
                           class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg shadow-md font-bold text-lg transition-all">
                            👍 Rate User
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white shadow-lg rounded-xl p-10 text-center max-w-xl mx-auto">
                <h2 class="text-3xl font-semibold text-gray-700">No Completed Rides Yet</h2>
                <p class="text-gray-500 mt-3 text-lg">Once you complete a ride, it will appear here.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
