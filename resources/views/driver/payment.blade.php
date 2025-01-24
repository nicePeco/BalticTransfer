<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-12 flex flex-col items-center">
        <div class="relative w-full max-w-2xl mx-auto">
            <div class="bg-white shadow-lg sm:rounded-3xl px-8 py-12">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-800">Payment Summary</h1>
                    <p class="text-gray-500 mt-2">Earnings summary for the current week, month, and year.</p>
                </div>

                {{-- Weekly Summary --}}
                <div class="mt-8 bg-gray-100 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Weekly Summary</h2>
                    <ul class="text-gray-700 text-lg space-y-4">
                        <li><strong>Total Earnings:</strong> €{{ number_format($totalEarningsWeekly, 2) }}</li>
                        <li><strong>Company Share:</strong> €{{ number_format($totalCompanyShareWeekly, 2) }}</li>
                    </ul>
                </div>

                {{-- Monthly Summary --}}
                <div class="mt-8 bg-gray-100 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Monthly Summary</h2>
                    <ul class="text-gray-700 text-lg space-y-4">
                        <li><strong>Total Earnings:</strong> €{{ number_format($totalEarningsMonthly, 2) }}</li>
                        <li><strong>Company Share:</strong> €{{ number_format($totalCompanyShareMonthly, 2) }}</li>
                    </ul>
                </div>

                {{-- Yearly Summary --}}
                <div class="mt-8 bg-gray-100 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Yearly Summary</h2>
                    <ul class="text-gray-700 text-lg space-y-4">
                        <li><strong>Total Earnings:</strong> €{{ number_format($totalEarningsYearly, 2) }}</li>
                        <li><strong>Company Share:</strong> €{{ number_format($totalCompanyShareYearly, 2) }}</li>
                    </ul>
                </div>

                {{-- Weekly Detailed Payments --}}
                <div class="mt-8 bg-gray-100 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detailed Weekly Payments</h2>
                    <ul class="text-gray-700 text-md space-y-4">
                        @foreach ($weeklyPayments as $payment)
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
