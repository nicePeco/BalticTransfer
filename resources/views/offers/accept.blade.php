<x-app-layout>
    <div class="container mx-auto py-12">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 rounded-lg shadow-lg flex justify-between items-center text-white relative">
            <a href="{{ url()->previous() }}" class="bg-white text-blue-600 font-bold py-2 px-6 rounded-lg shadow-md hover:bg-gray-100 transition-all duration-300">
                ← Back
            </a>
            <div class="text-center flex-1">
                <h1 class="text-4xl font-bold">Accepted Ride Details</h1>
                <p class="text-lg">Here are the details of the accepted ride.</p>
            </div>
            @if (
                (Auth::id() === $offer->offers_id || Auth::user()->driver->id === $offer->accepted_driver_id) 
                && $offer->status !== 'ongoing'
                )
                <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this ride?');" class="absolute top-6 right-6">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition-all duration-300">
                        Cancel the Ride
                    </button>
                </form>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 mt-8">
            <div class="flex items-center justify-between mb-6">
                <p class="text-gray-700 dark:text-gray-300 text-lg font-semibold">
                    Time Left:
                </p>
                <p 
                    class="text-xl font-bold px-4 py-2 rounded-md" 
                    :class="{
                        'bg-green-100 text-green-600': $timeLeftMinutes > 10,
                        'bg-yellow-100 text-yellow-600': $timeLeftMinutes > 5 && $timeLeftMinutes <= 10,
                        'bg-red-100 text-red-600': $timeLeftMinutes <= 5
                    }"
                >
                    {{ $timeLeftMinutes }} minutes
                </p>
            </div>

            @hasrole('driver')
                @if(Auth::user()->driver->id && $timeLeftMinutes <= 5 && $offer->status === 'pending')
                    <form action="{{ route('start.ride', ['offerId' => $offer->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Start</button>
                    </form>
                @elseif($offer->status === 'ongoing')
                    <!-- <p class="text-green-500 font-bold mb-4">Ride is ongoing</p>
                    <form action="{{ route('offers.ongoing', ['offerId' => $offer->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">View Information</button>
                    </form> -->
                @endif
            @endhasrole
            @if($offer->status === 'ongoing')
                <p class="text-green-500 font-bold mb-4">Ride is ongoing</p>
                    <form action="{{ route('offers.ongoing', ['offerId' => $offer->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">View Information</button>
                    </form>
            @endif
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6 border-b-2 pb-2">Ride Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">From</h3>
                    <p class="text-gray-900 dark:text-white mt-2">{{ $offer->location_one }}</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">To</h3>
                    <p class="text-gray-900 dark:text-white mt-2">{{ $offer->city_one }}</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Number of passangers</h3>
                    <p class="text-gray-900 dark:text-white mt-2">{{ $offer->location_two }}</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Date and time</h3>
                    <p class="text-gray-900 dark:text-white mt-2"><time datetime="{{ $offer->city_two }}">
                        {{ \Carbon\Carbon::parse($offer->city_two)->format('F j, Y H:i') }}
                    </time>
                </div>
            </div>

            <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg mt-6 text-center">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Additional Information</h3>
                <p class="text-gray-900 dark:text-white mt-2">{{ $offer->information }}</p>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-8 border-b-2 pb-2">Driver Information</h2>
            @if($acceptedRide)
                <div class="flex flex-wrap gap-6 mt-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Driver Photo</h3>
                        @if ($acceptedRide->driver->profile_photo)
                            <img class="image rounded-full mt-2" src="{{ asset('storage/' . $acceptedRide->driver->profile_photo) }}" alt="Driver Photo" style="width: 100px; height: 100px;">
                        @else
                            <img class="image rounded-full mt-2" src="{{ asset('https://usdeafsoccer.com/wp-content/uploads/2022/05/no-profile-pic.png') }}" alt="Driver Photo" style="width: 100px; height: 100px;">
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Car Photo</h3>
                        @if ($acceptedRide->driver->car_photo)
                            <img src="{{ asset('storage/' . $acceptedRide->driver->car_photo) }}" alt="Car Photo" class="w-64 h-64 object-cover rounded-lg shadow-lg mt-2">
                        @else
                            <p class="text-gray-500 dark:text-gray-400 mt-2">No car photo available.</p>
                        @endif
                    </div>
                </div>
                <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg mt-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Driver Details</h3>
                    <ul class="list-disc list-inside mt-2 text-gray-900 dark:text-white">
                        <li><strong>Name:</strong> {{ $acceptedRide->driver->name }}</li>
                        <li><strong>Car Make:</strong> {{ $acceptedRide->driver->car_make }}</li>
                        <li><strong>Car Model:</strong> {{ $acceptedRide->driver->car_model }}</li>
                        <li><strong>Car Year:</strong> {{ $acceptedRide->driver->car_year }}</li>
                        <li><strong>Price:</strong> €{{ number_format($acceptedRide->price, 2) }}</li>
                    </ul>
                </div>
            @else
                <p class="text-red-500 text-lg font-semibold mt-6">No driver has been accepted yet.</p>
            @endif
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-8 border-b-2 pb-2">Client information</h2>
            <div class="flex items-center mt-6">
                @if(Auth::user()->profile_photo)
                    <img class="image rounded-full" src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="User Photo" style="width: 100px; height: 100px;">
                @else
                    <img class="image rounded-full" src="{{ asset('https://usdeafsoccer.com/wp-content/uploads/2022/05/no-profile-pic.png') }}" alt="User Photo" style="width: 100px; height: 100px;">
                @endif

                @if ($offer->user)
                    <p class="text-gray-900 dark:text-white ml-4"><strong>Name:</strong> {{ $offer->user->name }}</p>
                    <p class="text-gray-900 dark:text-white ml-4"><strong>Email:</strong> {{ $offer->user->email }}</p>
                @else
                    <p class="text-red-500">User information is not available.</p>
                @endif
            </div>
            <!-- @if (Auth::id() === $offer->offers_id || Auth::user()->driver->id === $offer->accepted_driver_id)
                <div class="mt-8 text-center">
                    <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this ride?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition-all duration-300">
                            Cancel the Ride
                        </button>
                    </form>
                </div>
            @endif -->
        </div>
        <div class="bg-gray-100 dark:bg-gray-900 rounded-lg shadow-md p-6 mt-8">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4 border-b-2 pb-2">Chat</h2>
            <div id="chat-box" class="h-64 overflow-y-auto bg-white dark:bg-gray-800 rounded-lg p-4 border">

            </div>

            <form id="message-form" class="mt-4 flex">
                @csrf
                <input type="hidden" id="offer_id" value="{{ $offer->id }}">
                <input 
                    type="text" 
                    id="message-input" 
                    placeholder="Type your message..." 
                    class="flex-1 px-4 py-2 border rounded-l-lg focus:outline-none"
                    required
                />
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-r-lg transition-all duration-300">
                    Send
                </button>
            </form>
        </div>

        <script>
            const offerId = document.getElementById('offer_id').value;

            function loadMessages() {
                fetch(`/messages/${offerId}`)
                    .then(response => response.json())
                    .then(data => {
                        const chatBox = document.getElementById('chat-box');
                        chatBox.innerHTML = '';

                        data.forEach(msg => {
                            const message = document.createElement('div');
                            message.className = 'mb-2';
                            message.innerHTML = 
                                `<div class="flex flex-col mb-2">
                                    <!-- Sender's Name and Timestamp -->
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-blue-600 dark:text-blue-400">${msg.sender.name}</span>
                                        <span class="text-xs text-gray-400 whitespace-nowrap">${new Date(msg.created_at).toLocaleString()}</span>
                                    </div>
                                    <!-- Message Content -->
                                    <div class="bg-gray-100 dark:bg-gray-700 p-2 rounded-lg shadow-sm mt-1 w-fit max-w-full break-words">
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            ${msg.message}
                                        </p>
                                    </div>
                                </div>`;
                            chatBox.appendChild(message);
                        });

                        chatBox.scrollTop = chatBox.scrollHeight;
                    });
            }

            loadMessages();

            document.getElementById('message-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const messageInput = document.getElementById('message-input');
                const message = messageInput.value;

                fetch('/messages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ offer_id: offerId, message })
                })
                .then(response => response.json())
                .then(() => {
                    messageInput.value = '';
                    loadMessages();
                });
            });

            setInterval(loadMessages, 5000);
        </script>
    </div>
</x-app-layout>
