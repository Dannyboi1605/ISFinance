<x-borrower-layout>
    <x-slot name="header">
        Make a Payment
    </x-slot>

    <div class="max-w-2xl mx-auto" x-data="{ repayAmount: '{{ old('amount', $loan->remaining_balance) }}' }">

        {{-- Progress Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-display font-bold text-slate-900">Authorize Repayment</h1>
            <p class="text-slate-500 mt-2 font-medium">Safe & Secure Blockchain Transaction</p>
        </div>

        {{-- Loan Overview Card --}}
        <div
            class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden mb-8">
            <div class="bg-slate-900 p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <span
                            class="px-3 py-1 bg-pink-500 text-white text-[10px] font-bold uppercase tracking-widest rounded-lg">Active
                            Contract</span>
                        <span class="text-slate-400 text-sm font-mono">#{{ $loan->id }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Principal</p>
                            <p class="text-2xl font-bold">RM {{ number_format($loan->amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Due Balance</p>
                            <p class="text-2xl font-bold text-pink-400">RM
                                {{ number_format($loan->remaining_balance, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('borrower.loans.repay.store', $loan) }}">
                    @csrf

                    <div class="mb-8">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 text-center">Payment
                            Amount (RM)</label>
                        <div class="relative group">
                            <span
                                class="absolute left-6 top-1/2 -translate-y-1/2 text-3xl font-bold text-slate-300 transition-colors group-focus-within:text-pink-500">RM</span>
                            <input type="number" name="amount" x-model="repayAmount" step="0.01" min="1"
                                max="{{ $loan->remaining_balance }}" required
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-3xl pl-20 pr-8 py-6 text-4xl font-bold text-slate-900 focus:ring-4 focus:ring-pink-100 focus:border-pink-500 transition-all placeholder-slate-200"
                                placeholder="0.00">
                        </div>
                        @error('amount')
                            <p class="mt-3 text-sm text-rose-500 font-bold px-4">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Quick Actions --}}
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <button type="button" @click="repayAmount = 100"
                            class="py-3 px-4 bg-slate-50 text-slate-600 font-bold rounded-2xl hover:bg-pink-50 hover:text-pink-600 transition-all border border-slate-100">RM
                            100</button>
                        <button type="button" @click="repayAmount = 500"
                            class="py-3 px-4 bg-slate-50 text-slate-600 font-bold rounded-2xl hover:bg-pink-50 hover:text-pink-600 transition-all border border-slate-100">RM
                            500</button>
                        <button type="button" @click="repayAmount = '{{ $loan->remaining_balance }}'"
                            class="py-3 px-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">Full</button>
                    </div>

                    {{-- Disclaimer --}}
                    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 mb-8">
                        <div class="flex gap-4">
                            <div class="p-2 bg-emerald-500 text-white rounded-lg h-fit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Secured
                                    Interaction</h4>
                                <p class="text-emerald-700/80 text-xs font-medium mt-1 leading-relaxed">
                                    Repayment will be executed as a Qard Hasan settlement. No processing fees or hidden
                                    charges applied.
                                </p>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-5 bg-pink-500 text-white rounded-2xl font-bold text-lg shadow-xl shadow-pink-100 hover:bg-pink-600 transition-all transform hover:-translate-y-1">
                        Confirm Authorization
                    </button>
                </form>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('borrower.loans.show', $loan) }}"
                class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors tracking-tight uppercase">
                ← Return to Contract Details
            </a>
        </div>
    </div>
</x-borrower-layout>