<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">{{ __('Manage Rides') }}</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
            <thead>
                <tr>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Ride ID</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Passenger (ID - Name)</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Driver (ID - Name)</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Status</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rides as $ride)
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $ride->id }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">
                            {{ $ride->offers_id }} - {{ $ride->passenger ? $ride->passenger->name : 'N/A' }}
                        </td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">
                            {{ $ride->accepted_driver_id }} - {{ $ride->driver ? $ride->driver->name : 'N/A' }}
                        </td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ ucfirst($ride->status) }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">
                            <a href="{{ route('admin.rides.edit', $ride->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
