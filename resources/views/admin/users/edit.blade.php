<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-8">{{ __('Edit User') }}</h1>

        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" class="w-full mt-1 p-2 border border-gray-300 rounded">
            </div>
            <div>
                <label for="email" class="block text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" class="w-full mt-1 p-2 border border-gray-300 rounded">
            </div>
            <div>
                <label for="role" class="block text-gray-700 dark:text-gray-300">{{ __('Role') }}</label>
                <select id="role" name="role" class="w-full mt-1 p-2 border border-gray-300 rounded">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="driver" {{ $user->role == 'driver' ? 'selected' : '' }}>Driver</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">{{ __('Update User') }}</button>
            </div>
        </form>
    </div>
</x-app-layout>
