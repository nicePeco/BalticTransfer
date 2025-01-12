<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">{{ __('Edit Ride') }}</h1>

        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.rides.update', $ride->id) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="status" class="block text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
                <select id="status" name="status" class="w-full mt-1 p-2 border border-gray-300 rounded">
                    <option value="pending" {{ $ride->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $ride->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="canceled" {{ $ride->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>
            <div>
                <label for="driver_id" class="block text-gray-700 dark:text-gray-300">{{ __('Driver') }}</label>
                <select id="driver_id" name="driver_id" class="w-full mt-1 p-2 border border-gray-300 rounded">
                    <option value="">None</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}" {{ $ride->accepted_driver_id == $driver->id ? 'selected' : '' }}>
                            {{ $driver->id }} - {{ $driver->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="passenger_id" class="block text-gray-700 dark:text-gray-300">{{ __('Passenger') }}</label>
                <select id="passenger_id" name="passenger_id" class="w-full mt-1 p-2 border border-gray-300 rounded">
                    <option value="">None</option>
                    @foreach($passengers as $passenger)
                        <option value="{{ $passenger->id }}" {{ $ride->offers_id == $passenger->id ? 'selected' : '' }}>
                            {{ $passenger->id }} - {{ $passenger->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">{{ __('Update Ride') }}</button>
            </div>
        </form>
    </div>
</x-app-layout>
