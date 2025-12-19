<x-borrower-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div x-data="{ showRepayModal: false, repayAmount: '' }">
        <!-- Alert Section -->
        @if(!$wallet)
            <div class="mb-8 rounded-xl bg-gradient-to-r from-pink-600 to-rose-500 p-4 text-white shadow-lg shadow-pink-500/20 animate-fadeInUp">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Action Required</h3>
                        <p class="text-pink-50">Your account is incomplete. Please <a href="{{ route('borrower.wallet.setup') }}" class="underline hover:text-white font-semibold">link a wallet</a> to access Qard Hasan financing.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Hero Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Wallet Card (Large) -->
            <div class="lg:col-span-2 relative overflow-hidden rounded-3xl bg-gradient-to-br from-pink-500 to-purple-700 p-8 text-white shadow-xl shadow-purple-500/10 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-pink-400/20 rounded-full blur-2xl"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <p class="text-pink-100/80 text-sm font-medium uppercase tracking-wider mb-1">Total Account Balance</p>
                            <h2 class="text-4xl font-display font-bold">RM {{ number_format($wallet ? 0.00 : 0.00, 2) }}</h2>
                        </div>
                        <div class="p-2 bg-white/10 rounded-lg backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-end justify-between">
                        <div>
                            <p class="text-pink-200/60 text-xs mb-1">Wallet Address</p>
                            <div class="flex items-center gap-2 bg-black/20 py-1.5 px-3 rounded-xl backdrop-blur-md border border-white/10">
                                <code class="text-sm font-mono text-pink-50">
                                    {{ $wallet ? \Illuminate\Support\Str::limit($wallet->wallet_address, 10, '...') . substr($wallet->wallet_address, -4) : 'No Wallet Linked' }}
                                </code>
                                @if($wallet)
                                <button class="text-pink-200 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-pink-200/80 mb-1">Network Status</div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                                <span class="text-sm font-medium">Mainnet Connected</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="grid grid-rows-2 gap-6">
                <!-- Total Volume -->
                <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-100/50 border border-slate-100 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-pink-50 rounded-xl text-pink-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <span class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Volume</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-900">
                        RM {{ number_format($totalTransactionAmount, 2) }}
                    </div>
                </div>

                <!-- Interactions -->
                <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-100/50 border border-slate-100 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-purple-50 rounded-xl text-purple-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
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
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-40 h-40 rounded-full border-8 border-slate-50 relative">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="80" cy="80" r="72" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-100" />
                                <circle cx="80" cy="80" r="72" stroke="currentColor" stroke-width="8" fill="transparent" 
                                    class="text-pink-500" 
                                    stroke-dasharray="452.39" 
                                    stroke-dashoffset="{{ 452.39 - (452.39 * $currentLoan->progress_percentage / 100) }}" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-display font-bold text-slate-900">{{ $currentLoan->progress_percentage }}%</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Recovered</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Remaining</span>
                            <span class="font-bold text-slate-900 text-lg text-pink-600">RM {{ number_format($currentLoan->remaining_balance, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Term</span>
                            <span class="font-bold text-slate-800">{{ $currentLoan->duration_months }} Months</span>
                        </div>
                    </div>
                    
                    @if(in_array($currentLoan->status, ['disbursed', 'approved']))
                        <button @click="showRepayModal = true" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-lg shadow-slate-200 hover:bg-slate-800 transition-all transform hover:-translate-y-1">
                            Make Repayment
                        </button>
                    @endif
                @else
                    <div class="flex flex-col items-center justify-center h-64 text-center">
                        <div class="p-4 bg-slate-50 rounded-2xl mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <p class="text-slate-500 font-medium">No active financing found.</p>
                        <a href="{{ route('borrower.loans.create') }}" class="mt-4 px-6 py-2 bg-pink-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-pink-100">Apply for Loan</a>
                    </div>
                @endif
            </div>

            <!-- Trends Card -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-xl shadow-slate-100/50 border border-slate-100 relative overflow-hidden">
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
                                <stop offset="0%" stop-color="#EC4899" stop-opacity="0.1"/>
                                <stop offset="100%" stop-color="#EC4899" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <path d="M0 80 Q 150 100, 300 50 T 600 30 L 600 150 L 0 150 Z" fill="url(#g1)" />
                        <path d="M0 80 Q 150 100, 300 50 T 600 30" stroke="#EC4899" stroke-width="4" fill="none" stroke-linecap="round" />
                    </svg>
                    <div class="absolute bottom-0 left-0 right-0 flex justify-between px-2 text-[10px] text-slate-300 font-bold uppercase tracking-widest pt-4">
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
            <div class="lg:col-span-3 bg-white rounded-3xl shadow-xl shadow-slate-100/50 border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-xl">Recent Activity</h3>
                    <button class="text-sm font-bold text-pink-600 hover:text-pink-700">Audit Log →</button>
                </div>
                
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Operation</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Timestamp</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Blockchain ID</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Amount</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-slate-50/80 transition-all group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="p-2.5 rounded-xl transition-colors {{ $tx['type'] === 'Disbursement' ? 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white' : 'bg-pink-50 text-pink-500 group-hover:bg-pink-500 group-hover:text-white' }}">
                                                @if($tx['type'] === 'Disbursement')
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900">{{ $tx['type'] }}</div>
                                                <div class="text-[10px] font-medium text-slate-400">Loan ID #{{ $tx['loan_id'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-slate-700 font-medium">{{ \Carbon\Carbon::parse($tx['date'])->format('d M, Y') }}</div>
                                        <div class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($tx['date'])->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <code class="text-[11px] font-mono bg-slate-100/50 px-2 py-1 rounded-lg text-slate-600 group-hover:bg-white group-hover:shadow-sm transition-all">
                                            {{ substr($tx['hash'], 0, 10) }}...{{ substr($tx['hash'], -6) }}
                                        </code>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-base {{ $tx['type'] === 'Disbursement' ? 'text-emerald-600' : 'text-slate-900' }}">
                                        {{ $tx['type'] === 'Disbursement' ? '+' : '-' }} RM {{ number_format(abs($tx['amount']), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100 transition-colors group-hover:bg-emerald-500 group-hover:text-white group-hover:border-transparent">
                                            {{ $tx['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="inline-flex items-center justify-center p-4 bg-slate-50 rounded-full mb-3 text-slate-300">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
            <div class="bg-gradient-to-br from-indigo-900 to-indigo-800 rounded-3xl p-8 text-white shadow-xl shadow-indigo-100 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <h4 class="text-xl font-bold mb-4">Shariah Advisory</h4>
                    <p class="text-indigo-200 text-sm leading-relaxed mb-6">Need clarification on Qard Hasan principles or repayment restructuring?</p>
                </div>
                <div class="relative z-10">
                    <button class="w-full py-4 bg-white text-indigo-900 rounded-2xl font-bold hover:bg-white/90 transition-all shadow-lg">Chat with Ustaz</button>
                    <p class="text-center text-[10px] font-bold text-indigo-300 mt-4 uppercase tracking-[0.2em]">ISFinance Compliance</p>
                </div>
            </div>
        </div>

        {{-- Repayment Modal --}}
        @if($currentLoan)
            <div x-show="showRepayModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-fadeIn">
                <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl animate-scaleIn border border-white/20">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="p-4 bg-pink-50 text-pink-500 rounded-2xl shadow-inner shadow-pink-100">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-display font-bold text-slate-800">Quick Repay</h3>
                            <p class="text-slate-400 text-sm font-medium">Loan ID #{{ $currentLoan->id }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('borrower.loans.repay.store', $currentLoan) }}">
                        @csrf
                        <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Amount to Repay (RM)</label>
                            <input type="number" name="amount" x-model="repayAmount" step="0.01" min="1" max="{{ $currentLoan->remaining_balance }}" required 
                                class="w-full bg-transparent border-none p-0 text-4xl font-bold text-slate-900 focus:ring-0 placeholder-slate-200"
                                placeholder="0.00">
                            <div class="mt-4 flex justify-between items-center bg-white p-3 rounded-xl border border-slate-100">
                                <span class="text-xs text-slate-400 font-medium tracking-tight">Max balance</span>
                                <button type="button" @click="repayAmount = '{{ $currentLoan->remaining_balance }}'" class="text-xs font-bold text-pink-500 hover:text-pink-600">RM {{ number_format($currentLoan->remaining_balance, 2) }}</button>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <button type="button" @click="showRepayModal = false" class="flex-1 py-4 text-slate-500 font-bold hover:text-slate-700 transition-all">Dismiss</button>
                            <button type="submit" class="flex-1 py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 transform hover:-translate-y-1">Authorize</button>
                        </div>
                        <p class="text-center text-[10px] text-slate-400 font-medium mt-6 leading-relaxed">By clicking Authorize, you trigger a smart contract simulation to transfer funds from your linked wallet.</p>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-borrower-layout>