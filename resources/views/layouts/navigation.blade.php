<nav x-data="{ open: false }" class="bg-sky-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <!-- <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                    </a>
                </div> -->

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @hasrole('driver')
                        {{-- Lietotājs ir drivers --}}
                    <x-nav-link :href="route('driver.dashboard')" :active="request()->routeIs('driver.dashboard')">
                        {{ __('Drivers profile') }}
                    </x-nav-link>
                    @else
                        {{-- Lietotājs nav drivers --}}
                    <x-nav-link :href="route('home.index')" :active="request()->routeIs('home.index')">
                        {{ __('Home') }}
                    </x-nav-link>
                    @endhasrole
                    @hasrole('driver')
                        {{-- Lietotājs ir drivers --}}
                    @else
                    <x-nav-link :href="route('offers.test')" :active="request()->routeIs('offers.test')">
                        {{ __('Request a ride') }}
                    </x-nav-link>
                    @endhasrole
                    @hasrole('driver')
                        {{-- Lietotājs ir drivers --}}
                        <x-nav-link :href="route('client.index')" :active="request()->routeIs('client.index')">
                        {{ __('Available rides') }}
                        </x-nav-link>
                    @else
                    <x-nav-link :href="route('client.index')" :active="request()->routeIs('client.index')">
                        {{ __('Your rides') }}
                    </x-nav-link>
                    @endhasrole
                    @hasrole('driver')
                        {{-- Lietotājs ir drivers --}}
                    <x-nav-link :href="route('driver.applications')" :active="request()->routeIs('driver.applications')">
                        {{ __('My applications') }}
                    </x-nav-link>
                    @endhasrole
                    <x-nav-link :href="route('offers.history')" :active="request()->routeIs('offers.history')">
                        {{ __('Ride history') }}
                    </x-nav-link>
                    @hasrole('driver')
                        {{-- Lietotājs ir drivers --}}
                    <x-nav-link :href="route('driver.payment')" :active="request()->routeIs('driver.payment')">
                        {{ __('My earnings') }}
                    </x-nav-link>
                    @endhasrole
                    @hasrole('admin')
                    {{-- Lietotājs ir drivers --}}
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('ADMIN') }}
                    </x-nav-link>
                    @endhasrole
                    @php
                        $ongoingOffer = App\Models\offers::where('status', 'ongoing')
                            ->where(function($query) {
                                $query->where('offers_id', Auth::id())
                                    ->orWhereHas('rides', function($subQuery) {
                                        $subQuery->where('driver_id', Auth::user()->driver->id ?? null);
                                    });
                            })
                            ->first();
                    @endphp

                    @if($ongoingOffer)
                        {{-- Show Ongoing Offer --}}
                        <x-nav-link :href="route('offers.ongoing', ['offerId' => $ongoingOffer->id])" :active="request()->routeIs('offers.ongoing')" class="bg-green-700 hover:bg-green-600 text-white text-sm font-semibold py-1 px-3 rounded shadow-md transition-all duration-300 ease-in-out">
                            {{ __('Ongoing Ride') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- notifiaction meginajums -->
                @include('layouts.notifications')

                @if(Auth::user()->profile_photo)
                    <img class="image rounded-full" src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="profile_image" style="width: 50px; height: 50px; padding: 5px; margin-right: 10px;">
                @else
                    <!-- default profile image-->
                    <img class="image rounded-full" src="{{ asset('https://usdeafsoccer.com/wp-content/uploads/2022/05/no-profile-pic.png') }}" alt="profile_image" style="width: 50px; height: 50px; padding: 5px; margin-right: 10px;">
                @endif
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-sky-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('messages.user')">
                            {{ __('Message us') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function fetchNotifications() {
                fetch('{{ route("notifications.index") }}')
                    .then(response => response.json())
                    .then(data => {
                        console.log("Fetched Notifications: ", data);
                    });
            }

            fetchNotifications();
            setInterval(fetchNotifications, 10000);
        });
    </script>
</nav>
