<x-app-layout>
    <div class="px-4 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-gray-200 text-center mb-8">{{ __('Admin Dashboard') }}</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold">Total Users</h2>
                <p class="text-3xl font-bold mt-2">{{ $totalUsers }}</p>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold">Total Drivers</h2>
                <p class="text-3xl font-bold mt-2">{{ $totalDrivers }}</p>
            </div>
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold">Total Rides</h2>
                <p class="text-3xl font-bold mt-2">{{ $totalRides }}</p>
            </div>
        </div>
        <div class="mt-10">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center">{{ __('Quick Actions') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('admin.users') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Manage Users</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">View and edit user accounts</p>
                </a>
                <a href="{{ route('admin.drivers') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Manage Drivers</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">View and manage drivers</p>
                </a>
                <a href="{{ route('admin.rides') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Manage Rides</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Track and update ride details</p>
                </a>
                <a href="{{ route('admin.messages') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">All messages</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Messages</p>
                </a>
                <a href="{{ route('admin.driver-verifications') }}" class="block bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">New drivers</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Verify</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

