<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">{{ __('Recent Messages') }}</h2>

        @if($messages->isEmpty())
            <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-md">
                <p class="text-gray-600 dark:text-gray-400">{{ __('No users have sent messages yet.') }}</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-600">
                                {{ __('User ID') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-600">
                                {{ __('Name') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-600">
                                {{ __('Latest Message Time') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-600">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-600">
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $message->sender->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                    {{ $message->sender->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $message->created_at->format('d-m-Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if(!$message->is_read)
                                        <form method="POST" action="{{ route('admin.messages.mark-read', $message->id) }}">
                                            @csrf
                                            <button type="submit" class="text-red-500 font-bold hover:underline">
                                                {{ __('Mark as Read') }}
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.messages.mark-unread', $message->id) }}">
                                            @csrf
                                            <button type="submit" class="text-green-500 hover:underline">
                                                {{ __('Mark as Unread') }}
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.messages.chat', ['userId' => $message->sender->id]) }}"
                                    class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                        {{ __('View Chat') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
