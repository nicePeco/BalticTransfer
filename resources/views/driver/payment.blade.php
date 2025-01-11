<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-12 flex flex-col items-center">
        <div class="relative w-full max-w-2xl mx-auto">
            <div class="bg-white shadow-lg sm:rounded-3xl px-8 py-12">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-800">Weekly Payment Summary</h1>
                    <p class="text-gray-500 mt-2">Earnings summary for the current week.</p>
                </div>

                <div class="mt-8 bg-gray-100 p-6 rounded-lg shadow-md">
                    <ul class="text-gray-700 text-lg space-y-4">
                        <li>
                            <strong>Total Earnings This Week:</strong>
                            €{{ number_format($totalEarnings, 2) }}
                        </li>
                        <li>
                            <strong>Company Share This Week:</strong>
                            €{{ number_format($totalCompanyShare, 2) }}
                        </li>
                    </ul>
                </div>

                <div class="mt-8 bg-gray-100 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detailed Payments</h2>
                    <ul class="text-gray-700 text-md space-y-4">
                        @foreach ($payments as $payment)
                            <li>
                                <strong>Date:</strong> {{ $payment->created_at->format('F j, Y') }} <br>
                                <strong>Earnings:</strong> €{{ number_format($payment->total_earnings, 2) }} <br>
                                <strong>Company Share:</strong> €{{ number_format($payment->company_share, 2) }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('driver.dashboard') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-bold text-lg shadow-md transition-all">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
