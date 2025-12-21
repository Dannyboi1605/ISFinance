<div
    class="flex flex-col h-full bg-gradient-to-b from-pink-500 to-rose-600 w-64 fixed left-0 top-0 overflow-y-auto z-50 text-white shadow-2xl transition-all duration-300">
    <!-- Logo Section -->
    <div class="flex items-center justify-center h-20 border-b border-white/10 bg-white/5 backdrop-blur-md">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
            <div
                class="relative w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-lg transition-all duration-300">
                <svg class="w-6 h-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-2xl font-bold text-white">
                Admin Panel
            </span>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-8 space-y-2">
        @php
            $menuItems = [
                ['name' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'home'],
                ['name' => 'Pending Applications', 'route' => 'admin.loans.index', 'params' => ['status' => 'pending'], 'icon' => 'clock'],
                ['name' => 'Disbursements', 'route' => 'admin.loans.index', 'params' => ['status' => 'approved'], 'icon' => 'cash'],
                ['name' => 'Active Monitoring', 'route' => 'admin.loans.index', 'params' => ['status' => 'disbursed'], 'icon' => 'presentation-chart-line'],
                ['name' => 'User Management', 'route' => 'admin.users.index', 'icon' => 'users'],
            ];
        @endphp

        @foreach ($menuItems as $item)
            @php
                $isActive = request()->routeIs($item['route']) &&
                    (!isset($item['params']['status']) || request('status') == $item['params']['status']);
            @endphp
            <a href="{{ route($item['route'], $item['params'] ?? []) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
                           {{ $isActive
            ? 'bg-white text-pink-600 shadow-lg'
            : 'text-white/80 hover:bg-white/10 hover:text-white hover:translate-x-1' 
                           }}">

                {{-- Icons --}}
                @if($item['icon'] === 'home')
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                @elseif($item['icon'] === 'clock')
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif($item['icon'] === 'cash')
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                @elseif($item['icon'] === 'presentation-chart-line')
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                @elseif($item['icon'] === 'users')
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                @endif

                <span class="font-medium tracking-wide">{{ $item['name'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Logout Button -->
    <div class="p-4 border-t border-white/10 bg-black/10 backdrop-blur-md">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-colors duration-300 border border-transparent hover:border-white/20 group">
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