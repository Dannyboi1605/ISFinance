<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center p-6 bg-slate-50">
        <div
            class="max-w-md w-full bg-white rounded-[3rem] p-12 shadow-2xl border border-slate-100 text-center animate-fadeIn">
            <div
                class="w-24 h-24 mx-auto bg-rose-50 text-rose-500 rounded-3xl flex items-center justify-center mb-8 shadow-inner">
                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h1 class="text-3xl font-display font-black text-slate-900 mb-4 tracking-tight">Akses Disekat</h1>
            <p class="text-slate-500 font-medium leading-relaxed mb-10">Akaun anda telah digantung oleh pentadbir
                sistem. Sila hubungi pihak pengurusan ISFinance untuk maklumat lanjut.</p>

            <div class="space-y-4">
                <a href="mailto:support@isfinance.com"
                    class="block w-full py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 transform hover:-translate-y-1">
                    Hubungi Sokongan
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 text-slate-500 font-bold hover:text-slate-900 transition-all">
                        Kembali ke Log Masuk
                    </button>
                </form>
            </div>

            <p class="mt-12 text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">ISFinance Security Protocol
            </p>
        </div>
    </div>
</x-guest-layout>