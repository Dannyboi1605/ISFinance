<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Borrower Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-primary-50 via-white to-primary-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Section --}}
            <div class="text-center mb-10 animate-fadeInUp">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    Welcome back, <span class="text-primary-600">{{ auth()->user()->name }}</span>
                </h1>
                <p class="text-gray-600">Here's your financial overview</p>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Summary Cards --}}
            <div class="grid md:grid-cols-3 gap-6 mb-10">

                {{-- Total Active Debt --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-primary-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Active Debt</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                RM {{ number_format($eligibility['total_debt'] ?? 0, 2) }}
                            </p>
                        </div>
                        <div class="bg-primary-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">From {{ $eligibility['active_loan_count'] ?? 0 }} active
                        loan(s)</p>
                </div>

                {{-- Available Credit --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Available Credit</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                RM {{ number_format($eligibility['available_credit'] ?? 10000, 2) }}
                            </p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Maximum limit: RM 10,000</p>
                </div>

                {{-- Next Payment Due --}}
                <div
                    class="bg-white rounded-2xl shadow-lg p-6 border-l-4 {{ $nextPayment && $nextPayment['is_overdue'] ? 'border-red-600' : 'border-blue-600' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Next Payment</p>
                            @if($nextPayment)
                                <p class="text-3xl font-bold text-gray-900 mt-1">
                                    {{ $nextPayment['due_date']->format('d M Y') }}
                                </p>
                            @else
                                <p class="text-xl font-bold text-gray-400 mt-1">No active loans</p>
                            @endif
                        </div>
                        <div
                            class="{{ $nextPayment && $nextPayment['is_overdue'] ? 'bg-red-100' : 'bg-blue-100' }} p-4 rounded-full">
                            <svg class="w-8 h-8 {{ $nextPayment && $nextPayment['is_overdue'] ? 'text-red-600' : 'text-blue-600' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    @if($nextPayment && $nextPayment['is_overdue'])
                        <p class="text-xs text-red-600 font-semibold mt-3">⚠️ OVERDUE - Please pay immediately</p>
                    @elseif($nextPayment)
                        <p class="text-xs text-gray-500 mt-3">Balance: RM {{ number_format($nextPayment['amount'], 2) }}</p>
                    @endif
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-4 justify-center mb-10">
                @if(auth()->user()->hasWallet())
                    @if($eligibility['can_apply'])
                        <a href="{{ route('borrower.loans.create') }}"
                            class="inline-flex items-center px-8 py-4 bg-primary-600 text-white font-bold rounded-xl shadow-lg hover:bg-primary-700 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Apply for New Loan
                        </a>
                    @else
                        <div
                            class="inline-flex items-center px-8 py-4 bg-gray-300 text-gray-500 font-bold rounded-xl cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Cannot Apply
                        </div>
                    @endif
                @else
                    <a href="{{ route('borrower.wallet.setup') }}"
                        class="inline-flex items-center px-8 py-4 bg-primary-600 text-white font-bold rounded-xl shadow-lg hover:bg-primary-700 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        Set Up Wallet First
                    </a>
                @endif

                <a href="{{ route('borrower.loans.index') }}"
                    class="inline-flex items-center px-8 py-4 bg-white text-primary-600 font-bold rounded-xl shadow-md border-2 border-primary-600 hover:bg-primary-50 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    View All Loans
                </a>
            </div>

            {{-- Eligibility Warnings --}}
            @if(!$eligibility['can_apply'] && auth()->user()->hasWallet())
                <div class="mb-8 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-semibold">Unable to Apply for New Loan</p>
                            <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                @foreach($eligibility['reasons'] as $reason)
                                    <li>{{ $reason }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Active Loans Grid --}}
            @if($loans->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Your Loans</h3>
                        <a href="{{ route('borrower.loans.index') }}"
                            class="text-primary-600 hover:text-primary-700 font-semibold text-sm">
                            View All →
                        </a>
                    </div>

                    <div class="space-y-4">
                        @foreach($loans as $loan)
                            <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <span class="text-sm font-semibold text-gray-900">Loan #{{ $loan->id }}</span>
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full
                                                    @if($loan->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($loan->status === 'disbursed') bg-blue-100 text-blue-800
                                                    @elseif($loan->status === 'approved') bg-yellow-100 text-yellow-800
                                                    @elseif($loan->status === 'pending') bg-gray-100 text-gray-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </div>
                                    <span class="text-lg font-bold text-gray-900">RM
                                        {{ number_format($loan->amount, 2) }}</span>
                                </div>

                                @if($loan->status === 'disbursed' || $loan->status === 'completed')
                                    {{-- Progress Bar --}}
                                    <div class="mb-2">
                                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                                            <span>Repayment Progress</span>
                                            <span>{{ $loan->progress_percentage }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary-600 h-2 rounded-full transition-all duration-500"
                                                style="width: {{ $loan->progress_percentage }}%"></div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500">
                                        <span>Remaining: RM {{ number_format($loan->remaining_balance, 2) }}</span>
                                        @if($loan->due_date)
                                            <span>Due: {{ $loan->due_date->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <a href="{{ route('borrower.loans.show', $loan) }}"
                                        class="text-primary-600 hover:text-primary-700 text-sm font-semibold">
                                        View Details →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Loans Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't applied for any loans. Start your journey with ISFinance
                        today!</p>
                    @if(auth()->user()->hasWallet() && $eligibility['can_apply'])
                        <a href="{{ route('borrower.loans.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                            Apply for Your First Loan
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>