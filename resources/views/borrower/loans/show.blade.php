<x-borrower-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loan Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-primary-50 via-white to-primary-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Success/TX Hash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                    <p class="text-green-700">{{ session('success') }}</p>
                    @if(session('tx_hash'))
                        <p class="text-xs text-green-600 font-mono mt-2">TX: {{ session('tx_hash') }}</p>
                    @endif
                </div>
            @endif

            {{-- Loan Header Card --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Loan #{{ $loan->id }}</h1>
                        <p class="text-gray-500 text-sm">Applied: {{ $loan->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    <span class="px-4 py-2 text-sm font-bold rounded-full
                        @if($loan->status === 'completed') bg-green-100 text-green-800
                        @elseif($loan->status === 'disbursed') bg-blue-100 text-blue-800
                        @elseif($loan->status === 'approved') bg-yellow-100 text-yellow-800
                        @elseif($loan->status === 'pending') bg-gray-100 text-gray-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($loan->status) }}
                    </span>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-500 mb-1">Loan Amount</p>
                        <p class="text-2xl font-bold text-gray-900">RM {{ number_format($loan->amount, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-500 mb-1">Remaining Balance</p>
                        <p
                            class="text-2xl font-bold {{ $loan->remaining_balance > 0 ? 'text-primary-600' : 'text-green-600' }}">
                            RM {{ number_format($loan->remaining_balance, 2) }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-500 mb-1">Duration</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $loan->duration_months }} months</p>
                    </div>
                </div>

                @if(in_array($loan->status, ['disbursed', 'completed']))
                    {{-- Dynamic Progress UI --}}
                    @php
                        $totalAmount = (float) $loan->amount;
                        $remainingAmount = (float) $loan->remaining_balance;
                        $paidAmount = $totalAmount - $remainingAmount;
                        $percentage = $loan->progress_percentage;
                        $isCompleted = $loan->status === 'completed' || $remainingAmount <= 0;
                    @endphp

                    <div
                        class="mt-8 flex flex-col md:flex-row items-center gap-8 bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <div x-data="{ 
                                    percent: 0,
                                    radius: 50,
                                    get circumference() { return 2 * Math.PI * this.radius },
                                    init() {
                                        setTimeout(() => { this.percent = {{ $isCompleted ? 100 : $percentage }}; }, 100);
                                    }
                                }" class="relative inline-flex items-center justify-center w-32 h-32">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 128 128">
                                <defs>
                                    <linearGradient id="showPinkGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="{{ $isCompleted ? '#10B981' : '#F472B6' }}" />
                                        <stop offset="100%" stop-color="{{ $isCompleted ? '#059669' : '#DB2777' }}" />
                                    </linearGradient>
                                </defs>
                                <circle cx="64" cy="64" :r="radius" stroke="currentColor" stroke-width="10"
                                    fill="transparent" class="text-slate-200" />
                                <circle cx="64" cy="64" :r="radius" stroke="url(#showPinkGradient)" stroke-width="10"
                                    fill="transparent" stroke-linecap="round" class="transition-all duration-1000 ease-out"
                                    :stroke-dasharray="circumference"
                                    :stroke-dashoffset="circumference - (circumference * percent / 100)" />
                            </svg>
                            <span class="absolute text-2xl font-black text-slate-800"
                                x-text="Math.round(percent) + '%'">0%</span>
                        </div>

                        <div class="flex-1 space-y-4">
                            <div>
                                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Repayment
                                    Progress</h4>
                                <p class="text-2xl font-black text-slate-900">
                                    Paid: RM {{ number_format($paidAmount, 2) }} <span class="text-slate-300 font-normal">/
                                        RM {{ number_format($totalAmount, 2) }}</span>
                                </p>
                            </div>

                            <div class="flex gap-4">
                                <div class="flex-1 bg-white p-3 rounded-xl border border-slate-100">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Principal</p>
                                    <p class="font-bold text-slate-700">RM {{ number_format($totalAmount, 2) }}</p>
                                </div>
                                <div class="flex-1 bg-white p-3 rounded-xl border border-slate-100">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Remaining</p>
                                    <p class="font-bold text-pink-600">RM {{ number_format($remainingAmount, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Loan Details --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Loan Information</h3>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Purpose</p>
                        <p class="text-gray-900">{{ $loan->purpose }}</p>
                    </div>
                    @if($loan->due_date)
                        <div>
                            <p class="text-sm text-gray-500">Due Date</p>
                            <p class="text-gray-900 {{ $loan->isOverdue() ? 'text-red-600 font-semibold' : '' }}">
                                {{ $loan->due_date->format('d M Y') }}
                                @if($loan->isOverdue())
                                    <span class="text-xs text-red-600 ml-2">(OVERDUE)</span>
                                @endif
                            </p>
                        </div>
                    @endif
                    @if($loan->disbursed_at)
                        <div>
                            <p class="text-sm text-gray-500">Disbursed Date</p>
                            <p class="text-gray-900">{{ $loan->disbursed_at->format('d M Y, h:i A') }}</p>
                        </div>
                    @endif
                    @if($loan->contract_address)
                        <div>
                            <p class="text-sm text-gray-500">Smart Contract</p>
                            <p class="text-gray-900 font-mono text-xs break-all">{{ $loan->contract_address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Wallet Info --}}
            @if($loan->wallet)
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Linked Wallet</h3>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-mono text-sm text-gray-900 break-all">{{ $loan->wallet->wallet_address }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', $loan->wallet->type) }}
                                Wallet</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Repayment History --}}
            @if($loan->repayments->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Repayment History</h3>
                    <div class="space-y-3">
                        @foreach($loan->repayments as $repayment)
                            <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
                                <div>
                                    <p class="font-semibold text-gray-900">RM {{ number_format($repayment->amount, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $repayment->paid_at->format('d M Y, h:i A') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 font-mono">{{ Str::limit($repayment->tx_hash, 20) }}</p>
                                    <p class="text-xs text-gray-400">Block #{{ $repayment->block_number }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('borrower.loans.index') }}"
                    class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-colors">
                    ← Back to Loans
                </a>
                @if($loan->status === 'disbursed' && $loan->remaining_balance > 0)
                    <a href="{{ route('borrower.loans.repay', $loan) }}"
                        class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-colors">
                        Make a Payment
                    </a>
                @endif
            </div>

        </div>
    </div>
</x-borrower-layout>