<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loan Management') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-primary-50 via-white to-primary-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Loan Applications</h1>
                    <p class="text-gray-600">Review and manage all loan applications</p>
                </div>
            </div>

            {{-- Status Filter Tabs --}}
            <div class="bg-white rounded-xl shadow-md mb-6 p-2">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.loans.index', ['status' => 'pending']) }}"
                        class="px-4 py-2 rounded-lg font-semibold transition-colors {{ $currentStatus === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'text-gray-600 hover:bg-gray-100' }}">
                        Pending ({{ $stats['pending'] }})
                    </a>
                    <a href="{{ route('admin.loans.index', ['status' => 'approved']) }}"
                        class="px-4 py-2 rounded-lg font-semibold transition-colors {{ $currentStatus === 'approved' ? 'bg-blue-100 text-blue-800' : 'text-gray-600 hover:bg-gray-100' }}">
                        Approved ({{ $stats['approved'] }})
                    </a>
                    <a href="{{ route('admin.loans.index', ['status' => 'disbursed']) }}"
                        class="px-4 py-2 rounded-lg font-semibold transition-colors {{ $currentStatus === 'disbursed' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:bg-gray-100' }}">
                        Disbursed ({{ $stats['disbursed'] }})
                    </a>
                    <a href="{{ route('admin.loans.index', ['status' => 'completed']) }}"
                        class="px-4 py-2 rounded-lg font-semibold transition-colors {{ $currentStatus === 'completed' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:bg-gray-100' }}">
                        Completed ({{ $stats['completed'] }})
                    </a>
                    <a href="{{ route('admin.loans.index', ['status' => 'rejected']) }}"
                        class="px-4 py-2 rounded-lg font-semibold transition-colors {{ $currentStatus === 'rejected' ? 'bg-red-100 text-red-800' : 'text-gray-600 hover:bg-gray-100' }}">
                        Rejected ({{ $stats['rejected'] }})
                    </a>
                    <a href="{{ route('admin.loans.index', ['status' => 'all']) }}"
                        class="px-4 py-2 rounded-lg font-semibold transition-colors {{ $currentStatus === 'all' ? 'bg-primary-100 text-primary-800' : 'text-gray-600 hover:bg-gray-100' }}">
                        All
                    </a>
                </div>
            </div>

            {{-- Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Loans Table --}}
            @if($loans->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Borrower</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Duration</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Applied</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loans as $loan)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold text-gray-900">#{{ $loan->id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $loan->borrower->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $loan->borrower->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-bold text-gray-900">RM {{ number_format($loan->amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                        {{ $loan->duration_months }} months
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                            @if($loan->status === 'completed') bg-green-100 text-green-800
                                                            @elseif($loan->status === 'disbursed') bg-blue-100 text-blue-800
                                                            @elseif($loan->status === 'approved') bg-yellow-100 text-yellow-800
                                                            @elseif($loan->status === 'pending') bg-gray-100 text-gray-800
                                                            @else bg-red-100 text-red-800
                                                            @endif">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">
                                        {{ $loan->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('admin.loans.show', $loan) }}"
                                            class="text-primary-600 hover:text-primary-800 font-semibold text-sm">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $loans->appends(['status' => $currentStatus])->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Loans Found</h3>
                    <p class="text-gray-600">No {{ $currentStatus !== 'all' ? $currentStatus : '' }} loans to display.</p>
                </div>
            @endif

        </div>
    </div>
</x-admin-layout>