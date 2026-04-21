<x-guest-layout>
    <div class="w-full space-y-5" x-data="{ resendSubmitting: false, logoutSubmitting: false }">
        <div class="w-full text-center mb-6">
            <p class="text-4xl sm:text-5xl font-semibold tracking-tight">Verify your email</p>
            <p class="mt-2 text-sm font-light text-muted-foreground">
                {{ __('We sent a verification link to your inbox. Please confirm your email to continue.') }}
            </p>
        </div>

        <div class="rounded-xl border border-border bg-secondary/30 px-4 py-3 text-sm text-muted-foreground">
            {{ __('Thanks for signing up! Before getting started, please verify your email by clicking the link we just sent. If you did not receive it, we can send another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="rounded-xl border border-primary/25 bg-primary/10 px-4 py-3 text-sm font-medium text-primary">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto"
                @submit="resendSubmitting = true">
                @csrf

                <x-primary-button class="w-full sm:w-auto h-12">
                    <span x-show="!resendSubmitting" style="display: inline;">{{ __('Resend Verification Email') }}</span>
                    <span x-show="resendSubmitting" class="inline-flex items-center gap-2" style="display: none;">
                        <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z">
                            </path>
                        </svg>
                        <span>Sending...</span>
                    </span>
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto" @submit="logoutSubmitting = true">
                @csrf

                <button type="submit"
                    class="inline-flex h-12 w-full sm:w-auto items-center justify-center gap-2 rounded-xl border border-border bg-card px-4 text-sm font-medium text-foreground transition hover:bg-secondary/50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring/40">
                    <span x-show="!logoutSubmitting" style="display: inline;">{{ __('Log Out') }}</span>
                    <span x-show="logoutSubmitting" class="inline-flex items-center gap-2" style="display: none;">
                        <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z">
                            </path>
                        </svg>
                        <span>Logging out...</span>
                    </span>
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
