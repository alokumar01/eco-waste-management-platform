@extends('layouts.guest')

@section('content')
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 bg-green-50 border border-green-100 text-[#3E8B3A] py-2 px-3 rounded-xl text-xs font-bold shadow-sm flex items-center gap-2">
            <svg class="w-3.5 h-3.5 text-green-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="mb-6 select-none text-center sm:text-left">
        <h1 class="text-3xl font-heading font-extrabold text-gray-950 tracking-tight">Welcome back</h1>
        <p class="mt-2 text-xs text-gray-400 font-semibold leading-relaxed">Enter your credentials to access your secure waste dashboard.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Email') }}</label>

            <div class="relative group mt-1.5 guest-input-container">
                <!-- Mail Icon -->
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-500 group-focus-within:text-[#609953] transition-colors z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4.5 w-4.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>

                <input id="email" class="guest-input block w-full placeholder-gray-500/80 font-medium" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email" />
            </div>

            @error('email')
                <p class="mt-1.5 text-[11px] font-bold text-red-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Password') }}</label>

            <div class="relative group mt-1.5 guest-input-container">
                <!-- Lock Icon -->
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-500 group-focus-within:text-[#609953] transition-colors z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4.5 w-4.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>

                <input id="password" class="guest-input block w-full placeholder-gray-500/80 font-medium" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            </div>

            @error('password')
                <p class="mt-1.5 text-[11px] font-bold text-red-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1 select-none">
            <label for="remember_me" class="inline-flex items-center text-xs font-semibold text-gray-500 cursor-pointer hover:text-gray-700 transition-colors">
                <input id="remember_me" type="checkbox" class="h-3.5 w-3.5 rounded border-gray-300 bg-gray-50 text-[#609953] focus:ring-1 focus:ring-[#609953]/50 focus:ring-offset-0 cursor-pointer" name="remember">
                <span class="ms-2 font-medium">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs guest-link-green" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            @endif
        </div>

        <!-- Log In Button (Mockup Class) -->
        <button type="submit" class="w-full btn-primary-mockup text-center inline-flex items-center justify-center font-heading font-extrabold text-xs text-white tracking-wider uppercase select-none">
            {{ __('Log In') }}
        </button>

        <!-- Switch Auth Option -->
        <div class="text-center pt-3 border-t border-gray-100 mt-6 select-none">
            <p class="text-xs text-gray-400 font-semibold">
                Don't have an account?
                <a href="{{ route('register') }}" class="guest-link-green">
                    Sign up
                </a>
            </p>
        </div>
    </form>
@endsection