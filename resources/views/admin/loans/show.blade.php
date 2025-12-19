<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="max-w-6xl mx-auto" x-data="{ tab: 'applicant', showRejectModal: false }">

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-400 p-4 rounded-xl shadow-sm animate-fadeInRight">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Loan Overview Card --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden mb-8 border border-slate-100">
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 p-8 text-white">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span
                                class="px-3 py-1 bg-pink-500 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg">Loan
                                Review</span>
                            <span class="text-slate-400 text-sm font-medium">#{{ $loan->id }}</span>
                        </div>
                        <h1 class="text-3xl font-display font-bold">RM {{ number_format($loan->amount, 2) }}</h1>
                        <p class="text-slate-400 mt-1">Applied by <span
                                class="text-white font-medium">{{ $loan->borrower->name }}</span> on
                            {{ $loan->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex flex-col items-end gap-3">
                        <span class="px-6 py-2 rounded-2xl text-sm font-bold shadow-lg
                            @if($loan->status === 'completed') bg-emerald-500 text-white
                            @elseif($loan->status === 'disbursed') bg-sky-500 text-white
                            @elseif($loan->status === 'approved') bg-amber-500 text-white
                            @elseif($loan->status === 'pending') bg-pink-500 text-white
                            @else bg-rose-500 text-white
                            @endif">
                            {{ ucfirst($loan->status) }}
                        </span>
                        @if($loan->status === 'pending')
                            <div class="flex gap-3">
                                <form method="POST" action="{{ route('admin.loans.approve', $loan) }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold transition-all shadow-lg shadow-emerald-200 group">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Approve
                                    </button>
                                </form>
                                <button @click="showRejectModal = true"
                                    class="flex items-center gap-2 px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-bold transition-all shadow-lg shadow-rose-200 group">
                                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reject
                                </button>
                            </div>
                        @elseif($loan->status === 'approved')
                            <form method="POST" action="{{ route('admin.loans.disburse', $loan) }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 px-8 py-3 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-bold transition-all shadow-lg shadow-sky-200 group">
                                    <svg class="w-5 h-5 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Disburse Now
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tab Headers --}}
            <div class="flex bg-slate-50 border-b border-slate-100 p-2">
                <button @click="tab = 'applicant'"
                    :class="tab === 'applicant' ? 'bg-white text-pink-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                    class="flex-1 py-3 font-bold rounded-xl transition-all">Applicant</button>
                <button @click="tab = 'business'"
                    :class="tab === 'business' ? 'bg-white text-pink-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                    class="flex-1 py-3 font-bold rounded-xl transition-all">Business</button>
                <button @click="tab = 'financing'"
                    :class="tab === 'financing' ? 'bg-white text-pink-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                    class="flex-1 py-3 font-bold rounded-xl transition-all">Financing</button>
            </div>

            <div class="p-8">
                {{-- Applicant Tab --}}
                <div x-show="tab === 'applicant'" class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-fadeIn">
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Personal Details
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-slate-500 text-sm">Full Name</span>
                                <span class="text-slate-900 font-bold">{{ $loan->borrower->name }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-slate-500 text-sm">Email</span>
                                <span class="text-slate-900 font-bold">{{ $loan->borrower->email }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-slate-500 text-sm">Account Type</span>
                                <span class="text-slate-900 font-bold uppercase">{{ $loan->borrower->role }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Wallet Info</h3>
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                            <p class="text-xs text-slate-500 mb-2">Connected Address</p>
                            <code
                                class="text-sm font-mono text-slate-800 break-all bg-white p-3 rounded-xl block border border-slate-200">
                                {{ $loan->wallet->wallet_address }}
                            </code>
                            <div class="mt-4 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span
                                    class="text-xs font-bold text-slate-700 uppercase">{{ str_replace('_', ' ', $loan->wallet->type) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Business Tab --}}
                <div x-show="tab === 'business'" class="animate-fadeIn" style="display: none;">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Loan Purpose &
                        Background</h3>
                    <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100">
                        <div class="flex gap-4 mb-6">
                            <div class="p-3 bg-pink-100 text-pink-600 rounded-xl h-fit">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">Application Statement</h4>
                                <p class="text-slate-600 mt-2 leading-relaxed">
                                    {{ $loan->purpose }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 border-t border-slate-200 pt-6">
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Industry</p>
                                <p class="text-slate-800 font-bold mt-1">N/A</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Location</p>
                                <p class="text-slate-800 font-bold mt-1">Malaysia</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Business Age</p>
                                <p class="text-slate-800 font-bold mt-1">New Startup</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Requested At</p>
                                <p class="text-slate-800 font-bold mt-1">{{ $loan->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Financing Tab --}}
                <div x-show="tab === 'financing'" class="animate-fadeIn" style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Contract Terms
                            </h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center bg-slate-50 p-4 rounded-xl">
                                    <span class="text-slate-500 font-medium">Principal Amount</span>
                                    <span class="text-slate-900 font-bold">RM
                                        {{ number_format($loan->amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center bg-slate-50 p-4 rounded-xl">
                                    <span class="text-slate-500 font-medium">Interest Rate</span>
                                    <span class="text-emerald-500 font-bold">0% (Qard Hasan)</span>
                                </div>
                                <div class="flex justify-between items-center bg-slate-50 p-4 rounded-xl">
                                    <span class="text-slate-500 font-medium">Tenure</span>
                                    <span class="text-slate-900 font-bold">{{ $loan->duration_months }} Months</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Repayment
                                Statistics</h3>
                            <div class="bg-indigo-900 rounded-2xl p-6 text-white shadow-xl shadow-indigo-100">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-indigo-300 text-sm">Remaining Balance</span>
                                    <span class="font-bold">RM {{ number_format($loan->remaining_balance, 2) }}</span>
                                </div>
                                <div class="w-full bg-white/10 rounded-full h-2 mb-2">
                                    <div class="bg-blue-400 h-2 rounded-full transition-all duration-1000"
                                        style="width: {{ $loan->progress_percentage }}%"></div>
                                </div>
                                <p class="text-[10px] text-indigo-300 font-bold text-right">
                                    {{ $loan->progress_percentage }}% Recovered</p>
                            </div>
                            @if($loan->admin_remark)
                                <div class="mt-4 p-4 bg-rose-50 border border-rose-100 rounded-xl">
                                    <p class="text-[10px] text-rose-400 font-bold uppercase mb-1">Admin Feedback</p>
                                    <p class="text-sm text-rose-700 italic">"{{ $loan->admin_remark }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reject Modal --}}
        <div x-show="showRejectModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-fadeIn">
            <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl animate-scaleIn">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-rose-100 text-rose-500 rounded-2xl">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-display font-bold text-slate-800">Reject Application</h3>
                        <p class="text-slate-500">Please provide a reason for rejection.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.loans.reject', $loan) }}">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Admin Remark</label>
                        <textarea name="admin_remark" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-rose-200 focus:border-rose-500 transition-all"
                            rows="4" placeholder="e.g. Incomplete business documentation..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="showRejectModal = false"
                            class="flex-1 py-4 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all">Cancel</button>
                        <button type="submit"
                            class="flex-1 py-4 bg-rose-500 text-white font-bold rounded-xl hover:bg-rose-600 transition-all shadow-lg shadow-rose-200">Confirm
                            Reject</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-admin-layout>