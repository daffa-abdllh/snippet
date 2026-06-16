<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight leading-tight">{{ __('Verify Email') }}</h2>
        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-100 rounded-lg text-xs font-medium text-emerald-800">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}" x-data="{ loading: false }" @submit="loading = true">
            @csrf

            <button type="submit" :disabled="loading" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 hover:shadow-lg hover:shadow-teal-600/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-teal-500 transition-all duration-150 transform active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span x-show="!loading">{{ __('Resend Verification Email') }}</span>
                <span x-show="loading">{{ __('Processing...') }}</span>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center pt-2">
            @csrf

            <button type="submit" class="text-xs font-semibold text-slate-500 hover:text-slate-800 hover:underline transition-colors duration-150">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
