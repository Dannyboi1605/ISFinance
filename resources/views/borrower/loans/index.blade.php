<x-borrower-layout>
    <x-slot name="header">
        My Loans
    </x-slot>

    <div class="max-w-6xl mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-display font-bold text-slate-900 tracking-tight">Financial History</h1>
                <p class="text-slate-500 mt-1 font-medium">Track and manage your Qard Hasan loan applications</p>
            </div>
            @if($eligibility['can_apply'])
                <a href="{{ route('borrower.loans.create') }}" class="flex items-center gap-2 px-8 py-3.5 bg-pink-500 hover:bg-pink-600 text-white rounded-2xl font-bold shadow-xl shadow-pink-100 transition-all transform hover:-translate-y-1">
                    <svg class="w-5 h-5 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Application
                </a>
            @endif
        </div>

        {{-- Session Messages --}}
        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-400 p-5 rounded-2xl shadow-sm animate-fadeInRight">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-emerald-700 font-bold tracking-tight">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-rose-50 border-l-4 border-rose-400 p-5 rounded-2xl shadow-sm animate-fadeInRight">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-rose-100 rounded-lg text-rose-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <p class="text-rose-700 font-bold tracking-tight">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Loans Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse($loans as $loan)
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden transform transition-all hover:shadow-2xl hover:-translate-y-2 group">
                    {{-- Status Header --}}
                    <div class="p-8 pb-4 flex justify-between items-start">
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Contract ID</span>
                            <span class="text-slate-900 font-bold font-mono">#{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                            @if($loan->status === 'completed') bg-emerald-100 text-emerald-700
                            @elseif($loan->status === 'disbursed') bg-sky-100 text-sky-700
                            @elseif($loan->status === 'approved') bg-amber-100 text-amber-700
                            @elseif($loan->status === 'pending') bg-pink-100 text-pink-700
                            @else bg-rose-100 text-rose-700
                            @endif">
                            {{ $loan->status }}
                        </span>
                    </div>

                    {{-- Card Body --}}
                    <div class="px-8 py-4">
                        <div class="mb-6">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Principal Amount</p>
                            <h3 class="text-4xl font-display font-bold text-slate-900 group-hover:text-pink-600 transition-colors">RM {{ number_format($loan->amount, 0) }}</h3>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-sm border-b border-slate-50 pb-2">
                                <span class="text-slate-500 font-medium">Repayment Goal</span>
                                <span class="font-bold text-slate-900">RM {{ number_format($loan->remaining_balance, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm border-b border-slate-50 pb-2">
                                <span class="text-slate-500 font-medium">Tenure</span>
                                <span class="font-bold text-slate-900">{{ $loan->duration_months }} Months</span>
                            </div>
                        </div>

                        @if($loan->status === 'disbursed')
                            <div class="mb-6">
                                <div class="flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase mb-2">
                                    <span>Payment Progress</span>
                                    <span class="text-pink-500">{{ $loan->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-pink-500 h-full rounded-full transition-all duration-1000 shadow-[0_0_10px_#ec4899]" style="width: {{ $loan->progress_percentage }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Actions Footer --}}
                    <div class="p-6 bg-slate-50/50 flex gap-3">
                        <a href="{{ route('borrower.loans.show', $loan) }}" class="flex-1 py-4 text-center text-slate-600 font-bold text-sm bg-white rounded-2xl hover:bg-slate-50 transition-all border border-slate-100">
                            Details
                        </a>
                        @if(in_array($loan->status, ['disbursed', 'approved']))
                            <form action="{{ route('borrower.loans.repay', $loan) }}" method="GET" class="flex-1">
                                <button type="submit" class="w-full py-4 text-center bg-slate-900 text-white font-bold text-sm rounded-2xl shadow-lg shadow-slate-100 hover:bg-slate-800 transition-all transform hover:-translate-y-1">
                                    Repay RM
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 bg-white rounded-[3rem] border-2 border-dashed border-slate-200 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-slate-50 rounded-full mb-6 text-slate-300">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Clear History</h3>
                    <p class="text-slate-500 mb-8 max-w-sm mx-auto font-medium">You haven't applied for any Qard Hasan financing yet. Ready to start your journey?</p>
                    <a href="{{ route('borrower.loans.create') }}" class="px-10 py-4 bg-pink-500 text-white font-bold rounded-2xl shadow-xl shadow-pink-100 transform transition-all hover:-translate-y-1">Start Application</a>
                </div>
            @endforelse
        </div>
    </div>
</x-borrower-layout>