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

        <form action="{{ route('admin.drivers.update', $driver->id) }}" method="POST" class="space-y-6">
            @csrf
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
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">{{ __('Update Driver') }}</button>
            </div>
        </form>
    </div>
</x-app-layout>
