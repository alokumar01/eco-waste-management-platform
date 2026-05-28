@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('password.confirm') }}" class="w-full space-y-5">
        @csrf

        <div class="w-full text-center mb-6">
            <p class="text-4xl sm:text-5xl font-semibold tracking-tight">Confirm password</p>
            <p class="mt-2 text-sm font-light text-muted-foreground">
                {{ __('This is a secure area. Please confirm your password before continuing.') }}
            </p>
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>

            <div class="relative group mt-1">
                <span
                    class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-muted-foreground/80 transition-colors group-focus-within:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V8a4 4 0 1 0-8 0v3m-2 0h12a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1z" />
                    </svg>
                </span>

                <input id="password" class="block w-full h-12 pl-11 pr-11 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    type="password" name="password" required
                    autocomplete="current-password" placeholder="Enter your password" />

                <button type="button"
                    class="absolute inset-y-0 right-3 inline-flex items-center text-muted-foreground/80 transition hover:text-foreground"
                    onclick="togglePasswordVisibility()">
                    <svg id="show-password-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg id="hide-password-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" class="h-5 w-5" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.7 6.2A10.5 10.5 0 0 1 12 6c6.5 0 10 6 10 6a15 15 0 0 1-3 3.8M6.1 6.1C3.6 7.8 2 12 2 12s3.5 7 10 7c1.7 0 3.2-.5 4.4-1.2" />
                    </svg>
                </button>
            </div>

            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full h-12 text-center inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Confirm') }}
        </button>
    </form>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const showIcon = document.getElementById('show-password-icon');
            const hideIcon = document.getElementById('hide-password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showIcon.style.display = 'none';
                hideIcon.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                showIcon.style.display = 'block';
                hideIcon.style.display = 'none';
            }
        }
    </script>
@endsection
