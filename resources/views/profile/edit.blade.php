<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            <span class="font-medium">{{ __('Your Rating:') }}</span>
            <span class="text-gray-800 dark:text-gray-200">
                {{ Auth::user()->rating ? number_format(Auth::user()->rating, 1) : 'Not Rated Yet' }}
            </span>
            <span class="ml-4 font-medium">{{ __('Total Ratings:') }}</span>
            <span class="text-gray-800 dark:text-gray-200">
                {{ Auth::user()->rating_count }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl flex flex-row sm:px-6 lg:px-8">
                    <h1 class="text-gray-200 mx-2">Update profile picture</h1>
                    <x-nav-link :href="route('profile.photo')" :active="request()->routeIs('profile.photo')">
                        @lang('Update')
                    </x-nav-link>
                </div>
            </div>
            @if (Auth::user()->driver)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Car Information') }}</h3>
                    <ul class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        <li><strong>Make:</strong> {{ Auth::user()->driver->car_make }}</li>
                        <li><strong>Model:</strong> {{ Auth::user()->driver->car_model }}</li>
                        <li><strong>Year:</strong> {{ Auth::user()->driver->car_year }}</li>
                        @if (Auth::user()->driver->car_photo)
                            <li>
                                <img src="{{ asset('storage/' . Auth::user()->driver->car_photo) }}" alt="Car Photo" class="mt-4 w-32 h-32 object-cover rounded">
                            </li>
                        @endif
                    </ul>
            @endif
            @if (Auth::user()->hasRole('driver'))
                    <div class="max-w-xl flex flex-row sm:px-6 lg:px-8">
                        <h1 class="text-gray-200 mx-2">Update Car Information</h1>
                        <x-nav-link :href="route('driver.edit')" :active="request()->routeIs('driver.edit')">
                            @lang('Edit Car Information')
                        </x-nav-link>
                    </div>
                </div>
            @endif
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
