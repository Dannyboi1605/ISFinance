<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ISFinance') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#EC4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .bg-cloud {
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #fbcfe8 100%);
            position: relative;
            overflow: hidden;
        }

        .cloud-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cloud relative">
        <!-- Decorative Orbs -->
        <div class="cloud-orb w-96 h-96 bg-primary-200 top-[-10%] left-[-10%] opacity-40"></div>
        <div class="cloud-orb w-[30rem] h-[30rem] bg-pink-100 bottom-[-10%] right-[-10%] opacity-50"></div>
        <div class="cloud-orb w-80 h-80 bg-primary-100 top-[20%] right-[10%] opacity-30"></div>

        <div class="relative z-10 w-full flex flex-col items-center">
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center group">
                    <div
                        class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">ISFinance</h2>
                </a>
            </div>

            <div
                class="w-full sm:max-w-md px-8 py-10 glass shadow-2xl overflow-hidden sm:rounded-[2.5rem] transition-all duration-500">
                {{ $slot }}
            </div>

            <p class="mt-8 text-sm text-gray-500 font-medium">
                &copy; {{ date('Y') }} ISFinance. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>