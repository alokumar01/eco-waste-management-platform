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

<body class="antialiased bg-background h-dvh flex items-center justify-center my-auto sm:p-10 sm:px-20 p-2 text-foreground">
    <div class=" h-full w-full bg-card rounded-3xl flex justify-center items-center space-x-2 overflow-hidden p-2">
        <div class="w-1/2 h-full hidden lg:block">
            <x-auth-left-side />
        </div>

        <div class="sm:w-1/2 w-full h-full flex flex-col items-center justify-center gap-6 p-4">
            <div class="flex items-center justify-center gap-2">
                <x-application-logo class="h-22 w-auto text-primary" />
                <x-application-logo-landscape class="h-22 w-auto text-primary" />
            </div>
            <div class="h-full w-full items-center my-auto flex-1 flex">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>