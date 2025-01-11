<x-app-layout>
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Rides</h1>

        @forelse ($offers as $offer)
            <!-- Only show to drivers if the offer has NOT been accepted -->
            @if (!Auth::user()->hasRole('driver') || !$offer->accepted_driver_id || $offer->accepted_driver_id === (Auth::user()->driver->id ?? null))
                <!-- Offer Card -->
                <div class="bg-gradient-to-br from-sky-800 to-sky-700 rounded-lg shadow-lg mb-8 p-6 text-white">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pick Up Point -->
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                            <h2 class="text-lg font-semibold text-green-400 uppercase">Pick Up Point</h2>
                            <p class="mt-2 text-gray-300">
                                {{ $offer->location_one }}
                            </p>
                        </div>

                        <!-- Drop Off Point -->
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                            <h2 class="text-lg font-semibold text-green-400 uppercase">Drop Off Point</h2>
                            <p class="mt-2 text-gray-300">
                                {{ $offer->city_one }}
                            </p>
                        </div>

                        <!-- Number of Passengers -->
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                            <h2 class="text-lg font-semibold text-cyan-300 uppercase">Number of Passengers</h2>
                            <p class="mt-2 text-gray-300">
                                {{ $offer->location_two }}
                            </p>
                        </div>

                        <!-- Date and Time -->
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                            <h2 class="text-lg font-semibold text-cyan-300 uppercase">Date and Time</h2>
                            <p class="mt-2 text-gray-300">
                            <time datetime="{{ \Carbon\Carbon::parse($offer->city_two)->setTimezone('Europe/London')->toIso8601String() }}">
                                {{ \Carbon\Carbon::parse($offer->city_two)->setTimezone('Europe/London')->format('F j, Y H:i') }}
                            </time>
                            </p>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mt-6 bg-gray-800 rounded-lg p-4 shadow-md transition-transform transform hover:scale-105">
                        <h2 class="text-lg font-semibold text-yellow-400 uppercase">Additional Information</h2>
                        <p class="mt-2 text-gray-300">
                            {{ $offer->information }}
                        </p>
                    </div>

                    @if ($offer->offers_id == auth()->id())
                        <div class="mt-4 text-center">
                            @if ($offer->status === 'ongoing')
                            <!-- Show "Ongoing" button if the ride is ongoing -->
                            <form action="{{ route('offers.ongoing', ['offerId' => $offer->id]) }}" method="GET">
                                @csrf
                                <button type="submit" class="inline-block bg-green-600 text-white text-lg font-bold py-4 px-8 rounded-full shadow-lg transform hover:scale-105 hover:bg-green-700 transition-all duration-300 ease-in-out">
                                    Ongoing
                                </button>
                            </form>
                            @elseif ($offer->accepted_driver_id)
                                <!-- Show "In Progress" if an accepted driver exists -->
                                <span class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                                    Ride confirmed!
                                </span>
                            @else
                                <!-- Show applications count -->
                                <span class="inline-block bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                                    {{ $offer->rides->count() }} Application(s)
                                </span>
                            @endif
                        </div>
                    @endif

                    <!-- Applied Status (for Drivers) -->
                    @hasrole('driver')
                        @if ($offer->accepted_driver_id && $offer->accepted_driver_id !== (Auth::user()->driver->id ?? null))
                            <!-- Hide the offer for other drivers -->
                            <div class="mt-4 text-center text-gray-400">
                                <span>This ride has already been accepted by another driver.</span>
                            </div>
                        @elseif ($offer->status === 'ongoing' && $offer->accepted_driver_id === (Auth::user()->driver->id ?? null))
                            <!-- If the ride is ongoing and accepted by this driver -->
                            <div class="mt-4 text-center">
                            <form action="{{ route('offers.ongoing', ['offerId' => $offer->id]) }}" method="GET">
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

                    <!-- View Button -->
                    <div class="text-center mt-6">
                        <a href="{{ route('offers.show', $offer->id) }}" 
                           class="inline-block bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-indigo-500 hover:to-blue-500 text-white font-semibold py-2 px-6 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110">
                            View Details
                        </a>
                    </div>
                </div>
        @endif
        @empty
        <!-- Fallback Message -->
        <div class="text-center py-16">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">No Ride Offers Available</h2>
            <p class="text-gray-500 mt-4">It seems like there are no rides available for you at the moment. Please check back later!</p>
        </div>
        @endforelse
    </div>
</x-app-layout>

