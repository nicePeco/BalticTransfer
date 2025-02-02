<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg space-y-8">
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Car Information') }}</h3>
            <form action="{{ route('driver.update') }}" method="post">
                @csrf
                @method('patch')

                <div class="space-y-6">
                    <div>
                        <x-input-label for="car_make" :value="__('Car Make')" />
                        <x-text-input id="car_make" name="car_make" type="text" class="mt-1 block w-full" 
                            :value="old('car_make', $driver->car_make ?? '')" autofocus />
                        <x-input-error :messages="$errors->get('car_make')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="car_model" :value="__('Car Model')" />
                        <x-text-input id="car_model" name="car_model" type="text" class="mt-1 block w-full" 
                            :value="old('car_model', $driver->car_model ?? '')" />
                        <x-input-error :messages="$errors->get('car_model')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="car_year" :value="__('Car Year')" />
                        <x-text-input id="car_year" name="car_year" type="number" class="mt-1 block w-full" 
                            :value="old('car_year', $driver->car_year ?? '')" />
                        <x-input-error :messages="$errors->get('car_year')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="license_plate" :value="__('License Plate')" />
                        <x-text-input id="license_plate" name="license_plate" type="text" class="mt-1 block w-full" 
                            :value="old('license_plate', $driver->license_plate ?? '')" />
                        <x-input-error :messages="$errors->get('license_plate')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-primary-button>
                        {{ __('Save Car Information') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Main Car Photo') }}</h3>
            <form action="{{ route('driver.updateMainPhoto') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="space-y-6">
                    @if (Auth::user()->driver->car_photo)
                        <img src="{{ asset('storage/' . Auth::user()->driver->car_photo) }}" alt="Main Car Photo" class="mt-4 w-32 h-32 object-cover rounded">
                    @else
                        <p class="text-gray-400">No main car photo uploaded.</p>
                    @endif

                    <div>
                        <x-input-label for="main_car_photo" :value="__('Upload Main Car Photo')" />
                        <input id="main_car_photo" name="main_car_photo" type="file" class="mt-1 block w-full">
                        <x-input-error :messages="$errors->get('main_car_photo')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-primary-button>
                            {{ __('Update Main Photo') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Car Photos') }}</h3>
            <form action="{{ route('driver.updatePhotos') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="space-y-6">
                    <div>
                        <x-input-label for="car_photos" :value="__('Upload Car Photos (Max 10)')" />
                        <input id="car_photos" name="car_photos[]" type="file" class="mt-1 block w-full" multiple accept="image/*">
                        <x-input-error :messages="$errors->get('car_photos')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-primary-button>
                            {{ __('Upload Photos') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
        @if($driver->carPhotos->count() > 0)
            <h3 class="text-lg font-bold mt-4 text-white">Uploaded Car Photos</h3>
            <div class="grid grid-cols-3 gap-4">
                @foreach($driver->carPhotos as $photo)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-full h-32 object-cover rounded">
                        <form action="{{ route('driver.deletePhoto', $photo->id) }}" method="POST" class="absolute top-0 right-0">
                            @csrf
                            @method('delete')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 text-xs rounded">X</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
