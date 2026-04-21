<x-guest-layout>
    <form method="POST" action="{{ route('password.confirm') }}" class="w-full space-y-5"
        x-data="{ showPassword: false, submitting: false }" @submit="submitting = true">
        @csrf

        <div class="w-full text-center mb-6">
            <p class="text-4xl sm:text-5xl font-semibold tracking-tight">Confirm password</p>
            <p class="mt-2 text-sm font-light text-muted-foreground">
                {{ __('This is a secure area. Please confirm your password before continuing.') }}
            </p>
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

        <x-primary-button class="w-full h-12 text-center">
            <span x-show="!submitting" style="display: inline;">{{ __('Confirm') }}</span>
            <span x-show="submitting" class="inline-flex items-center gap-2" style="display: none;">
                <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"></path>
                </svg>
                <span>Verifying...</span>
            </span>
        </x-primary-button>
    </form>
</x-guest-layout>
