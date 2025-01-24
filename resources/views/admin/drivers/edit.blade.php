<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">{{ __('Edit Driver') }}</h1>

        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div>
                <label for="name" class="block text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" value="{{ $driver->name }}" class="w-full mt-1 p-2 border border-gray-300 rounded">
            </div>
            <div>
                <label for="email" class="block text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" value="{{ $driver->email }}" class="w-full mt-1 p-2 border border-gray-300 rounded">
            </div>
            <div>
                <label for="status" class="block text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
                <select id="status" name="status" class="w-full mt-1 p-2 border border-gray-300 rounded">
                    <option value="active" {{ $driver->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $driver->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300">{{ __('Total Company Share (€)') }}</label>
                <p class="w-full mt-1 p-2 border border-gray-300 rounded bg-gray-100">
                    €{{ number_format($driver->total_company_share ?? 0, 2) }}
                </p>
            </div>
            <div class="flex items-center space-x-4 mt-6">
                <!-- Has Paid Button -->
                <form action="{{ route('admin.drivers.hasPaid', $driver->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">
                        {{ __('Has Paid') }}
                    </button>
                </form>

                <!-- Has Not Paid Button -->
                <form action="{{ route('admin.drivers.hasNotPaid', $driver->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">
                        {{ __('Has Not Paid') }}
                    </button>
                </form>
                @if ($driver->suspended_until)
                    <form action="{{ route('admin.drivers.unsuspend', $driver->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded">
                            {{ __('Unsuspend Driver') }}
                        </button>
                    </form>
                @endif
            </div>
    </div>
</x-app-layout>
