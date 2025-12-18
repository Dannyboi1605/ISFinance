<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back</h1>
        <p class="text-gray-500">Enter your details to access your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="block w-full pl-11 pr-4 py-3.5 bg-white/50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all outline-none placeholder-gray-400"
                    placeholder="name@example.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-primary-600 hover:text-primary-700 transition-colors"
                        href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-4 py-3.5 bg-white/50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all outline-none placeholder-gray-400"
                    placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 transition-colors">
            <label for="remember_me" class="ml-2 block text-sm text-gray-600 font-medium">Keep me signed in</label>
        </div>

        <div>
            <button type="submit"
                class="w-full bg-gray-900 text-white font-bold py-4 px-6 rounded-2xl hover:bg-gray-800 focus:ring-4 focus:ring-gray-200 transition-all transform active:scale-[0.98] shadow-xl">
                Get Started
            </button>
        </div>
    </form>

    <div class="mt-8 pt-8 border-t border-gray-100 text-center">
        <p class="text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}"
                class="font-bold text-primary-600 hover:text-primary-700 transition-colors">Create one now</a>
        </p>
    </div>
</x-guest-layout>