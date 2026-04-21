<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="w-full space-y-5"
        x-data="{ showPassword: false, submitting: false }" @submit="submitting = true">
        @csrf
        <div class="w-full text-center mb-6">
            <p class="text-4xl sm:text-5xl font-semibold tracking-tight">Welcome back</p>
            <p class="mt-2 text-sm font-light text-muted-foreground">Enter your credentials to access your account</p>
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

        <!-- Password -->
        <div class="space-y-1.5">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative group mt-1">
                <span
                    class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-muted-foreground/80 transition-colors group-focus-within:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V8a4 4 0 1 0-8 0v3m-2 0h12a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1z" />
                    </svg>
                </span>

                <x-text-input id="password" class="block w-full h-12 pl-11 pr-11"
                    x-bind:type="showPassword ? 'text' : 'password'" name="password" required
                    autocomplete="current-password" placeholder="Enter your password" />

                <button type="button"
                    class="absolute inset-y-0 right-3 inline-flex items-center text-muted-foreground/80 transition hover:text-foreground"
                    @click="showPassword = !showPassword"
                    :aria-label="showPassword ? 'Hide password' : 'Show password'">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" class="h-5 w-5" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" class="h-5 w-5" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.7 6.2A10.5 10.5 0 0 1 12 6c6.5 0 10 6 10 6a15 15 0 0 1-3 3.8M6.1 6.1C3.6 7.8 2 12 2 12s3.5 7 10 7c1.7 0 3.2-.5 4.4-1.2" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me and Forgot Password -->
        <div class="w-full flex items-center justify-between mt-1 gap-3">
            <div class="block">
                <label for="remember_me" class="inline-flex items-center text-sm text-muted-foreground">
                    <input id="remember_me" type="checkbox"
                        class="h-4 w-4 rounded border-border bg-input text-primary focus:ring-2 focus:ring-ring/40"
                        name="remember">
                    <span class="ms-2">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="">
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-primary hover:text-primary/80 transition"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>
        </div>

        <x-primary-button class="w-full h-12 text-center">
            <span x-show="!submitting" style="display: inline;">{{ __('Sign In') }}</span>
            <span x-show="submitting" class="inline-flex items-center gap-2" style="display: none;">
                <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"></path>
                </svg>
                <span>Signing in...</span>
            </span>
        </x-primary-button>

        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-border"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase tracking-wider text-muted-foreground">
                <span class="bg-card px-2">Or continue with</span>
            </div>
        </div>

        <button type="button"
            class="w-full h-12 rounded-xl border border-border bg-card text-foreground font-medium transition hover:bg-secondary/50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring/40">
            <span class="inline-flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" aria-hidden="true">
                    <path fill="#EA4335"
                        d="M12 10.2v3.9h5.5c-.2 1.3-1.5 3.7-5.5 3.7a6 6 0 1 1 0-12c2.3 0 3.8 1 4.7 1.8l3.2-3.1A10.8 10.8 0 1 0 12 22c6.2 0 10.3-4.3 10.3-10.4 0-.7-.1-1.2-.2-1.4H12z" />
                </svg>
                <span>Sign in with Google</span>
            </span>
        </button>

        @if (Route::has('register'))
            <p class="text-center text-sm text-muted-foreground">
                Don&apos;t have an account?
                <a href="{{ route('register') }}" class="font-medium text-primary hover:text-primary/80 transition">Sign
                    up</a>
            </p>
        @endif
    </form>
</x-guest-layout>