<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Make a Payment') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-primary-50 via-white to-primary-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            {{-- Loan Summary Card --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Loan #{{ $loan->id }}</h3>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        Disbursed
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Original Amount</p>
                        <p class="text-xl font-bold text-gray-900">RM {{ number_format($loan->amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Remaining Balance</p>
                        <p class="text-xl font-bold text-primary-600">RM
                            {{ number_format($loan->remaining_balance, 2) }}</p>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div>
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Repaid</span>
                        <span>{{ $loan->progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $loan->progress_percentage }}%">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Form --}}
            <form method="POST" action="{{ route('borrower.loans.repay.store', $loan) }}"
                class="bg-white rounded-2xl shadow-xl p-8">
                @csrf

                <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Enter Payment Amount</h3>

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="mb-6">
                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Amount (RM)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">RM</span>
                        <input type="number" name="amount" id="amount" min="1" max="{{ $loan->remaining_balance }}"
                            step="0.01" value="{{ old('amount', $loan->remaining_balance) }}"
                            class="w-full pl-14 pr-4 py-4 text-2xl font-bold border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('amount') border-red-500 @enderror"
                            required>
                    </div>
                    @error('amount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Maximum: RM {{ number_format($loan->remaining_balance, 2) }}
                    </p>
                </div>

                {{-- Quick Amount Buttons --}}
                <div class="grid grid-cols-3 gap-2 mb-6">
                    @php
                        $quickAmounts = [100, 500, 1000];
                    @endphp
                    @foreach($quickAmounts as $quickAmount)
                        @if($quickAmount <= $loan->remaining_balance)
                            <button type="button" onclick="document.getElementById('amount').value = {{ $quickAmount }}"
                                class="py-2 px-4 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                                RM {{ number_format($quickAmount) }}
                            </button>
                        @endif
                    @endforeach
                    <button type="button"
                        onclick="document.getElementById('amount').value = {{ $loan->remaining_balance }}"
                        class="py-2 px-4 bg-primary-100 text-primary-700 font-semibold rounded-lg hover:bg-primary-200 transition-colors col-span-3">
                        Pay Full Balance (RM {{ number_format($loan->remaining_balance, 2) }})
                    </button>
                </div>

                {{-- Info Box --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="ml-3 text-sm text-blue-700">
                            This payment will be recorded on the simulated blockchain. A transaction hash will be
                            generated for your records.
                        </p>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-primary-600 text-white font-bold py-4 px-6 rounded-xl hover:bg-primary-700 transition-all shadow-lg hover:shadow-xl">
                    Confirm Payment
                </button>
            </form>

            {{-- Back Link --}}
            <div class="mt-6 text-center">
                <a href="{{ route('borrower.loans.show', $loan) }}"
                    class="text-gray-600 hover:text-primary-600 transition-colors">
                    ← Back to Loan Details
                </a>
            </div>

        </div>
    </div>
</x-app-layout>