<x-app-layout>
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Rides</h1>
        <div class="max-w-lg mx-auto mb-8">
            <form method="GET" action="{{ route('client.profile.search') }}" class="flex flex-col space-y-3 md:flex-row md:space-y-0 md:space-x-3">
                <div class="relative w-full">
                    <input type="text" name="from" placeholder="From (Pick-up Point)" 
                        class="w-full p-4 pl-4 text-lg border rounded-lg shadow-md focus:ring focus:ring-blue-300"
                        value="{{ request('from') }}">
                </div>
                <div class="relative w-full">
                    <input type="text" name="to" placeholder="To (Drop-off Point)" 
                        class="w-full p-4 pl-4 text-lg border rounded-lg shadow-md focus:ring focus:ring-blue-300"
                        value="{{ request('to') }}">
                </div>
                <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition">
                    🔍 Search
                </button>
                @if(request('from') || request('to'))
                    <a href="{{ route('client.index') }}" 
                    class="px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>
        @forelse ($offers as $offer)
            @if (!Auth::user()->hasRole('driver') || !$offer->accepted_driver_id || $offer->accepted_driver_id === (Auth::user()->driver->id ?? null))
                <div class="bg-gradient-to-br from-sky-800 to-sky-700 rounded-lg shadow-lg mb-8 p-6 text-white">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                            <h2 class="text-lg font-semibold text-green-400 uppercase">Pick Up Point</h2>
                            <p class="mt-2 text-gray-300">
                                {{ $offer->location_one }}
                            </p>
                        </div>
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                            <h2 class="text-lg font-semibold text-green-400 uppercase">Drop Off Point</h2>
                            <p class="mt-2 text-gray-300">
                                {{ $offer->city_one }}
                            </p>
                        </div>
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                            <h2 class="text-lg font-semibold text-cyan-300 uppercase">Number of Passengers</h2>
                            <p class="mt-2 text-gray-300">
                                {{ $offer->location_two }}
                            </p>
                        </div>
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                            <h2 class="text-lg font-semibold text-cyan-300 uppercase">Date and Time</h2>
                            <p class="mt-2 text-gray-300">
                            <time datetime="{{ \Carbon\Carbon::parse($offer->city_two)->setTimezone('Europe/London')->toIso8601String() }}">
                                {{ \Carbon\Carbon::parse($offer->city_two)->setTimezone('Europe/London')->format('F j, Y H:i') }}
                            </time>
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                        <h2 class="text-lg font-semibold text-yellow-400 uppercase">Additional Information</h2>
                        <p class="mt-2 text-gray-300">
                            {{ $offer->information }}
                        </p>
                    </div>

                    @if ($offer->offers_id == auth()->id())
                        <div class="mt-4 text-center">
                            @if ($offer->status === 'ongoing')
                            <form action="{{ route('offers.ongoing', ['hashid' => $offer->hashed_id]) }}" method="GET">
                                @csrf
                                <button type="submit" class="inline-block bg-green-600 text-white text-lg font-bold py-4 px-8 rounded-full shadow-lg transform hover:scale-105 hover:bg-green-700 transition-all duration-300 ease-in-out">
                                    Ongoing
                                </button>
                            </form>
                            @elseif ($offer->accepted_driver_id)
                                <span class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                                    Ride confirmed!
                                </span>
                            @else
                                <span class="inline-block bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                                    {{ $offer->rides->count() }} Application(s)
                                </span>
                            @endif
                        </div>
                    @endif
                    @hasrole('driver')
                        @if ($offer->accepted_driver_id && $offer->accepted_driver_id !== (Auth::user()->driver->id ?? null))
                            <div class="mt-4 text-center text-gray-400">
                                <span>This ride has already been accepted by another driver.</span>
                            </div>
                        @elseif ($offer->status === 'ongoing' && $offer->accepted_driver_id === (Auth::user()->driver->id ?? null))
                            <div class="mt-4 text-center">
                            <form action="{{ route('offers.ongoing', ['hashid' => $offer->hashed_id]) }}" method="GET">
                                @csrf
                                <button type="submit" class="inline-block bg-green-600 text-white text-lg font-bold py-4 px-8 rounded-full shadow-lg transform hover:scale-105 hover:bg-green-700 transition-all duration-300 ease-in-out">
                                    Ongoing Ride
                                </button>
                            </form>
                            </div>
                        @else
                            <div class="mt-4 text-center">
                                @if (in_array($offer->id, $appliedOffers))
                                    <span class="inline-block bg-green-500 text-white text-sm font-bold py-2 px-4 rounded-full shadow-md">
                                        ✔ Applied
                                    </span>
                                @else
                                    <span class="inline-block bg-gray-500 text-white text-sm font-bold py-2 px-4 rounded-full shadow-md">
                                        Not Applied
                                    </span>
                                @endif
                            </div>
                        @endif
                    @endhasrole
                    <div class="text-center mt-6">
                        <a href="{{ route('offers.show', $offer->hashed_id) }}" 
                           class="inline-block bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-indigo-500 hover:to-blue-500 text-white font-semibold py-2 px-6 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110">
                            View Details
                        </a>
                    </div>
                </div>
        @endif
        @empty
        <div class="flex flex-col items-center justify-center py-20">
            <div class="text-sky-700">
                <svg class="w-16 h-16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m0 0l-6-6m6 6H3"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-6">
                No Ride Offers Available
            </h2>
            <p class="text-gray-500 mt-4 text-lg text-center max-w-lg">
                It looks like there are no rides available for you at the moment. Keep checking back or try refreshing the page!
            </p>
        </div>
        @endforelse
    </div>
</x-app-layout>

