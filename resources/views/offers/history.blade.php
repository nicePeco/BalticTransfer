<x-app-layout>
    <div class="container mx-auto py-12 px-6">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Ride History</h1>

        @forelse ($completedOffers as $offer)
            <div class="bg-white shadow-lg rounded-lg mb-6 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 px-6 py-4">
                    <h2 class="text-2xl font-semibold text-white">
                        Ride from {{ $offer->location_one }} to {{ $offer->city_one }}
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-gray-600">
                        <span class="font-semibold">Completed on:</span> 
                        {{ $offer->updated_at->format('F j, Y H:i') }}
                    </p>
                    <p class="text-gray-600">
                        <span class="font-semibold">Status:</span> 
                        <span class="text-green-500 font-bold">Completed</span>
                    </p>
                    @if ($offer->rides->isNotEmpty())
                        <p class="text-gray-600">
                            <span class="font-semibold">Price:</span> 
                            €{{ number_format($offer->rides->first()->price, 2) }}
                        </p>
                    @endif
                </div>
                @if (Auth::id() === $offer->offers_id && !$offer->user_rated_driver)
                    <a href="{{ route('offers.rate', ['hashid' => $offer->hashed_id]) }}" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg font-bold text-sm transition-all">
                        Rate Driver
                    </a>
                @endif
                @if (Auth::user()->driver && Auth::user()->driver->id === $offer->accepted_driver_id && !$offer->driver_rated_user)
                    <a href="{{ route('offers.rateUser', ['hashid' => $offer->hashed_id]) }}" 
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg font-bold text-sm transition-all">
                        Rate User
                    </a>
                @endif
            </div>
        @empty
            <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                <p class="text-xl font-semibold text-gray-600">No completed rides yet.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
