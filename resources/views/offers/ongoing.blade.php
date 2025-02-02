<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-12 flex flex-col items-center px-4 sm:px-0">
        <div class="relative w-full max-w-4xl mx-auto">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 shadow-lg transform -skew-y-3 sm:skew-y-0 sm:-rotate-3 sm:rounded-3xl"></div>
            <div class="relative bg-white shadow-lg sm:rounded-3xl px-6 py-10 sm:px-10 sm:py-12">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-800">🚖 Ongoing Ride</h1>
                    <p class="text-gray-500 mt-2">Here are the details of your current ride.</p>
                </div>
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="bg-gray-50 p-5 rounded-lg shadow-md">
                        <p class="text-gray-600 text-lg">
                            <span class="font-semibold text-gray-800">📅 Scheduled Start Time:</span>
                            <br class="sm:hidden">
                            <span class="block sm:inline">{{ $scheduledStartTime }}</span>
                        </p>
                        <p class="text-gray-600 text-lg mt-2">
                            <span class="font-semibold text-gray-800">🕒 Current Time:</span>
                            <br class="sm:hidden">
                            <span class="block sm:inline">{{ $currentTime }}</span>
                        </p>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-lg shadow-md">
                        <p class="text-gray-600 text-lg">
                            <span class="font-semibold text-gray-800">📍 From:</span>
                            <br class="sm:hidden">
                            <span class="block sm:inline">{{ $offer->location_one }}</span>
                        </p>
                        <p class="text-gray-600 text-lg mt-2">
                            <span class="font-semibold text-gray-800">📍 To:</span>
                            <br class="sm:hidden">
                            <span class="block sm:inline">{{ $offer->city_one }}</span>
                        </p>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-lg shadow-md">
                        <p class="text-gray-600 text-lg">
                            <span class="font-semibold text-gray-800">🚦 Ride Status:</span>
                            <br class="sm:hidden">
                            <span class="block sm:inline text-red-500 font-semibold">Ride has already started!</span>
                        </p>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-lg shadow-md">
                        <p class="text-gray-600 text-lg">
                            <span class="font-semibold text-gray-800">💰 Price:</span>
                            <br class="sm:hidden">
                            <span class="block sm:inline">€{{ number_format($acceptedRide->price, 2) }}</span>
                        </p>
                    </div>
                </div>
                @hasrole('driver')
                    @if ($offer->accepted_driver_id === Auth::user()->driver->id && $offer->status === 'ongoing')
                        <div class="text-center mt-8">
                            <button 
                                id="finish-ride-btn" 
                                class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg font-bold text-lg transition-all w-full sm:w-auto">
                                ✅ Finish Ride
                            </button>
                        </div>
                    @endif
                @endhasrole
                <div class="bg-gray-50 rounded-lg shadow-md p-6 mt-10 w-full">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b-2 pb-2">💬 Chat</h2>

                    <div id="chat-box" class="h-64 sm:h-80 overflow-y-auto bg-white rounded-lg p-4 border border-gray-300">
                    </div>

                    <form id="message-form" class="mt-4 flex flex-col sm:flex-row gap-2">
                        @csrf
                        <input type="hidden" id="offer_id" value="{{ $offer->id }}">
                        <input 
                            type="text" 
                            id="message-input" 
                            placeholder="Type your message..." 
                            class="flex-1 px-4 py-3 border rounded-lg sm:rounded-l-lg sm:rounded-r-none focus:outline-none focus:ring focus:border-blue-500"
                            required
                        />
                        <button 
                            type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg sm:rounded-r-lg sm:rounded-l-none transition-all duration-300">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
            <h2 class="text-lg font-bold text-gray-800">Confirm Finish Ride</h2>
            <p class="text-gray-600 mt-2">Are you sure you want to finish the ride?</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button id="cancel-btn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-all">Cancel</button>
                <form id="confirm-finish-form" action="{{ route('offers.finish', ['offerId' => $offer->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-all">
                        Confirm
                    </button>
                </form>
            </div>
        </div>
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

        const finishRideBtn = document.getElementById('finish-ride-btn');
        const confirmationModal = document.getElementById('confirmation-modal');
        const cancelBtn = document.getElementById('cancel-btn');

        finishRideBtn.addEventListener('click', () => {
            confirmationModal.classList.remove('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            confirmationModal.classList.add('hidden');
        });
    </script>
</x-app-layout>
