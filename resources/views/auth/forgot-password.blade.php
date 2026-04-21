<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="w-full space-y-5" x-data="{ submitting: false }"
        @submit="submitting = true">
        @csrf

        <div class="w-full text-center mb-6">
            <p class="text-4xl sm:text-5xl font-semibold tracking-tight">Forgot password</p>
            <p class="mt-2 text-sm font-light text-muted-foreground">
                {{ __('Enter your email and we will send you a secure reset link.') }}
            </p>
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email')" />

            <div class="relative group mt-1">
                <span
                    class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-muted-foreground/80 transition-colors group-focus-within:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7l8.5 5.5a1 1 0 0 0 1 0L21 7m-17 11h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z" />
                    </svg>
                </span>

                <x-text-input id="email" class="block w-full h-12 pl-11" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" placeholder="Enter your email" />
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full h-12 text-center">
            <span x-show="!submitting" style="display: inline;">{{ __('Send Reset Link') }}</span>
            <span x-show="submitting" class="inline-flex items-center gap-2" style="display: none;">
                <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"></path>
                </svg>
                <span>Sending link...</span>
            </span>
        </x-primary-button>

        @if (Route::has('login'))
            <p class="text-center text-sm text-muted-foreground">
                Remember your password?
                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary/80 transition">Back to sign in</a>
            </p>
        @endif
    </form>
</x-guest-layout>
