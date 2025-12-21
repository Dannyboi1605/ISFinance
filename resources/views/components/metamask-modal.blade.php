@props([
    'title' => 'Authorize Transaction',
    'subtitle' => 'Confirm interaction with the ISFinance Qard Hasan smart contract.',
    'action' => 'confirmReload()',
    'mode' => 'reload'
])

<div x-show="showMetaMask" x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px] animate-fadeIn"
    @click.self="showMetaMask = false">

    <div
        class="bg-white rounded-3xl w-full max-w-[360px] shadow-2xl overflow-hidden animate-scaleIn border border-slate-100">
        {{-- MetaMask Header --}}
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div
                    class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white shadow-sm shadow-orange-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12l-4.5 4.5L12 12l5.5-5.5L22 12zM2 12l4.5-4.5L12 12 6.5 17.5 2 12z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">MetaMask Sync</span>
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 rounded-full border border-emerald-100">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-bold text-emerald-700 uppercase">Polygon</span>
            </div>
        </div>

        {{-- MetaMask Body --}}
        <div class="p-8 text-center" x-show="!isSyncing">
            <div
                class="w-20 h-20 bg-pink-50 rounded-2xl mx-auto mb-6 flex items-center justify-center text-pink-500 shadow-inner shadow-pink-100">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>

            <h3 class="text-xl font-display font-black text-slate-800 mb-2">{{ $title }}</h3>
            <p class="text-slate-500 text-sm mb-8 px-4 leading-relaxed">{{ $subtitle }}</p>

            <div class="bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100 text-left">
                @if($mode === 'reload')
                                    <div class="mb-4 pb-4 border-b border-slate-200/50">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Reload
                                            Amount (RM)</label>
                                        <input type="number" x-model="reloadAmount"
                                            class="w-full bg-transparent border-none p-0 text-3xl font-black text-slate-900 focus:ring-
                    0                        placeholder-slate-200"
                                            placeholder="0.00" min="1">
                                    </div>
                @else
                    <div class="mb-4 pb-4 border-b border-slate-200/50">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Payment Amount</span>
                                        <span class="text-3xl font-black text-slate-900" x-text="formatCurrency(repayAmount)">RM 0.00</span>
                                    </div>

                   @endif
                
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-200/50">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">In Currency</span>
                    <span class="text-sm font-bold text-slate-600" x-text="formatCurrency({{ $mode === 'reload' ? 'reloadAmount' : 'repayAmount' }} || 0)">RM
                        0.00</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gas Fee</span>
                    <span class="text-xs font-bold text-emerald-600">FREE (Subsidized)</span>
                </div>
            </div>

            <div class="flex gap-4">
                <button @click="showMetaMask = false"
                    class="flex-1 py-4 text-slate-500 font-bold text-sm hover:text-slate-800 transition-all">Reject</button>
                <button @click="{{ $action }}"
                    class="flex-1 py-4 bg-pink-500 text-white font-bold text-sm rounded-2xl shadow-xl shadow-pink-100 hover:bg-pink-600 transition-all transform hover:-translate-y-1">Confirm</button>
            </div>
        </div>

        {{-- Syncing State --}}
        <div class="p-12 text-center" x-show="isSyncing" x-cloak>
            <div class="relative w-24 h-24 mx-auto mb-8">
                <div class="absolute inset-0 border-4 border-slate-100 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-pink-500 rounded-full border-t-transparent animate-spin">
                </div>
                <div class="absolute inset-0 flex items-center justify-center text-pink-500">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xl font-display font-black text-slate-800 mb-2">Syncing with Blockchain...</h3>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest animate-pulse">Confirming Transaction
                Hash</p>
        </div>
    </div>
</div>