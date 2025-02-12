<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50 bg-cover bg-no-repeat bg-fixed min-h-screen flex flex-col" style="background-image: url('{{ asset('images/baltic.webp') }}')">
    <header class="py-6 bg-gradient-to-b from-black/70 via-black/40 to-transparent fixed w-full z-50">
        @if (Route::has('login'))
            <nav class="max-w-7xl mx-auto px-6 flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-white hover:text-gray-300 transition">
                    {{ __('Baltsfer') }}
                </a>
                <div class="space-x-1">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                            {{ __('Home') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                            {{ __('Log In') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-white bg-green-600 hover:bg-green-700 transition">
                                {{ __('Register') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        @endif
    </header>
    <main class="flex-1 flex items-center justify-center pt-20">
        <div class="text-center space-y-6 max-w-2xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold text-white drop-shadow-[0_4px_34px_rgba(0,0,0,0.25)]">
                {{ __('Need a Comfortable Ride in the Baltics?') }}
            </h1>
            <p class="w-full md:w-auto px-6 py-3 text-lg font-semibold bg-black/80 rounded-lg shadow-lg text-gray-400 text-center">Experience the best rides with Baltsfer - your reliable travel partner in the Baltic region.</p>
            <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-6 justify-center">
                <a href="{{ route('register') }}"
                class="w-full md:w-auto px-6 py-3 text-lg font-semibold text-black bg-yellow-400 rounded-full shadow-lg hover:bg-yellow-500 transition text-center">
                    {{ __('Get One Now!') }}
                </a>
            </div>
        </div>
    </main>
    <section class="py-16 text-white text-center">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8">
            <div class="p-6 bg-gray-900 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-3">Reliable & Safe</h3>
                <p class="text-gray-400">All our drivers are vetted and trained for your safety and comfort.</p>
            </div>
            <div class="p-6 bg-gray-900 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-3">Affordable Rides</h3>
                <p class="text-gray-400">We offer the best prices for long and short trips across the Baltics.</p>
            </div>
            <div class="p-6 bg-gray-900 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-3">Easy Booking</h3>
                <p class="text-gray-400">Book your ride in just a few clicks, hassle-free and convenient.</p>
            </div>
        </div>
    </section>
    <section class="py-16 bg-black/60 text-white text-center">
        <h2 class="text-3xl font-bold mb-6">What Our Riders Say</h2>
        <div class="max-w-4xl mx-auto px-6">
            <div class="p-6 bg-black rounded-lg shadow-lg mb-6">
                <p class="text-gray-300 italic">"Baltsfer made my trip seamless and comfortable! Highly recommended."</p>
                <span class="block mt-3 text-gray-400">- Anna M.</span>
            </div>
            <div class="p-6 bg-black rounded-lg shadow-lg">
                <p class="text-gray-300 italic">"A great service with professional drivers. Will use again!"</p>
                <span class="block mt-3 text-gray-400">- Robert K.</span>
            </div>
        </div>
    </section>
    <section class="py-12 bg-black/60 text-white text-center">
        <h2 class="text-3xl font-bold mb-4">Join Baltsfer Today!</h2>
        <p class="text-lg mb-6">Become a driver and be part of our growing community.</p>
        <a href="{{ route('register.driver.form') }}" class="px-6 py-3 bg-black text-white rounded-full text-lg font-semibold hover:bg-gray-800 transition">Sign Up as a Driver Now</a>
    </section>
    <footer class="py-6 bg-black text-center text-gray-400 text-sm">
        <p>&copy; {{ now()->year }} Baltsfer. {{ __('All rights reserved.') }}</p>
        <div class="mt-4">
            <a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a> | 
            <a href="{{ route('terms') }}" class="hover:text-white transition">Terms of Service</a> | 
            <a href="{{ route('contact') }}" class="hover:text-white transition">About Us</a>
        </div>
    </footer>
</body>
</html>
