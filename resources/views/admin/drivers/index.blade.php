<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">{{ __('Manage Drivers') }}</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
            <thead>
                <tr>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">ID</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Name</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Email</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Status</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $driver->id }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $driver->name }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $driver->email }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $driver->status ?? 'N/A' }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">
                            <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
