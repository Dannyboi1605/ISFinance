<x-borrower-layout>
    <x-slot name="header">
        Wallet Settings
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8 animate-fadeIn">

        {{-- Wallet Header --}}
        <div
            class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-slate-800 p-10 text-white shadow-2xl">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-pink-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-6">
                    <div
                        class="w-20 h-20 bg-pink-500 rounded-3xl flex items-center justify-center shadow-xl shadow-pink-500/20">
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-display font-bold tracking-tight">Active Wallet</h1>
                        <p class="text-pink-400 font-bold uppercase text-[10px] tracking-widest mt-1">Status: Linked &
                            Verified</p>
                    </div>
                </div>
                <div class="flex flex-col items-center md:items-end">
                    <span class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Wallet Type</span>
                    <span
                        class="px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-xl text-sm font-bold border border-white/10">
                        {{ str_replace('_', ' ', ucfirst($wallet->type)) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Wallet Details --}}
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-6">Connection Details
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2">Network Address</label>
                            <div
                                class="flex items-center gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-100 group transition-all hover:bg-white hover:shadow-lg">
                                <code
                                    class="text-sm font-mono text-slate-900 break-all flex-1">{{ $wallet->wallet_address }}</code>
                                <button class="text-slate-400 hover:text-pink-500 transition-colors p-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2">System Status</label>
                            <div
                                class="flex items-center gap-3 bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100">
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                <span class="text-sm font-bold text-emerald-800">Connected to Simulated Mainnet</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-between">
                    <div>
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-6">Security Info
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">
                            This wallet is used for all disbursements and repayments within the ISFinance ecosystem.
                            Your transactions are recorded on our simulated immutable ledger for complete Shariah
                            transparency.
                        </p>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100">
                        <div class="flex gap-4 items-start">
                            <div class="p-2 bg-slate-200 text-slate-500 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Note</h4>
                                <p class="text-slate-500 text-[10px] mt-1">Wallet change requests are currently locked
                                    for your security.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Help Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                <div
                    class="absolute -bottom-8 -right-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <h4 class="text-xl font-bold mb-4">Shariah Governance</h4>
                <p class="text-indigo-200 text-sm leading-relaxed mb-6">Learn how we ensure your financing remains 100%
                    Interest-Free through smart contract logic.</p>
                <button
                    class="w-full py-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl font-bold text-sm hover:bg-white hover:text-indigo-900 transition-all">Read
                    Principles</button>
            </div>

            <div
                class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col justify-between">
                <div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">Need Help?</h4>
                    <p class="text-slate-500 text-sm">Having issues with your wallet connection or transaction signing?
                    </p>
                </div>
                <button
                    class="mt-6 w-full py-4 text-pink-500 font-bold border-2 border-pink-100 rounded-2xl hover:bg-pink-50 transition-all">Contact
                    Support</button>
            </div>
        </div>

    </div>
</x-borrower-layout>