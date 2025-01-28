<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
        @livewire('dynamic-content')
            @if(Auth::user()->profile_photo)
                <img class="rounded-full border-2 border-gray-300 dark:border-gray-600" 
                    src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                    alt="profile_image" 
                    style="width: 70px; height: 70px; padding: 5px;">
            @else
                <!-- default image-->
                <img class="rounded-full border-2 border-gray-300 dark:border-gray-600" 
                    src="{{ asset('https://usdeafsoccer.com/wp-content/uploads/2022/05/no-profile-pic.png') }}" 
                    alt="profile_image" 
                    style="width: 70px; height: 70px; padding: 5px;">
            @endif

            <!-- User Name -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __( Auth::user()->name ) }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12 bg-blue-100 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-gray-800 text-white shadow-lg rounded-lg">
                <p><strong>Driver Rating:</strong> {{ $driver->formattedRating }} ({{ $driver->rating_count }} reviews)</p>
                <h3 class="text-2xl font-bold mb-6">{{ __('Car Information') }}</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <!-- car info -->
                    <ul class="text-lg space-y-4">
                        <li><strong>Make:</strong> {{ $driver->car_make }}</li>
                        <li><strong>Model:</strong> {{ $driver->car_model }}</li>
                        <li><strong>Year:</strong> {{ $driver->car_year }}</li>
                    </ul>
                    <!-- car photo -->
                    @if ($driver->car_photo)
                        <img src="{{ asset('storage/' . $driver->car_photo) }}" alt="Car Photo" class="w-64 h-64 object-cover rounded-lg shadow-lg">
                    @endif
                </div>
            </div>

            <div class="mt-6 bg-gray-800 text-white shadow-lg rounded-lg p-6 flex justify-between items-center">
                <h3 class="text-lg font-semibold">{{ __('Update Car Information') }}</h3>
                <x-nav-link :href="route('driver.edit')" :active="request()->routeIs('driver.edit')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    @lang('Edit Car Information')
                </x-nav-link>
            </div>
        </div>
    </div>
</x-app-layout>