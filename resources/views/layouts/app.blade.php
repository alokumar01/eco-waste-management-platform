<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-foreground">
        <div class="relative min-h-screen overflow-x-hidden bg-background">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(74,222,128,0.18),transparent_28%),radial-gradient(circle_at_top_right,rgba(250,204,21,0.12),transparent_24%),linear-gradient(180deg,rgba(255,255,255,0.88),rgba(240,253,244,0.78))]"></div>
            <div class="pointer-events-none absolute inset-x-0 top-0 h-[460px] bg-[linear-gradient(to_bottom,rgba(255,255,255,0.32),transparent),linear-gradient(to_right,rgba(22,163,74,0.08)_1px,transparent_1px),linear-gradient(to_bottom,rgba(22,163,74,0.08)_1px,transparent_1px)] bg-[size:auto,64px_64px,64px_64px] [mask-image:linear-gradient(to_bottom,rgba(0,0,0,0.9),transparent)]"></div>
            <div class="pointer-events-none absolute left-[-7rem] top-24 h-56 w-56 rounded-full bg-primary/15 blur-3xl"></div>
            <div class="pointer-events-none absolute right-[-5rem] top-56 h-64 w-64 rounded-full bg-emerald-200/45 blur-3xl"></div>

            <div class="relative">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="border-b border-white/60 bg-white/45 shadow-[0_14px_50px_-30px_rgba(17,24,39,0.45)] backdrop-blur-xl">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            </div>
        </div>
    </body>
</html>
