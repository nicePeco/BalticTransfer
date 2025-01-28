<div x-data="{ open: false }" class="relative z-50"> <!-- Added z-50 -->
    <button @click="open = !open" class="relative flex items-center text-gray-400 hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M15 17h5l-1.405-1.405a2.032 2.032 0 00-2.83 0L15 17zm0 0v3a2 2 0 01-2 2H9a2 2 0 01-2-2v-3m0 0H4l1.405-1.405a2.032 2.032 0 012.83 0L9 17zm3-13a4 4 0 014 4v1.5a4 4 0 01-.858 2.573l-1.153 1.153A2 2 0 0014 15.5v.5a2 2 0 01-4 0v-.5a2 2 0 00-.989-1.774L7.858 11.073A4 4 0 017 8.5V7a4 4 0 014-4z" />
        </svg>

        @if (auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500"></span>
        @endif
    </button>

    <!--dropdown -->
    <div x-show="open" @click.away="open = false" 
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50">
        <div class="py-2 px-4 text-gray-900 font-bold">Notifications</div>

        @forelse (auth()->user()->unreadNotifications as $notification)
            <div class="p-4 hover:bg-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">{{ $notification->data['title'] }}</h3>
                    <p class="text-xs text-gray-600">{{ $notification->data['body'] }}</p>
                </div>
                <div>
                    <!-- view -->
                    <!-- <form action="{{ route('notifications.delete', $notification->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="text-xs text-blue-500 hover:underline">View</button>
                    </form> -->

                    <!-- mark as read-->
                    <button 
                        @click="markAsRead('{{ $notification->id }}')"
                        class="text-xs text-gray-500 hover:underline ml-2">
                        Mark as Read
                    </button>
                </div>
            </div>
        @empty
            <div class="p-4 text-gray-500 text-center">No new notifications.</div>
        @endforelse
    </div>
</div>

<script>
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
</script>
