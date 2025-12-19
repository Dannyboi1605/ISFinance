<x-borrower-layout>
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
                        {{ number_format($eligibility['available_credit'], 2) }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Active Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $eligibility['active_loan_count'] }} /
                        {{ $eligibility['max_active_loans'] }}
                    </p>
                </div>
            </div>

            {{-- Error Messages --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Application Form --}}
            <div x-data="{ 
                step: 1, 
                formData: {
                    full_name: '{{ auth()->user()->name }}',
                    ic_number: '',
                    phone: '',
                    employment_status: '',
                    income: '',
                    amount: '',
                    duration_months: '',
                    purpose: ''
                },
                validateStep(currentStep) {
                    if (currentStep === 1) {
                        if (!this.formData.full_name || !this.formData.ic_number) {
                            alert('Sila isi Nama Penuh dan No. IC anda.');
                            return false;
                        }
                    }
                    if (currentStep === 2) {
                        if (!this.formData.income || !this.formData.employment_status) {
                            alert('Sila nyatakan status pekerjaan dan pendapatan bulanan anda.');
                            return false;
                        }
                    }
                    return true;
                }
            }" class="bg-white rounded-2xl shadow-xl overflow-hidden">

                {{-- Progress Steps --}}
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-100">
                    <div class="flex items-center justify-between max-w-md mx-auto">
                        <div class="flex flex-col items-center gap-2">
                            <div :class="step >= 1 ? 'bg-pink-500 text-white shadow-lg shadow-pink-200' : 'bg-slate-200 text-slate-500'"
                                class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300">
                                1</div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Personal</span>
                        </div>
                        <div class="flex-1 h-0.5 mx-4 bg-slate-200 overflow-hidden">
                            <div class="h-full bg-pink-500 transition-all duration-500"
                                :style="'width: ' + (step > 1 ? '100%' : '0%')"></div>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <div :class="step >= 2 ? 'bg-pink-500 text-white shadow-lg shadow-pink-200' : 'bg-slate-200 text-slate-500'"
                                class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300">
                                2</div>
                            <span
                                class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Employment</span>
                        </div>
                        <div class="flex-1 h-0.5 mx-4 bg-slate-200 overflow-hidden">
                            <div class="h-full bg-pink-500 transition-all duration-500"
                                :style="'width: ' + (step > 2 ? '100%' : '0%')"></div>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <div :class="step >= 3 ? 'bg-pink-500 text-white shadow-lg shadow-pink-200' : 'bg-slate-200 text-slate-500'"
                                class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300">
                                3</div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Financing</span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('borrower.loans.store') }}" class="p-8">
                    @csrf

                    {{-- Step 1: Personal Information --}}
                    <div x-show="step === 1" x-transition>
                        <h3 class="text-xl font-bold text-slate-800 mb-6">1. Applicant Information</h3>
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name (As per
                                    IC)</label>
                                <input type="text" name="full_name_display" x-model="formData.full_name"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-pink-500 focus:ring-pink-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">IC Number</label>
                                <input type="text" name="ic_number" x-model="formData.ic_number"
                                    placeholder="e.g. 990101015566"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-pink-500 focus:ring-pink-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" x-model="formData.phone" placeholder="e.g. 012-3456789"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-pink-500 focus:ring-pink-500 transition-all">
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end">
                            <button type="button" @click="if(validateStep(1)) step = 2"
                                class="px-8 py-3 bg-pink-500 text-white rounded-xl font-bold hover:bg-pink-600 shadow-lg shadow-pink-100 transition-all transform hover:-translate-y-0.5">
                                Next: Employment Details
                            </button>
                        </div>
                    </div>

                    {{-- Step 2: Employment Information --}}
                    <div x-show="step === 2" x-transition x-cloak>
                        <h3 class="text-xl font-bold text-slate-800 mb-6">2. Employment Details</h3>
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Employment Status</label>
                                <select name="employment_status" x-model="formData.employment_status"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-pink-500 focus:ring-pink-500 transition-all">
                                    <option value="">Select status...</option>
                                    <option value="employed">Employed</option>
                                    <option value="self_employed">Self-Employed</option>
                                    <option value="student">Student</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Monthly Income
                                    (RM)</label>
                                <input type="number" name="income" x-model="formData.income" placeholder="e.g. 3500"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-pink-500 focus:ring-pink-500 transition-all">
                            </div>
                        </div>

                        <div class="mt-10 flex justify-between">
                            <button type="button" @click="step = 1"
                                class="px-8 py-3 text-slate-500 font-bold hover:text-slate-800 transition-colors">
                                ← Back
                            </button>
                            <button type="button" @click="if(validateStep(2)) step = 3"
                                class="px-8 py-3 bg-pink-500 text-white rounded-xl font-bold hover:bg-pink-600 shadow-lg shadow-pink-100 transition-all transform hover:-translate-y-0.5">
                                Next: Financing Details
                            </button>
                        </div>
                    </div>

                    {{-- Step 3: Financing Details --}}
                    <div x-show="step === 3" x-transition x-cloak>
                        <h3 class="text-xl font-bold text-slate-800 mb-6">3. Financing Details</h3>
                        <div class="space-y-5">
                            <div>
                                <label for="amount" class="block text-sm font-semibold text-slate-700 mb-2">Loan Amount
                                    (RM) *</label>
                                <select name="amount" id="amount" required x-model="formData.amount"
                                    class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                    <option value="">Select amount...</option>
                                    @foreach($loanAmounts as $amount)
                                        @if($amount <= $eligibility['available_credit'])
                                            <option value="{{ $amount }}">
                                                RM {{ number_format($amount) }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="duration_months"
                                    class="block text-sm font-semibold text-slate-700 mb-2">Repayment Duration *</label>
                                <select name="duration_months" id="duration_months" required
                                    x-model="formData.duration_months"
                                    class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                    <option value="">Select duration...</option>
                                    @foreach($durations as $duration)
                                        <option value="{{ $duration }}">
                                            {{ $duration }} months
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="purpose" class="block text-sm font-semibold text-slate-700 mb-2">Purpose of
                                    Loan *</label>
                                <textarea name="purpose" id="purpose" rows="4" required x-model="formData.purpose"
                                    placeholder="Describe why you need this loan..."
                                    class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"></textarea>
                            </div>
                        </div>

                        {{-- Qard Hasan Info --}}
                        <div class="mt-8 bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                            <div class="flex gap-3">
                                <div class="bg-emerald-500 text-white p-1 rounded-full h-fit">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="text-xs">
                                    <p class="text-emerald-800 font-bold uppercase tracking-wider">Qard Hasan Compliant
                                    </p>
                                    <p class="text-emerald-700 mt-1">This is an Islamic benevolent loan with 0%
                                        interest. You only repay what you borrow.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex justify-between">
                            <button type="button" @click="step = 2"
                                class="px-8 py-3 text-slate-500 font-bold hover:text-slate-800 transition-colors">
                                ← Back
                            </button>
                            <button type="submit"
                                class="px-10 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 shadow-xl transition-all transform hover:-translate-y-0.5">
                                Submit Application
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Back Link --}}
            <div class="mt-6 text-center">
                <a href="{{ route('borrower.dashboard') }}"
                    class="text-gray-600 hover:text-primary-600 transition-colors">
                    ← Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-borrower-layout>