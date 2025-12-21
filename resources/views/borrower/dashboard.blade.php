<x-borrower-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div x-data="{ 
            currency: 'RM',
            showMetaMask: false,
            isSyncing: false,
            reloadAmount: 1000,
            balanceRM: {{ $wallet->balance ?? 0 }},
            ethRate: 15000,
            
            formatCurrency(val) {
                if (this.currency === 'ETH') {
                    return (val / this.ethRate).toFixed(4) + ' ETH';
                }
                return 'RM ' + parseFloat(val).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            },

            confirmReload() {
                if (!this.reloadAmount || this.reloadAmount < 1) return;
                this.isSyncing = true;
                this.$refs.reloadForm.submit();
            }
        }" @currency-toggled.window="currency = $event.detail">

        <form x-ref="reloadForm" action="{{ route('borrower.wallet.reload') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="amount" :value="reloadAmount">
        </form>

        <x-metamask-modal />

        <!-- Alert Section -->
        @if(!$wallet)
            <div
                class="mb-8 rounded-xl bg-gradient-to-r from-pink-600 to-rose-500 p-4 text-white shadow-lg shadow-pink-500/20 animate-fadeInUp">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Action Required</h3>
                        <p class="text-pink-50">Your account is incomplete. Please <a
                                href="{{ route('borrower.wallet.setup') }}"
                                class="underline hover:text-white font-semibold">link a wallet</a> to access Qard Hasan
                            financing.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Bar -->
        <div class="flex justify-between items-center mb-6">
            <x-currency-toggle />
            @if($wallet)
                <button @click="showMetaMask = true"
                    class="px-6 py-2.5 bg-white text-slate-900 rounded-2xl font-black text-xs shadow-sm border border-slate-100 hover:bg-slate-50 transition-all flex items-center gap-2">
                    <div
                        class="w-5 h-5 bg-orange-100 rounded-full flex items-center justify-center font-bold text-orange-600">
                        M</div>
                    Reload Wallet
                </button>
            @endif
        </div>

        <!-- Hero Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Wallet Card (Large) -->
            <div
                class="lg:col-span-2 relative overflow-hidden rounded-3xl bg-gradient-to-br from-pink-500 to-purple-700 p-8 text-white shadow-xl shadow-purple-500/10 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-pink-400/20 rounded-full blur-2xl"></div>

                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <p class="text-pink-100/80 text-[10px] font-bold uppercase tracking-[0.2em] mb-1">Available
                                Balance</p>
                            <h2 class="text-5xl font-display font-black tracking-tight"
                                x-text="formatCurrency(balanceRM)">
                                RM {{ number_format($wallet->balance ?? 0, 2) }}
                            </h2>
                        </div>
                        <div class="p-3 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-end justify-between">
                        <div>
                            <p class="text-pink-200/60 text-[10px] font-bold uppercase tracking-widest mb-2">Wallet
                                Address</p>
                            <div
                                class="flex items-center gap-3 bg-black/20 py-2 px-4 rounded-xl backdrop-blur-md border border-white/10">
                                <code class="text-sm font-mono text-pink-50">
                                    {{ $wallet ? \Illuminate\Support\Str::limit($wallet->wallet_address, 12, '...') . substr($wallet->wallet_address, -6) : 'No Wallet Linked' }}
                                </code>
                                @if($wallet)
                                    <button class="text-pink-200 hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-[10px] text-pink-200/80 font-bold uppercase tracking-widest mb-1">Network
                            </div>
                            <div
                                class="flex items-center gap-2 bg-emerald-500/20 px-3 py-1 rounded-full border border-emerald-500/30">
                                <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                                <span class="text-xs font-bold">Polygon Mainnet</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="grid grid-rows-2 gap-6">
                <!-- Total Loan Disbursement -->
                <div
                    class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-100/50 border border-slate-100 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-pink-50 rounded-xl text-pink-500 shadow-sm shadow-pink-100">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">Total
                            Disbursement</span>
                    </div>
                    <div class="text-3xl font-black text-slate-900"
                        x-text="formatCurrency({{ $totalTransactionAmount }})">
                        RM {{ number_format($totalTransactionAmount, 2) }}
                    </div>
                </div>

                <!-- Interactions -->
                <div
                    class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-100/50 border border-slate-100 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-purple-50 rounded-xl text-purple-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="text-slate-500 text-xs font-bold uppercase tracking-wider">Interactions</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-900">
                        {{ $totalTransactionCount }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Loans & Progress Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Loan Progress Card -->
            <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-100/50 border border-slate-100">
                <h3 class="font-bold text-slate-800 mb-6">Loan Progress</h3>

                @if($currentLoan)
                    @php
                        $totalAmount = $currentLoan->amount;
                        $remainingAmount = $currentLoan->remaining_balance;
                        $paidAmount = $totalAmount - $remainingAmount;
                        $percentage = $currentLoan->progress_percentage;
                    @endphp
                    <div class="text-center mb-6" x-data="{ 
                                            percent: 0,
                                            radius: 70,
                                            get circumference() { return 2 * Math.PI * this.radius },
                                            init() {
                                                setTimeout(() => { this.percent = {{ $percentage }}; }, 100);
                                            }
                                        }">
                        <div
                            class="inline-flex items-center justify-center w-40 h-40 rounded-full border-8 border-slate-50 relative group">
                            <svg class="w-full h-full transform -rotate-90 drop-shadow-sm" viewBox="0 0 160 160">
                                <defs>
                                    <linearGradient id="hotPinkGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#F472B6" />
                                        <stop offset="100%" stop-color="#DB2777" />
                                    </linearGradient>
                                </defs>
                                {{-- Empty Track --}}
                                <circle cx="80" cy="80" :r="radius" stroke="currentColor" stroke-width="10"
                                    fill="transparent" class="text-slate-100" />
                                {{-- Progress Ring --}}
                                <circle cx="80" cy="80" :r="radius" stroke="url(#hotPinkGradient)" stroke-width="10"
                                    fill="transparent" stroke-linecap="round" class="transition-all duration-1000 ease-out"
                                    :stroke-dasharray="circumference"
                                    :stroke-dashoffset="circumference - (circumference * percent / 100)" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-4xl font-display font-black text-slate-900"
                                    x-text="Math.round(percent) + '%'">0%</span>
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Recovered</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Repayment
                                Status</span>
                            <span class="font-bold text-slate-900 flex gap-2">
                                <span x-text="'Paid: ' + formatCurrency({{ $paidAmount }})"></span>
                                <span class="text-slate-300">/</span>
                                <span x-text="formatCurrency({{ $totalAmount }})"></span>
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Remaining
                                balance</span>
                            <span class="font-black text-pink-600 text-lg"
                                x-text="formatCurrency({{ $remainingAmount }})"></span>
                        </div>
                    </div>

                    @if(in_array($currentLoan->status, ['disbursed', 'approved']))
                        <a href="{{ route('borrower.loans.repay', $currentLoan) }}"
                            class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-lg shadow-slate-200 hover:bg-slate-800 transition-all transform hover:-translate-y-1 block text-center">
                            Make Repayment
                        </a>
                    @endif
                @else
                    <div class="flex flex-col items-center justify-center h-64 text-center">
                        <div class="p-4 bg-slate-50 rounded-2xl mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <p class="text-slate-500 font-medium">No active financing found.</p>
                        <a href="{{ route('borrower.loans.create') }}"
                            class="mt-4 px-6 py-2 bg-pink-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-pink-100">Apply
                            for Loan</a>
                    </div>
                @endif
            </div>

            <!-- Trends Card -->
            <div
                class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-xl shadow-slate-100/50 border border-slate-100 relative overflow-hidden">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h3 class="font-bold text-slate-800 text-xl">Financial Health</h3>
                        <p class="text-slate-400 text-sm mt-1">Simulated repayment performance</p>
                    </div>
                    <div class="flex gap-2">
                        <div class="w-3 h-3 bg-pink-500 rounded-full"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Growth</span>
                    </div>
                </div>

                <div class="h-48 w-full relative">
                    <svg class="w-full h-full" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="g1" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#EC4899" stop-opacity="0.1" />
                                <stop offset="100%" stop-color="#EC4899" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <path d="M0 80 Q 150 100, 300 50 T 600 30 L 600 150 L 0 150 Z" fill="url(#g1)" />
                        <path d="M0 80 Q 150 100, 300 50 T 600 30" stroke="#EC4899" stroke-width="4" fill="none"
                            stroke-linecap="round" />
                    </svg>
                    <div
                        class="absolute bottom-0 left-0 right-0 flex justify-between px-2 text-[10px] text-slate-300 font-bold uppercase tracking-widest pt-4">
                        <span>Jan</span>
                        <span>Feb</span>
                        <span>Mar</span>
                        <span>Apr</span>
                        <span>May</span>
                        <span>Jun</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity & Support Section -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div
                class="lg:col-span-3 bg-white rounded-3xl shadow-xl shadow-slate-100/50 border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-xl">Recent Activity</h3>
                    <button class="text-sm font-bold text-pink-600 hover:text-pink-700">Audit Log →</button>
                </div>

                <div class="overflow-x-auto p-4">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Operation</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Timestamp</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Blockchain ID</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                                    Amount</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-slate-50/80 transition-all group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="p-2.5 rounded-xl transition-colors {{ $tx['type'] === 'Disbursement' ? 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white' : 'bg-pink-50 text-pink-500 group-hover:bg-pink-500 group-hover:text-white' }}">
                                                @if($tx['type'] === 'Disbursement')
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900">{{ $tx['type'] }}</div>
                                                <div class="text-[10px] font-medium text-slate-400">Loan ID
                                                    #{{ $tx['loan_id'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-slate-700 font-medium">
                                            {{ \Carbon\Carbon::parse($tx['date'])->format('d M, Y') }}
                                        </div>
                                        <div class="text-[10px] text-slate-400">
                                            {{ \Carbon\Carbon::parse($tx['date'])->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <code
                                            class="text-[11px] font-mono bg-slate-100/50 px-2 py-1 rounded-lg text-slate-600 group-hover:bg-white group-hover:shadow-sm transition-all">
                                                                {{ substr($tx['hash'], 0, 10) }}...{{ substr($tx['hash'], -6) }}
                                                            </code>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-right font-bold text-base {{ $tx['type'] === 'Disbursement' ? 'text-emerald-600' : 'text-slate-900' }}">
                                        {{ $tx['type'] === 'Disbursement' ? '+' : '-' }} RM
                                        {{ number_format(abs($tx['amount']), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100 transition-colors group-hover:bg-emerald-500 group-hover:text-white group-hover:border-transparent">
                                            {{ $tx['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div
                                            class="inline-flex items-center justify-center p-4 bg-slate-50 rounded-full mb-3 text-slate-300">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-400 font-medium">No system alerts or interactions found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Support & Feedback -->
            <div
                class="bg-gradient-to-br from-indigo-900 to-indigo-800 rounded-3xl p-8 text-white shadow-xl shadow-indigo-100 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <h4 class="text-xl font-bold mb-4">Shariah Advisory</h4>
                    <p class="text-indigo-200 text-sm leading-relaxed mb-6">Need clarification on Qard Hasan principles
                        or repayment restructuring?</p>
                </div>
                <div class="relative z-10">
                    <button
                        class="w-full py-4 bg-white text-indigo-900 rounded-2xl font-bold hover:bg-white/90 transition-all shadow-lg">Chat
                        with Ustaz</button>
                    <p class="text-center text-[10px] font-bold text-indigo-300 mt-4 uppercase tracking-[0.2em]">
                        ISFinance Compliance</p>
                </div>
            </div>
        </div>

    </div>
</x-borrower-layout>