<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-primary-50 via-white to-primary-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Section --}}
            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    Welcome, <span class="text-primary-600">{{ auth()->user()->name }}</span>
                </h1>
                <p class="text-gray-600">ISFinance Administration Panel</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">Approved</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['approved'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Disbursed</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['disbursed'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-gray-500">
                    <p class="text-sm text-gray-500">Completed</p>
                    <p class="text-3xl font-bold text-gray-600">{{ $stats['completed'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500">Total Borrowers</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-primary-500">
                    <p class="text-sm text-gray-500">Total Disbursed</p>
                    <p class="text-2xl font-bold text-primary-600">RM
                        {{ number_format($stats['total_disbursed'] ?? 0, 0) }}</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid md:grid-cols-3 gap-6 mb-10">
                <a href="{{ route('admin.loans.index', ['status' => 'pending']) }}"
                    class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow border-l-4 border-yellow-500 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Pending Approvals</h3>
                            <p class="text-gray-600 text-sm">Review loan applications</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full group-hover:bg-yellow-200 transition-colors">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    @if(($stats['pending'] ?? 0) > 0)
                        <div
                            class="mt-4 inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full">
                            {{ $stats['pending'] }} awaiting review
                        </div>
                    @endif
                </a>

                <a href="{{ route('admin.loans.index', ['status' => 'approved']) }}"
                    class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow border-l-4 border-blue-500 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Ready for Disbursement</h3>
                            <p class="text-gray-600 text-sm">Approved loans pending disbursement</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full group-hover:bg-blue-200 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    @if(($stats['approved'] ?? 0) > 0)
                        <div
                            class="mt-4 inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                            {{ $stats['approved'] }} ready to disburse
                        </div>
                    @endif
                </a>

                <a href="{{ route('admin.loans.index', ['status' => 'all']) }}"
                    class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow border-l-4 border-gray-500 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">All Loans</h3>
                            <p class="text-gray-600 text-sm">View complete loan history</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-full group-hover:bg-gray-200 transition-colors">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Info Box --}}
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-blue-700">
                        <strong>ISFinance Admin:</strong> This is a prototype demonstration. All blockchain transactions
                        are simulated.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>