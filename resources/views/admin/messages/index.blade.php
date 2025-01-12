<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">{{ __('Messages Dashboard') }}</h1>

        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-4">{{ __('Recent Messages') }}</h2>

            @if($users->isEmpty())
                <p class="text-gray-600 dark:text-gray-400">{{ __('No users have sent messages yet.') }}</p>
            @else
                <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 dark:border-gray-600 p-2">User ID</th>
                            <th class="border border-gray-300 dark:border-gray-600 p-2">Name</th>
                            <th class="border border-gray-300 dark:border-gray-600 p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $user->id }}</td>
                                <td class="border border-gray-300 dark:border-gray-600 p-2">{{ $user->name }}</td>
                                <td class="border border-gray-300 dark:border-gray-600 p-2">
                                    <a href="{{ route('admin.messages.chat', ['userId' => $user->id]) }}" class="text-blue-500 hover:underline">
                                        {{ __('View Chat') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
