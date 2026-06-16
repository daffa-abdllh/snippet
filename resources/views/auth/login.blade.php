<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">{{ __('Welcome back') }}</h2>
        <p class="text-sm text-slate-500 mt-2">{{ __('Enter your credentials to access your account') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-600 text-xs font-medium mb-1" />
            <x-text-input id="email" class="block w-full bg-slate-50/50 border-slate-200 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-teal-500 focus:ring-teal-500 rounded-lg px-3.5 py-2.5 text-sm transition-all duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <x-input-label for="password" :value="__('Password')" class="text-slate-600 text-xs font-medium" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-teal-600 hover:text-teal-500 transition-colors duration-150" href="{{ route('password.request') }}">
                        {{ __('Forgot?') }}
                    </a>
                @endif
            </div>
            <div class="relative" x-data="{ show: false }">
                <x-text-input id="password" class="block w-full bg-slate-50/50 border-slate-200 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-teal-500 focus:ring-teal-500 rounded-lg px-3.5 py-2.5 pr-10 text-sm transition-all duration-200"
                                ::type="show ? 'text' : 'password'"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors duration-150">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path>
                    </svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-white border-zinc-300 text-teal-600 focus:ring-teal-500 focus:ring-offset-white w-4 h-4 transition-colors duration-150" name="remember">
                <span class="ms-2.5 text-xs text-zinc-500 select-none">{{ __('Keep me logged in') }}</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" :disabled="loading" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 hover:shadow-lg hover:shadow-teal-600/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-teal-500 transition-all duration-150 transform active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span x-show="!loading">{{ __('Continue') }}</span>
                <span x-show="loading">{{ __('Processing...') }}</span>
            </button>
        </div>
    </form>

    <!-- Register Link -->
    <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}" class="font-semibold text-teal-600 hover:text-teal-500 hover:underline transition-colors duration-150 ms-1">
            {{ __('Sign up') }}
        </a>
    </div>
</x-guest-layout>
