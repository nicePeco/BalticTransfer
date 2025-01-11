<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('profile.photo') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 bg-gray-800 sm:rounded-lg p-4 sm:p-8">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="profile_photo">Upload profile picture</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="profile_photo" id="profile_photo">
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    {{ __('Save') }}
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
