<x-app-layout>
    <div class="bg-cover bg-fixed min-h-screen" style="background-image: url('https://www.tallinn.ee/themes/main_site/public/images/old_town_kaupo_kalda_2018_5_optimized.jpg')">
        <section class="max-w-6xl mx-auto py-12 bg-gray-100 bg-opacity-70 dark:bg-gray-900 dark:bg-opacity-70 rounded-lg shadow-lg p-8 backdrop-filter backdrop-blur-lg">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white">Ride Details</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Below are the details of the ride offer.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold text-sky-500">Pick up point</h2>
                    <p class="mt-2 text-gray-700 dark:text-gray-300 border-2 border-sky-500 rounded-lg px-4 py-3 bg-gray-50 dark:bg-gray-800">
                        {{ $offers->location_one }}
                    </p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-sky-500">Drop off point</h2>
                    <p class="mt-2 text-gray-700 dark:text-gray-300 border-2 border-sky-500 rounded-lg px-4 py-3 bg-gray-50 dark:bg-gray-800">
                        {{ $offers->city_one }}
                    </p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-cyan-500">Number of passangers</h2>
                    <p class="mt-2 text-gray-700 dark:text-gray-300 border-2 border-cyan-500 rounded-lg px-4 py-3 bg-gray-50 dark:bg-gray-800">
                        {{ $offers->location_two }}
                    </p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-cyan-500">Date and time</h2>
                    <p class="mt-2 text-gray-700 dark:text-gray-300 border-2 border-cyan-500 rounded-lg px-4 py-3 bg-gray-50 dark:bg-gray-800">
                    <time datetime="{{ $offers->city_two }}">
                        {{ \Carbon\Carbon::parse($offers->city_two)->format('F j, Y H:i') }}
                    </time>
                    </p>
                </div>
                <div class="col-span-full">
                    <h2 class="text-lg font-semibold text-yellow-500">Additional Information</h2>
                    <p class="mt-2 text-gray-700 dark:text-gray-300 border-2 border-yellow-500 rounded-lg px-4 py-3 bg-gray-50 dark:bg-gray-800">
                        {{ $offers->information }}
                    </p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-purple-500">Distance</h2>
                    <p class="mt-2 text-gray-700 border-2 border-purple-500 rounded-lg px-4 py-3 bg-gray-50">
                        {{ $offers->distance ?? 'N/A' }} km
                    </p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-purple-500">Time</h2>
                    <p class="mt-2 text-gray-700 border-2 border-purple-500 rounded-lg px-4 py-3 bg-gray-50">
                        {{ $offers->time ?? 'N/A' }} hours
                    </p>
                </div>
            </div>
            @if($offers->offers_id == auth()->id() && !$offers->accepted_driver_id)
            <div class="mt-8 text-center space-x-4">
                <form action="{{ route('offers.edit', $offers->id) }}" method="post" class="inline-block">
                @csrf
                    <!-- <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md">
                        @lang('Edit Ride Details')
                    </button> -->
                </form>
                <form action="{{ route('offers.destroy', $offers->id) }}" method="post" class="inline-block">
                    @csrf
                    @method('delete')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md">
                        @lang('Delete Ride Offer')
                    </button>
                </form>
            </div>
            @endif
        </section>

        @if($offers->accepted_driver_id)
            @php
                $acceptedRide = $offers->rides->where('driver_id', $offers->accepted_driver_id)->first();
            @endphp
            @if($acceptedRide)
                <section class="max-w-6xl mx-auto mt-12 bg-gray-100 bg-opacity-70 dark:bg-gray-900 dark:bg-opacity-70 rounded-lg shadow p-6 backdrop-filter backdrop-blur-lg">
                    <h2 class="text-center text-2xl font-bold text-gray-800 dark:text-white mb-6">Accepted Ride</h2>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 border border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Driver Name:</strong> <span class="text-gray-800 dark:text-white">{{ $acceptedRide->driver->name }}</span>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            <strong>Price Offered:</strong> <span class="text-green-600 dark:text-green-400 font-bold">€{{ number_format($acceptedRide->price, 2) }}</span>
                        </p>
                    </div>
                    <div class="text-center mt-6">
                        <a href="{{ route('offers.accept.show', $offers->hashed_id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md">
                            View Accepted Ride Details
                        </a>
                    </div>
                </section>
            @endif
        @else
            @if ($currentRide)
                <div class="text-center mt-8">
                <h2 class="text-green-500 font-bold text-xl">You have applied for this ride!</h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Your price: €{{ number_format($currentRide->price, 2) }}</p>
                </div>
            @elseif (auth()->user()->hasRole('driver'))
            <form action="{{ route('rides.store') }}" method="post" class="max-w-6xl mx-auto mt-8 bg-gray-100 dark:bg-gray-900 rounded-lg shadow p-6">
                @csrf
                <input type="hidden" name="offer_id" value="{{ $offers->id }}">
                <div class="flex flex-col md:flex-row items-center space-x-4">
                    <label for="price" class="block text-gray-700 dark:text-gray-300 font-bold">Enter your price:</label>
                    <input type="number" name="price" id="price" class="w-full md:w-auto px-4 py-2 border rounded-lg text-gray-900 dark:text-gray-200 bg-white dark:bg-gray-700" step="0.01" min="0" required>
                </div>
                <div class="mt-4 text-right">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-md">
                        @lang('Apply for this Ride')
                    </button>
                </div>
            </form> 
            @endif
            @if(auth()->id() == $offers->offers_id)
            <div class="max-w-6xl mx-auto mt-12 bg-gray-100 bg-opacity-70 dark:bg-gray-900 dark:bg-opacity-70 rounded-lg shadow p-6 backdrop-filter backdrop-blur-lg">
                <h2 class="text-center text-2xl font-bold text-gray-800 dark:text-white mb-6">Driver Applications</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($offers->rides as $ride)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 border border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Driver Name:</strong> <span class="text-gray-800 dark:text-white">{{ $ride->driver->name }}</span>
                        </p>
                        @if($ride->driver->profile_photo)
                            <img class="mt-4 rounded-full shadow-md" src="{{ asset('storage/' . $ride->driver->profile_photo) }}" alt="Driver Photo" style="width: 100px; height: 100px;">
                        @else
                            <img class="mt-4 rounded-full shadow-md" src="https://usdeafsoccer.com/wp-content/uploads/2022/05/no-profile-pic.png" alt="Driver Photo" style="width: 100px; height: 100px;">
                        @endif
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-4">
                            <strong>Price Offered:</strong> <span class="text-green-600 dark:text-green-400 font-bold">€{{ number_format($ride->price, 2) }}</span>
                        </p>
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Car Details</h3>
                            @if($ride->driver->car_photo)
                                <img class="mt-4 rounded-lg shadow-md" src="{{ asset('storage/' . $ride->driver->car_photo) }}" alt="Car Photo" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <p class="text-gray-500 dark:text-gray-400 mt-4">No car photo available.</p>
                            @endif
                            <ul class="list-disc list-inside mt-4 text-gray-900 dark:text-white">
                                <li><strong>Make:</strong> {{ $ride->driver->car_make }}</li>
                                <li><strong>Model:</strong> {{ $ride->driver->car_model }}</li>
                                <li><strong>Year:</strong> {{ $ride->driver->car_year }}</li>
                            </ul>
                        </div>
                        <form action="{{ route('offers.accept', $ride->id) }}" method="post" class="mt-4">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md w-full">
                                @lang('Accept Driver')
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        @endif
    </div>
</x-app-layout>
