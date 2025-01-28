<x-app-layout>
    <div class="relative overflow-hidden rounded-lg bg-cover bg-no-repeat p-12 text-center">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">My Applications</h1>
        <div class="hidden md:block relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Pick up point</th>
                        <th scope="col" class="px-6 py-3">Drop off point</th>
                        <th scope="col" class="px-6 py-3">Number of passengers</th>
                        <th scope="col" class="px-6 py-3">Date and time</th>
                        <th scope="col" class="px-6 py-3">Price Offered</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rides as $ride)
                        @if(!$ride->offer->accepted_driver_id || $ride->offer->accepted_driver_id === $ride->driver_id)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $ride->offer->location_one }}</td>
                                <td class="px-6 py-4">{{ $ride->offer->city_one }}</td>
                                <td class="px-6 py-4">{{ $ride->offer->location_two }}</td>
                                <td class="px-6 py-4 font-medium text-cyan-300 whitespace-nowrap">
                                    <time datetime="{{ $ride->offer->city_two }}">
                                        {{ date('F j, Y H:i', strtotime($ride->offer->city_two)) }}
                                    </time>
                                </td>
                                <td class="px-6 py-4 text-green-500 font-bold">${{ number_format($ride->price, 2) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        @if(!$ride->offer->accepted_driver_id)
                                            <form action="{{ route('rides.destroy', $ride->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                                    Cancel
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('offers.accept.show', $ride->offer->hashed_id) }}"
                                               class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                                View Accepted Ride
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="md:hidden">
            @forelse ($rides as $ride)
                @if(!$ride->offer->accepted_driver_id || $ride->offer->accepted_driver_id === $ride->driver_id)
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow mb-4 p-4">
                        <div class="mb-2">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200">Pick up point:</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $ride->offer->location_one }}</p>
                        </div>
                        <div class="mb-2">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200">Drop off point:</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $ride->offer->city_one }}</p>
                        </div>
                        <div class="mb-2">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200">Date and time:</h3>
                            <p class="text-cyan-300 font-medium">
                                <time datetime="{{ $ride->offer->city_two }}">
                                    {{ date('F j, Y H:i', strtotime($ride->offer->city_two)) }}
                                </time>
                            </p>
                        </div>
                        <div class="mb-2">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200">Price Offered:</h3>
                            <p class="text-green-500 font-bold">${{ number_format($ride->price, 2) }}</p>
                        </div>
                        <div>
                            <div class="flex gap-2">
                                @if(!$ride->offer->accepted_driver_id)
                                    <form action="{{ route('rides.destroy', $ride->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                            Cancel
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('offers.accept.show', $ride->offer->hashed_id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                        View Accepted Ride
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-center text-gray-500">No applications found.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

