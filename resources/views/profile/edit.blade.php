@php
    $layout = auth()->user()->role === 'admin' ? 'admin-layout' : 'borrower-layout';
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        User Profile
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8 animate-fadeIn">

        {{-- Profile Hero --}}
        <div
            class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-slate-800 p-10 text-white shadow-2xl">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-pink-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex items-center gap-8">
                <div
                    class="w-24 h-24 bg-gradient-to-tr from-pink-500 to-rose-600 rounded-3xl flex items-center justify-center text-3xl font-bold shadow-xl shadow-pink-500/20">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-display font-bold tracking-tight">{{ auth()->user()->name }}</h1>
                    <p class="text-slate-400 mt-1 uppercase text-[10px] font-bold tracking-[0.2em]">Member since
                        {{ auth()->user()->created_at->format('M Y') }}</p>
                    <div class="mt-4 flex gap-2">
                        <span
                            class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg text-[10px] font-bold uppercase tracking-widest border border-white/10">
                            {{ ucfirst(auth()->user()->role) }} Account
                        </span>
                        <span
                            class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-emerald-500/20">
                            Verified Status
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8">
            {{-- Profile Information Card --}}
            <div
                class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-10 transform transition-all hover:shadow-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password Card --}}
            <div
                class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-10 transform transition-all hover:shadow-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Danger Zone Card --}}
            <div
                class="bg-rose-50 rounded-[2.5rem] shadow-xl shadow-rose-100/50 border border-rose-100 p-10 border-dashed">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>