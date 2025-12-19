<x-admin-layout>
    <x-slot name="header">
        Admin Overview
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8 animate-fadeIn">

        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden rounded-[2.5rem] bg-slate-900 p-10 text-white shadow-2xl">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-pink-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <h1 class="text-4xl font-display font-bold tracking-tight">System Control Center</h1>
                    <p class="text-slate-400 mt-2 text-lg">Monitoring <span
                            class="text-pink-400 font-bold">{{ $stats['total_users'] }} active borrowers</span> in the
                        Qard Hasan ecosystem.</p>
                </div>
                <div class="flex gap-4">
                    <div
                        class="bg-white/5 backdrop-blur-md p-6 rounded-3xl border border-white/10 text-center min-w-[140px]">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Vault</p>
                        <p class="text-2xl font-bold">RM {{ number_format($stats['total_disbursed'], 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-100/50 border border-slate-50 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-110 transition-transform">
                    <svg class="w-16 h-16 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Pending Review</p>
                <p class="text-4xl font-display font-bold text-slate-900">{{ $stats['pending'] }}</p>
                <div class="mt-4 flex items-center gap-2 text-amber-500 text-xs font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    Awaiting Action
                </div>
            </div>

            <div
                class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-100/50 border border-slate-50 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-110 transition-transform">
                    <svg class="w-16 h-16 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Approved Queue</p>
                <p class="text-4xl font-display font-bold text-slate-900">{{ $stats['approved'] }}</p>
                <div class="mt-4 flex items-center gap-2 text-sky-500 text-xs font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                    Ready to Disburse
                </div>
            </div>

            <div
                class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-100/50 border border-slate-50 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-110 transition-transform">
                    <svg class="w-16 h-16 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Active Loans</p>
                <p class="text-4xl font-display font-bold text-slate-900">{{ $stats['disbursed'] }}</p>
                <div class="mt-4 flex items-center gap-2 text-emerald-500 text-xs font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Performance Healthy
                </div>
            </div>

            <div
                class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-100/50 border border-slate-50 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-110 transition-transform">
                    <svg class="w-16 h-16 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Total Users</p>
                <p class="text-4xl font-display font-bold text-slate-900">{{ $stats['total_users'] }}</p>
                <div class="mt-4 flex items-center gap-2 text-indigo-500 text-xs font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                    Verified Identities
                </div>
            </div>
        </div>

        {{-- Main Navigation Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <a href="{{ route('admin.loans.index', ['status' => 'pending']) }}"
                class="group bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-100/50 border border-slate-100 hover:border-pink-500/20 transition-all flex flex-col justify-between min-h-[240px]">
                <div
                    class="w-14 h-14 bg-amber-50 border border-amber-100 rounded-2xl flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-all">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-pink-600 transition-colors">Pending
                        Reviews</h3>
                    <p class="text-slate-500 mt-2 text-sm leading-relaxed">Identity verification and loan feasibility
                        assessment for {{ $stats['pending'] }} applications.</p>
                </div>
            </a>

            <a href="{{ route('admin.loans.index', ['status' => 'approved']) }}"
                class="group bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-100/50 border border-slate-100 hover:border-pink-500/20 transition-all flex flex-col justify-between min-h-[240px]">
                <div
                    class="w-14 h-14 bg-sky-50 border border-sky-100 rounded-2xl flex items-center justify-center text-sky-500 group-hover:bg-sky-500 group-hover:text-white transition-all">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-pink-600 transition-colors">
                        Disbursement Queue</h3>
                    <p class="text-slate-500 mt-2 text-sm leading-relaxed">Process blockchain smart contract deployments
                        for {{ $stats['approved'] }} approved contracts.</p>
                </div>
            </a>

            <div
                class="bg-gradient-to-br from-pink-500 to-rose-600 p-8 rounded-[2.5rem] shadow-xl shadow-pink-100 text-white flex flex-col justify-between min-h-[240px] relative overflow-hidden group">
                <div
                    class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000">
                </div>
                <div>
                    <h3 class="text-xl font-bold">Protocol Health</h3>
                    <p class="text-pink-100 mt-2 text-sm leading-relaxed">System is running on simulated Mainnet.
                        Performance and Shariah compliance checks are active.</p>
                </div>
                <button
                    class="w-full py-4 bg-white/20 backdrop-blur-md border border-white/20 rounded-2xl font-bold text-sm hover:bg-white hover:text-pink-600 transition-all">Generate
                    Report</button>
            </div>
        </div>

    </div>
</x-admin-layout>