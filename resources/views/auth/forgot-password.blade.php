@extends('layouts.guest')

@section('content')
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="w-full space-y-5">
        @csrf

        <div class="w-full text-center mb-6">
            <p class="text-4xl sm:text-5xl font-semibold tracking-tight">Forgot password</p>
            <p class="mt-2 text-sm font-light text-muted-foreground">
                {{ __('Enter your email and we will send you a secure reset link.') }}
            </p>
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>

            <div class="relative group mt-1">
                <span
                    class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-muted-foreground/80 transition-colors group-focus-within:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7l8.5 5.5a1 1 0 0 0 1 0L21 7m-17 11h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z" />
                    </svg>
                </span>

                <input id="email" class="block w-full h-12 pl-11 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" type="email" name="email" value="{{ old('email') }}"
                    required autofocus autocomplete="username" placeholder="Enter your email" />
            </div>

            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full h-12 text-center inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Send Reset Link') }}
        </button>

        @if (Route::has('login'))
            <p class="text-center text-sm text-muted-foreground">
                Remember your password?
                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary/80 transition">Back to sign in</a>
            </p>
        @endif
    </form>
@endsection
