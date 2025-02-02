<x-app-layout>
    <style>
        #map {
            height: 70vh;
            width: 100%;
            margin-top: 1rem;
        }
    </style>

    <div class="relative bg-gray-100 min-h-screen">
        <div class="flex flex-col lg:flex-row max-w-6xl mx-auto bg-white rounded-xl shadow-xl overflow-hidden mt-10">
            <form method="post" action="{{ route('offers.store') }}" enctype="multipart/form-data" class="w-full lg:w-1/2 p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Claim Ride</h2>
                @csrf
                <input type="hidden" name="offers_id" value="{{ auth()->user()->id }}">

                <div class="mb-4">
                    <label for="location_one" class="block text-lg font-medium text-gray-700 mb-2">Pick up point</label>
                    <input
                        name="location_one"
                        id="location_one"
                        type="text"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        placeholder="Enter pick up address"
                        required
                    />
                    <ul id="location_one_suggestions" class="hidden bg-white border mt-2 rounded-lg shadow-md"></ul>
                </div>

                <div class="mb-4">
                    <label for="city_one" class="block text-lg font-medium text-gray-700 mb-2">Destination</label>
                    <input
                        name="city_one"
                        id="city_one"
                        type="text"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        placeholder="Enter destination address"
                        required
                    />
                    <ul id="city_one_suggestions" class="hidden bg-white border mt-2 rounded-lg shadow-md"></ul>
                </div>

                <div class="mb-4">
                    <label for="location_two" class="block text-lg font-medium text-gray-700 mb-2">Passenger count</label>
                    <input
                        name="location_two"
                        id="location_two"
                        type="number"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        placeholder="Enter passenger count"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label for="city_two" class="block text-lg font-medium text-gray-700 mb-2">Date and time</label>
                    <input
                        name="city_two"
                        id="city_two"
                        type="datetime-local"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label for="information" class="block text-lg font-medium text-gray-700 mb-2">Additional Information</label>
                    <textarea
                        name="information"
                        id="information"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        rows="4"
                        placeholder="Add any relevant details..."
                        required
                    ></textarea>
                </div>

                <div class="mb-6">
                    <label for="distance" class="block text-lg font-semibold text-gray-800 mb-2">Distance (km)</label>
                    <div class="relative">
                        <input
                            name="distance"
                            id="hidden-distance"
                            type="text"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            readonly
                        />
                        <span class="absolute inset-y-0 right-4 flex items-center text-gray-500 text-lg">
                            📏
                        </span>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="time" class="block text-lg font-semibold text-gray-800 mb-2">Time (hours)</label>
                    <div class="relative">
                        <input
                            name="time"
                            id="hidden-time"
                            type="text"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            readonly
                        />
                        <span class="absolute inset-y-0 right-4 flex items-center text-gray-500 text-lg">
                            ⏳
                        </span>
                    </div>
                </div>

                <div class="text-center">
                    <button
                        type="submit"
                        class="w-full py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300">
                        Submit Offer
                    </button>
                </div>
            </form>

            <div class="w-full lg:w-1/2 p-4">
                <div id="map" class="rounded-lg shadow"></div>
            </div>
        </div>
    </div>

    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
    <script>
        const apiKey = '34a932be97cd47f98436554fdd061734'; // OpenCage API Key

        let map;
        let fromCoords = null, toCoords = null;

        function attachOpenCageAutocomplete(inputId, suggestionsId, callback) {
            const input = document.getElementById(inputId);
            const suggestions = document.getElementById(suggestionsId);

            input.addEventListener('input', async () => {
                const query = input.value;

                if (query.length < 3) {
                    suggestions.classList.add('hidden');
                    return;
                }

                const response = await fetch(`https://api.opencagedata.com/geocode/v1/json?q=${query}&key=${apiKey}&limit=5`);
                const data = await response.json();

                suggestions.innerHTML = '';
                data.results.forEach(result => {
                    const li = document.createElement('li');
                    li.textContent = result.formatted;
                    li.className = 'px-4 py-2 cursor-pointer hover:bg-gray-100';
                    li.addEventListener('click', () => {
                        input.value = result.formatted;
                        suggestions.classList.add('hidden');
                        callback(result.geometry.lng, result.geometry.lat);
                    });
                    suggestions.appendChild(li);
                });

                suggestions.classList.remove('hidden');
            });
        }

        mapboxgl.accessToken = 'pk.eyJ1Ijoibmlra29wZWNvIiwiYSI6ImNtNHBrZzdmNDBzODkydHFzYnNjeXZuaWcifQ.bGsLtoqkkZPzkNdOy2cw9w'; //mapBox key
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [24.1052, 56.9496],
            zoom: 10
        });

        const markers = {};

        function addMarker(id, lng, lat) {
            if (markers[id]) markers[id].remove();
            markers[id] = new mapboxgl.Marker().setLngLat([lng, lat]).addTo(map);
            map.flyTo({ center: [lng, lat], essential: true });
        }

        attachOpenCageAutocomplete('location_one', 'location_one_suggestions', (lng, lat) => {
            fromCoords = [lng, lat];
            addMarker('from', lng, lat);
            drawRoute();
        });

        attachOpenCageAutocomplete('city_one', 'city_one_suggestions', (lng, lat) => {
            toCoords = [lng, lat];
            addMarker('to', lng, lat);
            drawRoute();
        });

        function drawRoute() {
            if (!fromCoords || !toCoords) return;
            fetch(`https://api.mapbox.com/directions/v5/mapbox/driving/${fromCoords[0]},${fromCoords[1]};${toCoords[0]},${toCoords[1]}?geometries=geojson&access_token=${mapboxgl.accessToken}`)
                .then(res => res.json())
                .then(data => {
                    const route = data.routes[0].geometry;
                    const distance = (data.routes[0].distance / 1000).toFixed(2);
                    const duration = (data.routes[0].duration / 3600).toFixed(2);

                    document.getElementById('hidden-distance').value = distance;
                    document.getElementById('hidden-time').value = duration;

                    if (map.getSource('route')) {
                        map.getSource('route').setData({ type: 'Feature', geometry: route });
                    } else {
                        map.addSource('route', { type: 'geojson', data: { type: 'Feature', geometry: route } });
                        map.addLayer({
                            id: 'route',
                            type: 'line',
                            source: 'route',
                            paint: { 'line-color': '#ff6b6b', 'line-width': 5 }
                        });
                    }
                });
        }
    </script>
</x-app-layout>
