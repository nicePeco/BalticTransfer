<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">{{ __('Manage Users') }}</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
            <thead>
                <tr>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">ID</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Name</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Email</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Role</th>
                    <th class="border border-gray-300 dark:border-gray-600 p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $user->id }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $user->name }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $user->email }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $user->role }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
