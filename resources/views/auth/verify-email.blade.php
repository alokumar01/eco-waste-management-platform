@extends('layouts.guest')

@section('content')
    <div class="w-full space-y-5">
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
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                @csrf

                <button type="submit" class="w-full sm:w-auto h-12 inline-flex items-center justify-center px-4 py-2 bg-[#3E8B3A] border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-[#2E6F40] transition-all shadow-sm">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                @csrf

                <button type="submit" class="inline-flex h-12 w-full sm:w-auto items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 text-sm font-bold text-gray-700 transition hover:bg-gray-50 shadow-sm">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
@endsection
