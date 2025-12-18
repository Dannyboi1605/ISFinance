<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ISFinance - Interest-free Qard Hasan loans made simple and transparent">
    <title>ISFinance - Islamic Microfinance</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
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
        /* Custom animations and utilities */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #EC4899 0%, #db2777 100%);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">

    <!-- ========================================
         HEADER / NAVBAR
         ======================================== -->
    <header class="sticky top-0 z-50 gradient-bg shadow-lg">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="text-white">
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight">ISFinance</h1>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home"
                        class="text-white hover:text-primary-100 transition-colors duration-300 font-medium">
                        Dashboard
                    </a>
                    <a href="#about"
                        class="text-white hover:text-primary-100 transition-colors duration-300 font-medium">
                        About
                    </a>
                    <a href="{{ route('login') }}"
                        class="text-white hover:text-primary-100 transition-colors duration-300 font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-white text-primary-600 px-6 py-2 rounded-lg font-semibold hover:bg-primary-50 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Register
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <div class="flex flex-col space-y-4">
                    <a href="#home"
                        class="text-white hover:text-primary-100 transition-colors duration-300 font-medium">
                        Dashboard
                    </a>
                    <a href="#about"
                        class="text-white hover:text-primary-100 transition-colors duration-300 font-medium">
                        About
                    </a>
                    <a href="{{ route('login') }}"
                        class="text-white hover:text-primary-100 transition-colors duration-300 font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-white text-primary-600 px-6 py-2 rounded-lg font-semibold hover:bg-primary-50 transition-all duration-300 text-center">
                        Register
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- ========================================
         MAIN CONTENT
         ======================================== -->
    <main>

        <!-- ========================================
             HERO SECTION
             ======================================== -->
        <section id="home" class="relative bg-gradient-to-br from-primary-50 to-white py-20 md:py-32">
            <div class="container mx-auto px-6">
                <div class="grid md:grid-cols-2 gap-12 items-center">

                    <!-- Hero Text Content -->
                    <div class="animate-fadeInUp">
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                            Welcome to <span class="text-primary-600">ISFinance</span>
                        </h2>
                        <p class="text-lg md:text-xl text-gray-600 mb-8 leading-relaxed">
                            Interest-free Qard Hasan loans made simple and transparent
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center px-8 py-4 bg-primary-600 text-white font-semibold rounded-lg shadow-lg hover:bg-primary-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary-600 font-semibold rounded-lg border-2 border-primary-600 shadow-md hover:bg-primary-50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                                Register
                            </a>
                        </div>
                    </div>

                    <!-- Hero Image -->
                    <div class="hidden md:block animate-fadeInUp">
                        <div class="relative">
                            <div class="absolute inset-0 bg-primary-200 rounded-3xl transform rotate-3 opacity-20">
                            </div>
                            <img src="https://via.placeholder.com/600x500/EC4899/FFFFFF?text=Islamic+Finance"
                                alt="Islamic Finance Illustration"
                                class="relative rounded-3xl shadow-2xl w-full h-auto transform hover:scale-105 transition-transform duration-500">
                        </div>
                    </div>

                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white to-transparent"></div>
        </section>

        <!-- ========================================
             FEATURES / INFO SECTION
             ======================================== -->
        <section id="about" class="py-20 bg-white">
            <div class="container mx-auto px-6">

                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Why Choose ISFinance?
                    </h3>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Experience a modern, transparent, and Shariah-compliant microfinance platform
                    </p>
                </div>

                <!-- Feature Cards -->
                <div class="grid md:grid-cols-3 gap-8">

                    <!-- Feature Card 1: Apply for Loans -->
                    <div
                        class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-gray-100 hover:border-primary-300 transform hover:-translate-y-2">
                        <div
                            class="bg-primary-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary-600 transition-colors duration-300">
                            <svg class="w-8 h-8 text-primary-600 group-hover:text-white transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Apply for Loans</h4>
                        <p class="text-gray-600 leading-relaxed">
                            Submit your Qard Hasan loan application easily with our streamlined process. Get quick
                            responses and transparent terms.
                        </p>
                    </div>

                    <!-- Feature Card 2: Track Repayments -->
                    <div
                        class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-gray-100 hover:border-primary-300 transform hover:-translate-y-2">
                        <div
                            class="bg-primary-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary-600 transition-colors duration-300">
                            <svg class="w-8 h-8 text-primary-600 group-hover:text-white transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Track Repayments</h4>
                        <p class="text-gray-600 leading-relaxed">
                            Monitor your repayment schedule, view payment history, and manage your loan obligations with
                            complete transparency.
                        </p>
                    </div>

                    <!-- Feature Card 3: Admin Dashboard -->
                    <div
                        class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-gray-100 hover:border-primary-300 transform hover:-translate-y-2">
                        <div
                            class="bg-primary-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary-600 transition-colors duration-300">
                            <svg class="w-8 h-8 text-primary-600 group-hover:text-white transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Admin Approval Dashboard</h4>
                        <p class="text-gray-600 leading-relaxed">
                            Administrators can efficiently review, approve, and manage loan applications with our
                            comprehensive dashboard.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================
             ADDITIONAL INFO SECTION (Optional)
             ======================================== -->
        <section class="py-20 bg-gradient-to-br from-primary-50 to-white">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl mx-auto text-center">
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Built on Islamic Principles
                    </h3>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        ISFinance is committed to providing financial services that are fully compliant with Shariah
                        principles.
                        Our Qard Hasan (benevolent loan) model ensures zero interest, promoting social welfare and
                        economic justice
                        within the community.
                    </p>
                    <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-700">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">100% Interest-Free</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Shariah Compliant</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Transparent Process</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Community Focused</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- ========================================
         FOOTER
         ======================================== -->
    <footer class="bg-gray-100 py-8">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <p class="text-gray-600 mb-2">
                    &copy; 2025 ISFinance. All rights reserved.
                </p>
                <p class="text-sm text-gray-500">
                    Team Members: Development Team
                </p>
            </div>
        </div>
    </footer>

    <!-- ========================================
         JAVASCRIPT
         ======================================== -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>

</body>

</html>