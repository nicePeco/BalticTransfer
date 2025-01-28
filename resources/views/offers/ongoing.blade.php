<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-12 flex flex-col items-center">
        <div class="relative w-full max-w-4xl mx-auto">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"></div>
            <div class="relative bg-white shadow-lg sm:rounded-3xl px-8 py-12">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-800">Ongoing Ride</h1>
                    <p class="text-gray-500 mt-2">Here are the details of your current ride.</p>
                </div>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                        <p class="text-gray-600 text-lg">
                            <span class="font-semibold text-gray-800">Scheduled Start Time:</span>
                            {{ $scheduledStartTime }}
                        </p>
                        <p class="text-gray-600 text-lg mt-2">
                            <span class="font-semibold text-gray-800">Current Time:</span>
                            {{ $currentTime }}
                        </p>
                    </div>
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                        <p class="text-gray-600 text-lg">
                            <span class="font-semibold text-gray-800">From:</span>
                            {{ $offer->location_one }}
                        </p>
                        <p class="text-gray-600 text-lg mt-2">
                            <span class="font-semibold text-gray-800">To:</span>
                            {{ $offer->city_one }}
                        </p>
                    </div>
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                        <p class="text-gray-600 text-lg">
                            <span class="font-semibold text-gray-800">Ride Status:</span>
                            <span class="text-red-500 font-semibold">Ride has already started!</span>
                        </p>
                    </div>
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                        <p class="text-gray-600 text-lg">
                            <span class="font-semibold text-gray-800">Price:</span>
                            €{{ number_format($acceptedRide->price, 2) }}
                        </p>
                    </div>
                </div>

                @hasrole('driver')
                    @if ($offer->accepted_driver_id === Auth::user()->driver->id && $offer->status === 'ongoing')
                        <button 
                            id="finish-ride-btn" 
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg font-bold text-lg transition-all mt-8"
                        >
                            Finish Ride
                        </button>
                    @endif
                @endhasrole

                <div class="bg-gray-100 dark:bg-gray-900 rounded-lg shadow-md p-6 mt-12">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4 border-b-2 pb-2">Chat</h2>

                    <div id="chat-box" class="h-64 sm:h-80 overflow-y-auto bg-white dark:bg-gray-800 rounded-lg p-4 border">

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
                <button 
                    id="cancel-btn" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-all"
                >
                    Cancel
                </button>
                <form 
                    id="confirm-finish-form" 
                    action="{{ route('offers.finish', ['offerId' => $offer->id]) }}" 
                    method="POST"
                >
                    @csrf
                    @method('PATCH')
                    <button 
                        type="submit" 
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-all"
                    >
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
