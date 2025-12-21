@props(['activeCurrency' => 'RM'])

<div class="flex p-1.5 bg-slate-100 rounded-2xl w-fit border border-slate-200 shadow-inner group" x-data="{ 
        toggle() {
            $dispatch('currency-toggled', this.currency === 'RM' ? 'ETH' : 'RM');
        }
     }">
    <button type="button" @click="currency = 'RM'; $dispatch('currency-toggled', 'RM')"
        :class="currency === 'RM' ? 'bg-white text-slate-900 shadow-lg' : 'text-slate-500 hover:text-slate-800'"
        class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-black transition-all duration-300">
        <span class="w-2 h-2 rounded-full" :class="currency === 'RM' ? 'bg-pink-500' : 'bg-slate-300'"></span>
        MYR (RM)
    </button>
    <button type="button" @click="currency = 'ETH'; $dispatch('currency-toggled', 'ETH')"
        :class="currency === 'ETH' ? 'bg-white text-slate-900 shadow-lg' : 'text-slate-500 hover:text-slate-800'"
        class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-black transition-all duration-300">
        <span class="w-2 h-2 rounded-full" :class="currency === 'ETH' ? 'bg-pink-500' : 'bg-slate-300'"></span>
        ETH
    </button>
</div>