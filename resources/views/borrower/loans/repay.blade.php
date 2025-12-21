<x-borrower-layout>
    <x-slot name="header">
        Make a Payment
    </x-slot>

    <div class="max-w-2xl mx-auto" x-data="{ 
            repayAmount: '{{ old('amount', $loan->remaining_balance) }}',
            currency: 'RM',
            showMetaMask: false,
            showErrorModal: false,
            isSyncing: false,
            balanceRM: {{ auth()->user()->wallet->balance ?? 0 }},
            ethRate: 15000,

            formatCurrency(val) {
                if (this.currency === 'ETH') {
                    return (val / this.ethRate).toFixed(4) + ' ETH';
                }
                return 'RM ' + parseFloat(val || 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            },

            get insufficientFunds() {
                return parseFloat(this.repayAmount) > parseFloat(this.balanceRM);
            },

            get exceedsBalance() {
                return parseFloat(this.repayAmount) > {{ $loan->remaining_balance }};
            },

            get hasError() {
                return this.insufficientFunds || this.exceedsBalance;
            },

            confirmRepayment() {
                if(this.hasError) return;
                this.isSyncing = true;
                this.$refs.repayForm.submit();
            }
        }" @currency-toggled.window="currency = $event.detail">

        <x-metamask-modal title="Authorize Repayment"
            subtitle="Confirm your Qard Hasan loan settlement via smart contract." action="confirmRepayment()"
            mode="repayment" />

        {{-- Insufficient Funds Modal --}}
        <div x-show="showErrorModal" x-cloak
            class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md animate-fadeIn">
            <div
                class="bg-white rounded-[2.5rem] p-10 max-w-sm w-full shadow-2xl animate-scaleIn border border-white/20 text-center">
                <div
                    class="w-20 h-20 mx-auto bg-rose-50 rounded-3xl flex items-center justify-center text-rose-500 mb-8 shadow-inner">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-display font-bold text-slate-900 mb-3">Insufficient Funds</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed mb-10">
                    Your current wallet balance (<span class="text-slate-900 font-bold"
                        x-text="formatCurrency(balanceRM)"></span>) is insufficient for this <span
                        class="text-rose-500 font-bold" x-text="formatCurrency(repayAmount)"></span> payment.
                </p>

                <div class="flex flex-col gap-3">
                    <a href="{{ route('borrower.dashboard') }}"
                        class="w-full py-4 bg-pink-500 text-white rounded-2xl font-bold transition-all shadow-lg shadow-pink-100 hover:bg-pink-600 transform hover:-translate-y-1">
                        Reload Wallet
                    </a>
                    <button @click="showErrorModal = false"
                        class="w-full py-4 text-slate-500 font-bold hover:text-slate-900 transition-all">
                        Adjust Amount
                    </button>
                </div>
            </div>
        </div>

        {{-- Progress Header --}}
        <div class="mb-10 flex flex-col items-center">
            <x-currency-toggle />
            <h1 class="text-3xl font-display font-black text-slate-900 mt-8">Authorize Repayment</h1>
            <p class="text-slate-400 mt-2 font-bold uppercase text-[10px] tracking-widest">Safe & Secure Blockchain
                Interaction</p>
        </div>

        {{-- Loan Overview Card --}}
        <div
            class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden mb-10">
            <div class="bg-slate-900 p-10 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-10 opacity-10">
                    <svg class="w-32 h-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="px-4 py-1.5 bg-pink-500 text-white text-[10px] font-bold uppercase tracking-[0.2em] rounded-xl shadow-lg shadow-pink-500/20">Active
                            Contract</span>
                        <span class="text-slate-400 text-sm font-mono tracking-tighter">#{{ $loan->id }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-12">
                        <div>
                            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em] mb-2">Original
                                Principal</p>
                            <p class="text-3xl font-black" x-text="formatCurrency({{ $loan->amount }})">RM
                                {{ number_format($loan->amount, 2) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-pink-400/60 text-[10px] font-bold uppercase tracking-[0.2em] mb-2">Wallet
                                Balance</p>
                            <p class="text-3xl font-black text-pink-400" x-text="formatCurrency(balanceRM)">RM
                                {{ number_format($balanceRM ?? 0, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-10">
                <form x-ref="repayForm" method="POST" action="{{ route('borrower.loans.repay.store', $loan) }}">
                    @csrf

                    <div class="mb-10 text-center">
                        <label
                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-6 px-4">Repayment
                            Amount</label>
                        <div class="relative group max-w-sm mx-auto">
                            <input type="number" name="amount" x-model="repayAmount" step="0.01" min="1"
                                :class="hasError ? 'ring-4 ring-rose-500/20 border-2 border-rose-500 bg-rose-50/30' : 'bg-slate-50 border-none focus:ring-4 focus:ring-pink-100'"
                                required
                                class="w-full rounded-3xl p-8 text-5xl font-black text-slate-900 transition-all text-center placeholder-slate-200"
                                placeholder="0.00">

                            <div class="mt-4 space-y-2">
                                <template x-if="insufficientFunds">
                                    <div class="animate-bounceIn">
                                        <p
                                            class="text-rose-500 font-bold text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            Error: Repayment amount exceeds your current balance (RM
                                            {{ number_format(auth()->user()->wallet->balance ?? 0, 2) }})
                                        </p>
                                    </div>
                                </template>
                                <template x-if="exceedsBalance && !insufficientFunds">
                                    <div class="animate-bounceIn">
                                        <p
                                            class="text-rose-500 font-bold text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            You cannot repay more than the outstanding balance of RM
                                            {{ number_format($loan->remaining_balance, 2) }}
                                        </p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    @error('amount')
                        <p class="mt-3 text-sm text-rose-500 font-bold px-4">{{ $message }}</p>
                    @enderror

                    {{-- Quick Actions --}}
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <button type="button" @click="repayAmount = 100"
                            class="py-3 px-4 bg-slate-50 text-slate-600 font-bold rounded-2xl hover:bg-pink-50 hover:text-pink-600 transition-all border border-slate-100 text-xs">RM
                            100</button>
                        <button type="button" @click="repayAmount = 500"
                            class="py-3 px-4 bg-slate-50 text-slate-600 font-bold rounded-2xl hover:bg-pink-50 hover:text-pink-600 transition-all border border-slate-100 text-xs">RM
                            500</button>
                        <button type="button" @click="repayAmount = '{{ $loan->remaining_balance }}'"
                            class="py-3 px-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 text-xs uppercase tracking-widest">Full
                            Repay</button>
                    </div>

                    {{-- Disclaimer --}}
                    <div class="bg-emerald-50 border border-emerald-100 rounded-3xl p-6 mb-10">
                        <div class="flex gap-4">
                            <div class="p-2.5 bg-emerald-500 text-white rounded-xl h-fit shadow-lg shadow-emerald-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-emerald-800 uppercase tracking-widest">Contract
                                    Validated
                                </h4>
                                <p class="text-emerald-700/70 text-xs font-bold mt-1 leading-relaxed">
                                    Settlement will be executed via Qard Hasan smart contract middleware. No interest or
                                    hidden
                                    Riba applied.
                                </p>
                            </div>
                        </div>
                    </div>

                    <button type="button"
                        @click="if(insufficientFunds) { showErrorModal = true } else if(!hasError) { showMetaMask = true }"
                        :disabled="exceedsBalance"
                        :class="exceedsBalance ? 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none grayscale' : (insufficientFunds ? 'bg-rose-500 text-white hover:bg-rose-600 shadow-xl shadow-rose-100' : 'bg-pink-500 text-white hover:bg-pink-600 shadow-xl shadow-pink-100 transform hover:-translate-y-1')"
                        class="w-full py-6 rounded-3xl font-black text-lg transition-all flex items-center justify-center gap-3">
                        <template x-if="!hasError">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center font-bold text-xs">
                                    M</div>
                                Confirm Payment
                            </div>
                        </template>
                        <template x-if="insufficientFunds">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Review Payment Error
                            </div>
                        </template>
                        <template x-if="exceedsBalance && !insufficientFunds">
                            <span>Validation Error</span>
                        </template>
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