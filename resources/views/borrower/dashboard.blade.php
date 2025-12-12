<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Borrower Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Dashboard Heading --}}
                    <h3 class="text-2xl font-bold text-primary-600 mb-4">
                        Borrower Dashboard
                    </h3>

                    {{-- Welcome Message --}}
                    <p class="text-lg text-gray-700 mb-6">
                        Welcome, <span class="font-semibold">{{ auth()->user()->name }}</span>! This is your dashboard.
                    </p>

                    {{-- Dashboard Content Placeholder --}}
                    <div class="grid md:grid-cols-3 gap-6 mt-8">

                        {{-- Card 1: Apply for Loan --}}
                        <div
                            class="bg-primary-50 border border-primary-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <svg class="w-8 h-8 text-primary-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-bold text-gray-800">Apply for Loan</h4>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                Submit a new Qard Hasan loan application
                            </p>
                            <button
                                class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors duration-300 font-semibold">
                                Coming Soon
                            </button>
                        </div>

                        {{-- Card 2: My Loans --}}
                        <div
                            class="bg-primary-50 border border-primary-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <svg class="w-8 h-8 text-primary-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-bold text-gray-800">My Loans</h4>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                View your active and past loan applications
                            </p>
                            <button
                                class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors duration-300 font-semibold">
                                Coming Soon
                            </button>
                        </div>

                        {{-- Card 3: Repayment Schedule --}}
                        <div
                            class="bg-primary-50 border border-primary-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <svg class="w-8 h-8 text-primary-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-bold text-gray-800">Repayments</h4>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                Track your repayment schedule and history
                            </p>
                            <button
                                class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors duration-300 font-semibold">
                                Coming Soon
                            </button>
                        </div>

                    </div>

                    {{-- Info Message --}}
                    <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Note:</strong> Loan application and repayment features are currently under
                                    development and will be available soon.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>