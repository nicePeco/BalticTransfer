<x-app-layout>
    <div class="max-w-7xl mx-auto py-8">
        <h2 class="text-3xl font-bold mb-6">Driver Verification Requests</h2>

        @if($drivers->isEmpty())
            <p class="text-red-500">No pending verifications found.</p>
        @endif

        @foreach($drivers as $driver)
            <div class="bg-white p-6 rounded-lg shadow-md mb-4">
                <p><strong>Driver ID:</strong> {{ $driver->id }}</p>
                <p><strong>Driver Name:</strong> {{ $driver->name }}</p>
                <p><strong>Email:</strong> {{ $driver->email }}</p>
                <p><strong>Car:</strong> {{ $driver->car_make }} {{ $driver->car_model }} ({{ $driver->car_year }})</p>
                <p><strong>License Plate:</strong> {{ $driver->license_plate }}</p>

                <!-- Driver's License Photos -->
                <div class="flex space-x-4 mt-4">
                    @if($driver->license_front)
                        <div>
                            <img src="{{ asset('storage/' . $driver->license_front) }}" class="w-32 h-32 object-cover rounded">
                            <a href="{{ route('admin.download-license', ['type' => 'front', 'id' => $driver->id]) }}" 
                               class="block bg-blue-500 text-white text-center px-4 py-2 rounded mt-2 hover:bg-blue-600">
                                Download Front
                            </a>
                        </div>
                    @endif

                    @if($driver->license_back)
                        <div>
                            <img src="{{ asset('storage/' . $driver->license_back) }}" class="w-32 h-32 object-cover rounded">
                            <a href="{{ route('admin.download-license', ['type' => 'back', 'id' => $driver->id]) }}" 
                               class="block bg-blue-500 text-white text-center px-4 py-2 rounded mt-2 hover:bg-blue-600">
                                Download Back
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Main Car Photo -->
                @if($driver->car_photo)
                    <h3 class="text-lg font-bold mt-6">Main Car Photo</h3>
                    <div>
                        <img src="{{ asset('storage/' . $driver->car_photo) }}" class="w-32 h-32 object-cover rounded">
                        <a href="{{ route('admin.download-car-photo', ['id' => $driver->id]) }}" 
                           class="block bg-blue-500 text-white text-center px-4 py-2 rounded mt-2 hover:bg-blue-600">
                            Download Main Car Photo
                        </a>
                    </div>
                @endif

                <!-- Multiple Car Photos -->
                @if($driver->carPhotos->count() > 0)
                    <h3 class="text-lg font-bold mt-6">Car Photos</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($driver->carPhotos as $photo)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-32 h-32 object-cover rounded">
                                <a href="{{ route('admin.download-car-photo', $photo->id) }}" 
                                   class="block bg-blue-500 text-white text-center px-4 py-2 rounded mt-2 hover:bg-blue-600">
                                    Download
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Verification Actions -->
                <form method="POST" action="{{ route('admin.driver-verification.update', $driver->id) }}" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.driver-verification.update', $driver->id) }}" class="mt-2">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <textarea name="admin_notes" placeholder="Reason for rejection" class="w-full border p-2 rounded mt-2"></textarea>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mt-2">Reject</button>
                </form>
            </div>
        @endforeach
    </div>
</x-app-layout>
