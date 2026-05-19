@extends('layouts.guest')

@section('content')
    <div class="mb-6 select-none text-center sm:text-left">
        <h1 class="text-3xl font-heading font-extrabold text-gray-950 tracking-tight">Create account</h1>
        <p class="mt-2 text-xs text-gray-400 font-semibold leading-relaxed">Join GreenLoop and start turning waste into value.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-1">
            <label for="name" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Name') }}</label>

            <div class="relative group mt-1.5 guest-input-container">
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-500 group-focus-within:text-[#609953] transition-colors z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4.5 w-4.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </span>

                <input id="name" class="guest-input block w-full placeholder-gray-500/80 font-medium" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name" />
            </div>

            @error('name')
                <p class="mt-1.5 text-[11px] font-bold text-red-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Email') }}</label>

            <div class="relative group mt-1.5 guest-input-container">
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-500 group-focus-within:text-[#609953] transition-colors z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4.5 w-4.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>

                <input id="email" class="guest-input block w-full placeholder-gray-500/80 font-medium" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email" />
            </div>

            @error('email')
                <p class="mt-1.5 text-[11px] font-bold text-red-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Role Select Menu -->
        <div class="space-y-1">
            <label for="role" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Register As') }}</label>

            <div class="relative group mt-1.5 guest-input-container">
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-500 group-focus-within:text-[#609953] transition-colors z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4.5 w-4.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </span>

                <select id="role" name="role" autocomplete="off" class="guest-input block w-full placeholder-gray-500/80 font-bold appearance-none">
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }} class="font-semibold text-gray-700">Customer (Generate & Recycle Waste)</option>
                    <option value="provider" {{ old('role') === 'provider' ? 'selected' : '' }} class="font-semibold text-gray-700">Service Provider (Collect & Process Waste)</option>
                </select>

                <!-- custom select pin -->
                <div class="absolute right-3.5 inset-y-0 pointer-events-none flex items-center text-gray-400 z-20">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            @error('role')
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
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-500 group-focus-within:text-[#609953] transition-colors z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4.5 w-4.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>

                <input id="password" class="guest-input block w-full placeholder-gray-500/80 font-medium" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" />
            </div>

            @error('password')
                <p class="mt-1.5 text-[11px] font-bold text-red-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <label for="password_confirmation" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Confirm Password') }}</label>

            <div class="relative group mt-1.5 guest-input-container">
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-500 group-focus-within:text-[#609953] transition-colors z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4.5 w-4.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>

                <input id="password_confirmation" class="guest-input block w-full placeholder-gray-500/80 font-medium" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
            </div>

            @error('password_confirmation')
                <p class="mt-1.5 text-[11px] font-bold text-red-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Sign Up Button -->
        <button type="submit" class="w-full btn-primary-mockup text-center inline-flex items-center justify-center font-heading font-extrabold text-xs text-white tracking-wider uppercase select-none">
            {{ __('Create Account') }}
        </button>

        <!-- Divider Link -->
        <div class="text-center pt-3 border-t border-gray-100 mt-6">
            <p class="text-xs text-gray-400 font-semibold">
                Already registered?
                <a href="{{ route('login') }}" class="guest-link-green">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
@endsection
