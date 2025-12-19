<div
    class="flex flex-col h-full bg-slate-900 w-64 fixed left-0 top-0 overflow-y-auto z-50 text-white shadow-2xl transition-all duration-300">
    <!-- Logo Section -->
    <div class="flex items-center justify-center h-20 border-b border-slate-800 bg-slate-900/50 backdrop-blur-sm">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
            <div
                class="relative w-10 h-10 flex items-center justify-center bg-gradient-to-br from-pink-500 to-purple-600 rounded-xl shadow-lg group-hover:shadow-pink-500/20 transition-all duration-300">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">
                ISFinance
            </span>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-8 space-y-2">
        @php
            $menuItems = [
                ['name' => 'Dashboard', 'route' => 'borrower.dashboard', 'icon' => 'home'],
                ['name' => 'Transactions', 'route' => 'borrower.loans.index', 'icon' => 'clipboard-list'],
                ['name' => 'My Wallet', 'route' => 'borrower.wallet.setup', 'icon' => 'wallet'],
                ['name' => 'Profile', 'route' => 'profile.edit', 'icon' => 'user'],
                ['name' => 'Help', 'route' => 'home', 'icon' => 'question-mark-circle'], // Placeholder route
            ];
        @endphp

        @foreach ($menuItems as $item)
            @php
                $isActive = request()->routeIs($item['route']) || (isset($item['match']) && request()->is($item['match']));
            @endphp
            <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
                   {{ $isActive
            ? 'bg-pink-500/10 text-pink-400 shadow-[0_0_15px_rgba(236,72,153,0.1)] border border-pink-500/20'
            : 'text-slate-400 hover:bg-slate-800/50 hover:text-white hover:translate-x-1' 
                   }}">

                {{-- Icons (Heroicons) --}}
                @if($item['icon'] === 'home')
                    <svg class="w-5 h-5 {{ $isActive ? 'text-pink-400' : 'text-slate-500 group-hover:text-white' }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                @elseif($item['icon'] === 'clipboard-list')
                    <svg class="w-5 h-5 {{ $isActive ? 'text-pink-400' : 'text-slate-500 group-hover:text-white' }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                @elseif($item['icon'] === 'wallet')
                    <svg class="w-5 h-5 {{ $isActive ? 'text-pink-400' : 'text-slate-500 group-hover:text-white' }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                @elseif($item['icon'] === 'user')
                    <svg class="w-5 h-5 {{ $isActive ? 'text-pink-400' : 'text-slate-500 group-hover:text-white' }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                @elseif($item['icon'] === 'question-mark-circle')
                    <svg class="w-5 h-5 {{ $isActive ? 'text-pink-400' : 'text-slate-500 group-hover:text-white' }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif

                <span class="font-medium tracking-wide">{{ $item['name'] }}</span>

                @if($isActive)
                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-pink-500 shadow-[0_0_8px_#ec4899]"></div>
                @endif
            </a>
        @endforeach
    </nav>

    <!-- Logout Button -->
    <div class="p-4 border-t border-slate-800 bg-slate-900/50 backdrop-blur-sm">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors duration-300 border border-transparent hover:border-red-500/20 group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="font-semibold">Log Out</span>
            </button>
        </form>
    </div>
</div>