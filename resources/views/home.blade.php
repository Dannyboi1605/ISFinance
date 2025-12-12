<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-primary-50 via-white to-primary-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ========================================
            HERO / WELCOME SECTION
            ======================================== --}}
            <div class="text-center mb-12 px-4 animate-fadeInUp">
                {{-- Welcome Heading --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Welcome, <span class="text-primary-600">{{ auth()->user()->name }}</span>!
                </h1>

                {{-- Subheading --}}
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Here's a quick overview of your loans and repayments
                </p>
            </div>

            {{-- ========================================
            QUICK STATS CARDS - ROLE-BASED
            ======================================== --}}

            {{-- BORROWER STATS --}}
            @if(auth()->user()->role === 'borrower')
                <div class="grid md:grid-cols-3 gap-6 mb-12 px-4">

                    {{-- Card 1: Total Loans --}}
                    <div
                        class="card-hover bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-primary-600">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Loans</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">3</p>
                            </div>
                            <div class="bg-primary-100 p-4 rounded-full">
                                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">All-time loan applications</p>
                    </div>

                    {{-- Card 2: Active Loans --}}
                    <div
                        class="card-hover bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-green-600">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Active Loans</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">2</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-full">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Currently active loans</p>
                    </div>

                    {{-- Card 3: Total Repaid --}}
                    <div
                        class="card-hover bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-blue-600">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Repaid</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">RM 1,500</p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded-full">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Total amount repaid</p>
                    </div>

                </div>

                {{-- BORROWER ACTION BUTTONS --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12 px-4">
                    {{-- Apply for New Loan Button --}}
                    <a href="/borrower/loans/create"
                        class="inline-flex items-center justify-center px-8 py-4 bg-primary-600 text-white font-semibold rounded-lg shadow-lg hover:bg-primary-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Apply for New Loan
                    </a>

                    {{-- View Repayment Schedule Button --}}
                    <a href="/borrower/repayments"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary-600 font-semibold rounded-lg border-2 border-primary-600 shadow-md hover:bg-primary-50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        View Repayment Schedule
                    </a>
                </div>

                {{-- ADMIN STATS --}}
            @elseif(auth()->user()->role === 'admin')
                <div class="grid md:grid-cols-3 gap-6 mb-12 px-4">

                    {{-- Card 1: Pending Approvals --}}
                    <div
                        class="card-hover bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-yellow-600">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Pending Approvals</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">5</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-full">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Awaiting your review</p>
                    </div>

                    {{-- Card 2: Total Loans Approved --}}
                    <div
                        class="card-hover bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-green-600">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Loans Approved</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">10</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-full">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Total approved applications</p>
                    </div>

                    {{-- Card 3: Total Repayments Received --}}
                    <div
                        class="card-hover bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-primary-600">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Repayments Received</p>
                                <p class="text-4xl font-bold text-gray-900 mt-2">RM 5,000</p>
                            </div>
                            <div class="bg-primary-100 p-4 rounded-full">
                                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Total repayments collected</p>
                    </div>

                </div>

                {{-- ADMIN ACTION BUTTONS --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12 px-4">
                    {{-- Approve Loans Button --}}
                    <a href="/admin/pending-loans"
                        class="inline-flex items-center justify-center px-8 py-4 bg-primary-600 text-white font-semibold rounded-lg shadow-lg hover:bg-primary-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Approve Loans
                    </a>

                    {{-- Track Repayments Button --}}
                    <a href="/admin/repayments"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary-600 font-semibold rounded-lg border-2 border-primary-600 shadow-md hover:bg-primary-50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        Track Repayments
                    </a>
                </div>
            @endif

            {{-- ========================================
            RECENT ACTIVITY / SMART CONTRACT SIMULATION
            ======================================== --}}
            <div class="card-hover bg-white rounded-xl shadow-lg p-6 mb-8 mx-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Recent Activity</h3>
                    <span class="bg-primary-100 text-primary-600 text-xs font-semibold px-3 py-1 rounded-full">
                        Live
                    </span>
                </div>

                {{-- Activity Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Activity
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tx Hash
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Sample Activity 1 --}}
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    2025-12-10
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Loan Application
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    RM 2,000
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-mono">
                                    0x7a3f...9b2c
                                </td>
                            </tr>

                            {{-- Sample Activity 2 --}}
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    2025-12-08
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Repayment
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    RM 500
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Completed
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-mono">
                                    0x4e1d...5a8f
                                </td>
                            </tr>

                            {{-- Sample Activity 3 --}}
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    2025-12-05
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Loan Application
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    RM 1,500
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-mono">
                                    0x9c2b...3e7a
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Blockchain Info Note --}}
                <div class="mt-6 bg-indigo-50 border-l-4 border-indigo-400 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-indigo-700">
                                <strong>Smart Contract Simulation:</strong> Transaction hashes shown above are simulated
                                blockchain records.
                                In production, these will link to actual smart contract transactions on the blockchain.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================
            FOOTER
            ======================================== --}}
            <footer class="text-center py-6 px-4">
                <p class="text-sm text-gray-500">
                    &copy; 2025 ISFinance. All rights reserved.
                </p>
            </footer>

        </div>
    </div>
</x-app-layout>