<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loan Review') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-primary-50 via-white to-primary-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                    <p class="text-green-700">{{ session('success') }}</p>
                    @if(session('contract_address'))
                        <p class="text-xs text-green-600 font-mono mt-2">Contract: {{ session('contract_address') }}</p>
                    @endif
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Loan Header --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Loan #{{ $loan->id }}</h1>
                        <p class="text-gray-500">Applied: {{ $loan->created_at->format('d M Y, h:i A') }}</p>
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

                <div class="grid md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Amount</p>
                        <p class="text-xl font-bold text-gray-900">RM {{ number_format($loan->amount, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Duration</p>
                        <p class="text-xl font-bold text-gray-900">{{ $loan->duration_months }} months</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Remaining</p>
                        <p class="text-xl font-bold text-primary-600">RM {{ number_format($loan->remaining_balance, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-500">Progress</p>
                        <p class="text-xl font-bold text-gray-900">{{ $loan->progress_percentage }}%</p>
                    </div>
                </div>
            </div>

            {{-- Tabbed Content --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ tab: 'personal' }">
                {{-- Tab Headers --}}
                <div class="bg-gray-50 border-b flex">
                    <button @click="tab = 'personal'" :class="tab === 'personal' ? 'bg-white border-b-2 border-primary-600 text-primary-600' : 'text-gray-600'" class="px-6 py-4 font-semibold transition-colors">
                        Personal
                    </button>
                    <button @click="tab = 'financing'" :class="tab === 'financing' ? 'bg-white border-b-2 border-primary-600 text-primary-600' : 'text-gray-600'" class="px-6 py-4 font-semibold transition-colors">
                        Financing
                    </button>
                    <button @click="tab = 'wallet'" :class="tab === 'wallet' ? 'bg-white border-b-2 border-primary-600 text-primary-600' : 'text-gray-600'" class="px-6 py-4 font-semibold transition-colors">
                        Wallet
                    </button>
                    @if($loan->repayments->count() > 0)
                        <button @click="tab = 'repayments'" :class="tab === 'repayments' ? 'bg-white border-b-2 border-primary-600 text-primary-600' : 'text-gray-600'" class="px-6 py-4 font-semibold transition-colors">
                            Repayments
                        </button>
                    @endif
                </div>

                <div class="p-6">
                    {{-- Personal Tab --}}
                    <div x-show="tab === 'personal'" x-transition>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Borrower Information</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="font-semibold text-gray-900">{{ $loan->borrower->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email Address</p>
                                <p class="font-semibold text-gray-900">{{ $loan->borrower->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Account Role</p>
                                <p class="font-semibold text-gray-900 capitalize">{{ $loan->borrower->role }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Member Since</p>
                                <p class="font-semibold text-gray-900">{{ $loan->borrower->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Financing Tab --}}
                    <div x-show="tab === 'financing'" x-transition x-cloak>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Financing Details</h3>
                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-500">Loan Amount</p>
                                <p class="font-semibold text-gray-900">RM {{ number_format($loan->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Duration</p>
                                <p class="font-semibold text-gray-900">{{ $loan->duration_months }} months</p>
                            </div>
                            @if($loan->due_date)
                                <div>
                                    <p class="text-sm text-gray-500">Due Date</p>
                                    <p class="font-semibold {{ $loan->isOverdue() ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $loan->due_date->format('d M Y') }}
                                        @if($loan->isOverdue()) (OVERDUE) @endif
                                    </p>
                                </div>
                            @endif
                            @if($loan->disbursed_at)
                                <div>
                                    <p class="text-sm text-gray-500">Disbursed On</p>
                                    <p class="font-semibold text-gray-900">{{ $loan->disbursed_at->format('d M Y, h:i A') }}</p>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Purpose</p>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-gray-900">{{ $loan->purpose }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Wallet Tab --}}
                    <div x-show="tab === 'wallet'" x-transition x-cloak>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Linked Wallet</h3>
                        @if($loan->wallet)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Wallet Address</p>
                                        <p class="font-mono text-sm text-gray-900 break-all">{{ $loan->wallet->wallet_address }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Type</p>
                                        <p class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $loan->wallet->type) }}</p>
                                    </div>
                                </div>
                            </div>
                            @if($loan->contract_address)
                                <div class="mt-4 bg-blue-50 rounded-xl p-4">
                                    <p class="text-sm text-blue-600 mb-1">Smart Contract Address</p>
                                    <p class="font-mono text-sm text-blue-900 break-all">{{ $loan->contract_address }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-gray-500">No wallet linked</p>
                        @endif
                    </div>

                    {{-- Repayments Tab --}}
                    <div x-show="tab === 'repayments'" x-transition x-cloak>
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
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-6 flex flex-wrap gap-4">
                <a href="{{ route('admin.loans.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-colors">
                    ← Back to List
                </a>

                @if($loan->status === 'pending')
                    <form method="POST" action="{{ route('admin.loans.approve', $loan) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors" onclick="return confirm('Approve this loan application?')">
                            ✓ Approve Loan
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.loans.reject', $loan) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors" onclick="return confirm('Reject this loan application?')">
                            ✗ Reject
                        </button>
                    </form>
                @endif

                @if($loan->status === 'approved')
                    <form method="POST" action="{{ route('admin.loans.disburse', $loan) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg" onclick="return confirm('Disburse this loan? This will trigger the blockchain simulation.')">
                            🚀 Disburse Loan
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
