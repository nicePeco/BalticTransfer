<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-12 flex flex-col items-center">
        <div class="bg-white shadow-lg sm:rounded-3xl px-8 py-12 max-w-2xl w-full">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800">Rate Your Driver</h1>
                <p class="text-gray-500 mt-2">Please rate your driver for the ride from {{ $offer->location_one }} to {{ $offer->city_one }}.</p>
            </div>

            <form action="{{ route('offers.rate.submit', $offer->id) }}" method="POST" class="mt-8">
                @csrf

                <div class="mb-6">
                    <label for="rating" class="block text-gray-700 font-bold">Rating (1-5):</label>
                    <input 
                        type="number" 
                        name="rating" 
                        id="rating" 
                        class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        min="1" 
                        max="5" 
                        required
                    >
                </div>

                <div class="mb-6">
                    <label for="feedback" class="block text-gray-700 font-bold">Feedback (optional):</label>
                    <textarea 
                        name="feedback" 
                        id="feedback" 
                        rows="4" 
                        class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Write your feedback here..."></textarea>
                </div>

                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg font-bold text-lg transition-all">
                    Submit Rating
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
