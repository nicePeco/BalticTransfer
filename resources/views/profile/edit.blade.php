<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
        @if (!Auth::user()->driver)
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
        @endif
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
                @if(auth()->user()->driver && auth()->user()->driver->verification_status !== 'approved')
                    <div class="p-4 sm:p-8 bg-red-100/20 dark:bg-red-900/40 backdrop-blur-md border border-red-400 dark:border-red-600 shadow sm:rounded-lg">
                        <div class="max-w-xl flex flex-row items-center justify-between sm:px-6 lg:px-8">
                            <h1 class="text-gray-800 dark:text-gray-200 font-semibold text-lg">
                                Verify Yourself
                            </h1>
                            <x-nav-link :href="route('driver.verify')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                @lang('Update')
                            </x-nav-link>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            Your account is currently <strong class="text-yellow-500">{{ auth()->user()->driver->verification_status }}</strong>. 
                            Please update your drivers license. If you have done this, than wait and we will confirm you as soon as possible.
                        </p>
                    </div>
                @endif
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
