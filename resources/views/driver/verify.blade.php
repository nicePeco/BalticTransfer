<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Submit Your Driving License</h2>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('driver.verify.submit') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Upload Front Side of Driver's License</label>
                <input type="file" name="license_front" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Upload Back Side of Driver's License</label>
                <input type="file" name="license_back" class="w-full border p-2 rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600">
                Submit for Review
            </button>
        </form>
    </div>
</x-app-layout>
