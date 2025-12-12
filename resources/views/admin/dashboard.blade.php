<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Dashboard Heading --}}
                    <h3 class="text-2xl font-bold text-primary-600 mb-4">
                        Admin Dashboard
                    </h3>

                    {{-- Welcome Message --}}
                    <p class="text-lg text-gray-700 mb-6">
                        Welcome, <span class="font-semibold">{{ auth()->user()->name }}</span>! This is your admin
                        dashboard.
                    </p>

                    {{-- Dashboard Content Placeholder --}}
                    <div class="grid md:grid-cols-3 gap-6 mt-8">

                        {{-- Card 1: Pending Applications --}}
                        <div
                            class="bg-primary-50 border border-primary-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <svg class="w-8 h-8 text-primary-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="text-lg font-bold text-gray-800">Pending Applications</h4>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                Review and approve loan applications
                            </p>
                            <div class="text-3xl font-bold text-primary-600 mb-4">0</div>
                            <button
                                class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors duration-300 font-semibold">
                                Coming Soon
                            </button>
                        </div>

                        {{-- Card 2: Approved Loans --}}
                        <div
                            class="bg-green-50 border border-green-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="text-lg font-bold text-gray-800">Approved Loans</h4>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                View all approved loan applications
                            </p>
                            <div class="text-3xl font-bold text-green-600 mb-4">0</div>
                            <button
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-300 font-semibold">
                                Coming Soon
                            </button>
                        </div>

                        {{-- Card 3: Rejected Applications --}}
                        <div
                            class="bg-red-50 border border-red-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="text-lg font-bold text-gray-800">Rejected Applications</h4>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                View rejected loan applications
                            </p>
                            <div class="text-3xl font-bold text-red-600 mb-4">0</div>
                            <button
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-300 font-semibold">
                                Coming Soon
                            </button>
                        </div>

                    </div>

                    {{-- Statistics Section --}}
                    <div class="mt-8">
                        <h4 class="text-xl font-bold text-gray-800 mb-4">System Statistics</h4>
                        <div class="grid md:grid-cols-4 gap-4">

                            {{-- Total Users --}}
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-600 mb-2">Total Users</p>
                                <p class="text-2xl font-bold text-blue-600">0</p>
                            </div>

                            {{-- Total Borrowers --}}
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-600 mb-2">Total Borrowers</p>
                                <p class="text-2xl font-bold text-purple-600">0</p>
                            </div>

                            {{-- Total Loan Amount --}}
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-600 mb-2">Total Loan Amount</p>
                                <p class="text-2xl font-bold text-yellow-600">RM 0</p>
                            </div>

                            {{-- Active Loans --}}
                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-600 mb-2">Active Loans</p>
                                <p class="text-2xl font-bold text-indigo-600">0</p>
                            </div>

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
                                    <strong>Note:</strong> Loan approval and management features are currently under
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