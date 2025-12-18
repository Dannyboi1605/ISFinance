<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Set Up Your Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-primary-50 via-white to-primary-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Page Title --}}
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-primary-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Choose Your Wallet Type</h1>
                <p class="text-gray-600 max-w-xl mx-auto">
                    To apply for Qard Hasan loans, you need to link a wallet. Choose the option that best suits your
                    needs.
                </p>
            </div>

            {{-- Warning Message --}}
            @if(session('warning'))
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <div class="flex">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="ml-3 text-sm text-yellow-700">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            {{-- Wallet Type Cards --}}
            <div class="grid md:grid-cols-2 gap-8">

                {{-- Custodial Wallet Card --}}
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-transparent hover:border-primary-300 transition-all duration-300 group">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center group-hover:bg-primary-600 transition-colors duration-300">
                                <svg class="w-7 h-7 text-primary-600 group-hover:text-white transition-colors duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">RECOMMENDED</span>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Custodial Wallet</h3>
                        <p class="text-gray-600 mb-6">
                            ISFinance creates and manages a secure wallet for you. Perfect for beginners — no technical
                            knowledge required.
                        </p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Automatic wallet creation</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">No private keys to manage</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Instant setup</span>
                            </li>
                        </ul>

                        <form method="POST" action="{{ route('borrower.wallet.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="custodial">
                            <button type="submit"
                                class="w-full bg-primary-600 text-white font-bold py-4 px-6 rounded-xl hover:bg-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Create My Wallet
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Non-Custodial Wallet Card --}}
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-transparent hover:border-gray-300 transition-all duration-300 group">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center group-hover:bg-gray-700 transition-colors duration-300">
                                <svg class="w-7 h-7 text-gray-600 group-hover:text-white transition-colors duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full">ADVANCED</span>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Non-Custodial Wallet</h3>
                        <p class="text-gray-600 mb-6">
                            Link your own Ethereum wallet address. You maintain full control of your keys.
                        </p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Full ownership of your wallet</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Use existing MetaMask or other wallets</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Requires wallet address</span>
                            </li>
                        </ul>

                        <form method="POST" action="{{ route('borrower.wallet.store') }}" x-data="{ showInput: false }">
                            @csrf
                            <input type="hidden" name="type" value="non_custodial">

                            <div x-show="!showInput">
                                <button type="button" @click="showInput = true"
                                    class="w-full bg-gray-100 text-gray-700 font-bold py-4 px-6 rounded-xl hover:bg-gray-200 transition-all duration-300 border-2 border-gray-200">
                                    Link External Wallet
                                </button>
                            </div>

                            <div x-show="showInput" x-cloak class="space-y-4">
                                <div>
                                    <label for="wallet_address"
                                        class="block text-sm font-semibold text-gray-700 mb-2">Wallet Address</label>
                                    <input type="text" name="wallet_address" id="wallet_address" placeholder="0x..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 font-mono text-sm"
                                        pattern="^0x[a-fA-F0-9]{40}$" required>
                                    @error('wallet_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit"
                                    class="w-full bg-gray-700 text-white font-bold py-4 px-6 rounded-xl hover:bg-gray-800 transition-all duration-300">
                                    Link Wallet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            {{-- Info Note --}}
            <div class="mt-10 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-blue-700">
                        <strong>Note:</strong> This is a prototype simulation. No real cryptocurrency or blockchain
                        transactions are involved.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>