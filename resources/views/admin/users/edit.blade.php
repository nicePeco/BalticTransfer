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
        <!-- Suspend User Form -->
        <div class="mt-10">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">{{ __('Suspend User') }}</h2>
            <form action="{{ route('admin.users.suspend', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="duration" class="block text-gray-700 dark:text-gray-300">{{ __('Suspension Duration') }}</label>
                    <select id="duration" name="duration" class="w-full mt-1 p-2 border border-gray-300 rounded">
                        <option value="3_days">3 Days</option>
                        <option value="7_days">7 Days</option>
                        <option value="1_month">1 Month</option>
                        <option value="forever">Forever</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">{{ __('Suspend User') }}</button>
                </div>
            </form>
        </div>

        <!-- Unsuspend User Form -->
        @if($user->suspended_until)
        <div class="mt-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">{{ __('Unsuspend User') }}</h2>
            <form action="{{ route('admin.users.unsuspend', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">{{ __('Unsuspend User') }}</button>
            </form>
        </div>
        @endif
    </div>
</x-app-layout>
