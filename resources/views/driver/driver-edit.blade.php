<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <form action="{{ route('driver.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Car Information') }}</h3>

                <!-- car make -->
                <div>
                    <x-input-label for="car_make" :value="__('Car Make')" />
                    <x-text-input id="car_make" name="car_make" type="text" class="mt-1 block w-full" :value="old('car_make', $driver->car_make ?? '')" autofocus />
                    <x-input-error :messages="$errors->get('car_make')" class="mt-2" />
                </div>

                <!-- car model -->
                <div>
                    <x-input-label for="car_model" :value="__('Car Model')" />
                    <x-text-input id="car_model" name="car_model" type="text" class="mt-1 block w-full" :value="old('car_model', $driver->car_model ?? '')" />
                    <x-input-error :messages="$errors->get('car_model')" class="mt-2" />
                </div>

                <!-- car year -->
                <div>
                    <x-input-label for="car_year" :value="__('Car Year')" />
                    <x-text-input id="car_year" name="car_year" type="number" class="mt-1 block w-full" :value="old('car_year', $driver->car_year ?? '')" />
                    <x-input-error :messages="$errors->get('car_year')" class="mt-2" />
                </div>

                <!-- car photo -->
                <div>
                    <x-input-label for="car_photo" :value="__('Car Photo')" />
                    <input id="car_photo" name="car_photo" type="file" class="mt-1 block w-full">
                    <x-input-error :messages="$errors->get('car_photo')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-primary-button>
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
