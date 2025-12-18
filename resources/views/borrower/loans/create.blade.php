<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply for Loan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-primary-50 via-white to-primary-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Qard Hasan Loan Application</h1>
                <p class="text-gray-600">0% Interest • Islamic Microfinance</p>
            </div>

            {{-- Credit Available Badge --}}
            <div class="bg-white rounded-xl shadow-md p-4 mb-8 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Available Credit</p>
                    <p class="text-2xl font-bold text-green-600">RM
                        {{ number_format($eligibility['available_credit'], 2) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Active Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $eligibility['active_loan_count'] }} /
                        {{ $eligibility['max_active_loans'] }}</p>
                </div>
            </div>

            {{-- Error Messages --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Application Form --}}
            <form method="POST" action="{{ route('borrower.loans.store') }}"
                class="bg-white rounded-2xl shadow-xl overflow-hidden" x-data="{ step: 1 }">
                @csrf

                {{-- Progress Steps --}}
                <div class="bg-gray-50 px-8 py-4 border-b">
                    <div class="flex items-center justify-between">
                        <button type="button" @click="step = 1"
                            :class="step >= 1 ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-600'"
                            class="w-10 h-10 rounded-full font-bold transition-colors">1</button>
                        <div class="flex-1 h-1 mx-2" :class="step >= 2 ? 'bg-primary-600' : 'bg-gray-200'"></div>
                        <button type="button" @click="step = 2"
                            :class="step >= 2 ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-600'"
                            class="w-10 h-10 rounded-full font-bold transition-colors">2</button>
                        <div class="flex-1 h-1 mx-2" :class="step >= 3 ? 'bg-primary-600' : 'bg-gray-200'"></div>
                        <button type="button" @click="step = 3"
                            :class="step >= 3 ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-600'"
                            class="w-10 h-10 rounded-full font-bold transition-colors">3</button>
                    </div>
                    <div class="flex justify-between mt-2 text-xs text-gray-500">
                        <span>Personal</span>
                        <span>Employment</span>
                        <span>Financing</span>
                    </div>
                </div>

                <div class="p-8">
                    {{-- Step 1: Personal Information --}}
                    <div x-show="step === 1" x-transition>
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Personal Information</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                <input type="text" value="{{ auth()->user()->name }}" disabled
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl text-gray-700">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <input type="email" value="{{ auth()->user()->email }}" disabled
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl text-gray-700">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Identity Card (IC)
                                    Number</label>
                                <input type="text" placeholder="e.g., 900101-01-1234"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" placeholder="e.g., 012-3456789"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="button" @click="step = 2"
                                class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-colors">
                                Next: Employment →
                            </button>
                        </div>
                    </div>

                    {{-- Step 2: Employment Information --}}
                    <div x-show="step === 2" x-transition x-cloak>
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Employment Information</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Employment Status</label>
                                <select
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                                    <option value="">Select status...</option>
                                    <option value="employed">Employed</option>
                                    <option value="self_employed">Self-Employed</option>
                                    <option value="student">Student</option>
                                    <option value="unemployed">Unemployed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Monthly Income
                                    (RM)</label>
                                <select
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                                    <option value="">Select range...</option>
                                    <option value="below_1000">Below RM 1,000</option>
                                    <option value="1000_3000">RM 1,000 - RM 3,000</option>
                                    <option value="3000_5000">RM 3,000 - RM 5,000</option>
                                    <option value="5000_10000">RM 5,000 - RM 10,000</option>
                                    <option value="above_10000">Above RM 10,000</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Employer Name
                                    (Optional)</label>
                                <input type="text" placeholder="Company or Business Name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" @click="step = 1"
                                class="px-8 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition-colors">
                                ← Back
                            </button>
                            <button type="button" @click="step = 3"
                                class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-colors">
                                Next: Financing →
                            </button>
                        </div>
                    </div>

                    {{-- Step 3: Financing Details --}}
                    <div x-show="step === 3" x-transition x-cloak>
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Financing Details</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Loan Amount
                                    (RM) *</label>
                                <select name="amount" id="amount" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 @error('amount') border-red-500 @enderror">
                                    <option value="">Select amount...</option>
                                    @foreach($loanAmounts as $amount)
                                        @if($amount <= $eligibility['available_credit'])
                                            <option value="{{ $amount }}" {{ old('amount') == $amount ? 'selected' : '' }}>
                                                RM {{ number_format($amount) }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="duration_months"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Repayment Duration *</label>
                                <select name="duration_months" id="duration_months" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 @error('duration_months') border-red-500 @enderror">
                                    <option value="">Select duration...</option>
                                    @foreach($durations as $duration)
                                        <option value="{{ $duration }}" {{ old('duration_months') == $duration ? 'selected' : '' }}>
                                            {{ $duration }} months
                                        </option>
                                    @endforeach
                                </select>
                                @error('duration_months')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="purpose" class="block text-sm font-semibold text-gray-700 mb-2">Purpose of
                                    Loan *</label>
                                <textarea name="purpose" id="purpose" rows="4" required
                                    placeholder="Describe why you need this loan..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 @error('purpose') border-red-500 @enderror">{{ old('purpose') }}</textarea>
                                @error('purpose')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Qard Hasan Info --}}
                        <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-green-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-green-800 font-semibold">Qard Hasan - Interest-Free Loan</p>
                                    <p class="text-sm text-green-700 mt-1">This is an Islamic benevolent loan with 0%
                                        interest. You only repay the principal amount.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" @click="step = 2"
                                class="px-8 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition-colors">
                                ← Back
                            </button>
                            <button type="submit"
                                class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-lg hover:shadow-xl">
                                Submit Application
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Back Link --}}
            <div class="mt-6 text-center">
                <a href="{{ route('borrower.dashboard') }}"
                    class="text-gray-600 hover:text-primary-600 transition-colors">
                    ← Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>