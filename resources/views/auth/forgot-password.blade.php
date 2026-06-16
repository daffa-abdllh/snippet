<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">{{ __('Forgot password?') }}</h2>
        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
            {{ __('No problem. Enter your email address and we will send you a password reset link.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-600 text-xs font-medium mb-1" />
            <x-text-input id="email" class="block w-full bg-slate-50/50 border-slate-200 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-teal-500 focus:ring-teal-500 rounded-lg px-3.5 py-2.5 text-sm transition-all duration-200" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" :disabled="loading" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 hover:shadow-lg hover:shadow-teal-600/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-teal-500 transition-all duration-150 transform active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span x-show="!loading">{{ __('Send reset link') }}</span>
                <span x-show="loading">{{ __('Processing...') }}</span>
            </button>
        </div>
    </form>

    <!-- Back Button / Link -->
    <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 font-semibold text-teal-600 hover:text-teal-500 hover:underline transition-colors duration-150">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            {{ __('Back to login') }}
        </a>
    </div>
</x-guest-layout>
