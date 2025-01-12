<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">{{ __('Chat with ') }} {{ $user->name }}</h1>

        <div class="mb-8 border border-gray-300 dark:border-gray-600 p-4 rounded bg-gray-100 dark:bg-gray-800" style="max-height: 500px; overflow-y: auto;">
        @foreach($messages as $message)
            <div class="mb-4">
                <!-- Check if the message is from the logged-in admin -->
                <div class="{{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}">
                    <p class="inline-block px-4 py-2 rounded {{ $message->sender_id === Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-800' }}">
                        {{ $message->message }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">{{ $message->created_at->format('d-m-Y H:i') }}</p>
                </div>
            </div>
        @endforeach
    </div>

        <form method="POST" action="{{ route('admin.messages.reply') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="mb-4">
                <textarea name="message" class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" rows="4" placeholder="{{ __('Type your reply...') }}" required></textarea>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">{{ __('Send Reply') }}</button>
        </form>
    </div>
</x-app-layout>
