<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">{{ __('Manage Users') }}</h1>
        <form method="GET" action="{{ route('admin.users') }}" class="mb-4">
            <div class="flex items-center space-x-4">
                <input
                    type="text"
                    name="search"
                    placeholder="Search by ID"
                    value="{{ request('search') }}"
                    class="p-2 border border-gray-300 rounded w-64"
                >
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    Search
                </button>
                <a
                    href="{{ route('admin.users') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400"
                >
                    Reset
                </a>
            </div>
        </form>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300 bg-gray-400 dark:border-gray-600">
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
                @foreach($users as $user)
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $user->id }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $user->name }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $user->email }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2 text-center">
                            @if($user->suspended_until && now()->lessThan($user->suspended_until))
                                <span class="text-red-600 font-bold">Suspended</span>
                            @else
                                <span class="text-green-600 font-bold">Active</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
