<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-black mb-8 text-center">
            {{ __('Your Messages with Admin') }}
        </h1>

        <div class="mb-8 border border-gray-300 dark:border-gray-600 p-6 rounded-lg bg-gray-100 dark:bg-gray-800 shadow-md" style="max-height: 500px; overflow-y: auto;">
            @forelse($messages as $message)
                <div class="mb-4 flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-lg px-4 py-3 rounded-lg shadow-md {{ $message->sender_id === Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-800' }}">
                        <p class="break-words">{{ $message->message }}</p>
                        <p class="text-sm text-gray-200 dark:text-gray-400 mt-1 text-right">
                            {{ $message->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 dark:text-gray-400 py-4">
                    {{ __('No messages yet. Start the conversation!') }}
                </p>
            @endforelse
        </div>

        <div class="mt-8 bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-4 text-center">
                {{ __('Send a Message to Admin') }}
            </h2>

            <form method="POST" action="{{ route('messages.direct.store') }}">
                @csrf
                <div class="mb-4">
                    <textarea name="message" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-blue-300 dark:focus:ring-blue-600 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 resize-none" rows="4" placeholder="{{ __('Type your message...') }}" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-all">
                        {{ __('Send Message') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

