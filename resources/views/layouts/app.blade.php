<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <!-- Include Quill stylesheet -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Override Bootstrap link styling globally so Tailwind works */
            a, a:hover {
                color: inherit !important;
                text-decoration: none !important;
            }

            /* Quill Premium Integration overrides */
            .ql-toolbar.ql-snow {
                border-bottom: 1px solid #f3f4f6 !important;
                border-top: none !important;
                border-left: none !important;
                border-right: none !important;
                background-color: rgba(249, 250, 251, 0.6) !important;
                padding: 8px 16px !important;
            }
            .ql-container.ql-snow {
                border: none !important;
                font-family: inherit !important;
                font-size: 0.75rem !important;
                color: #374151 !important;
            }
            .ql-editor {
                min-height: 180px !important;
                padding: 12px 16px !important;
                line-height: 1.6 !important;
            }
            .ql-editor.ql-blank::before {
                font-style: normal !important;
                color: #9ca3af !important;
                left: 16px !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @hasSection('no_top_nav')
        @else
            @include('layouts.navigation')
        @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="@hasSection('no_container') @else container py-4 @endif">
                @yield('content')
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
