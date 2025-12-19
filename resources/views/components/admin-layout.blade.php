<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ISFinance') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <div class="min-h-screen flex">

        <!-- Sidebar (Fixed) -->
        <div class="w-64 flex-shrink-0">
            <x-sidebar-admin />
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen relative">

            <!-- Page Header (Top Bar) -->
            <header class="bg-white/80 backdrop-blur-md sticky top-0 z-30 border-b border-slate-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                    <!-- Title/Breadcrumb -->
                    <h2 class="text-xl font-display font-bold text-slate-800">
                        {{ $header ?? 'Admin Dashboard' }}
                    </h2>

                    <!-- Right Actions -->
                    <div class="flex items-center gap-4">
                        <span
                            class="text-xs font-bold text-pink-600 bg-pink-100 px-3 py-1 rounded-full uppercase tracking-wider">Administrator</span>
                        <!-- Profile Avatar -->
                        <div class="relative">
                            <div
                                class="h-10 w-10 rounded-full bg-gradient-to-tr from-pink-400 to-rose-600 p-0.5 cursor-pointer hover:shadow-lg transition-shadow">
                                <div
                                    class="h-full w-full rounded-full bg-slate-800 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <x-footer />
        </div>
    </div>
</body>

</html>