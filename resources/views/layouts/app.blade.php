<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
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
            <main class="@hasSection('no_container') @else container mx-auto px-4 py-4 @endif">
                @yield('content')
            </main>
        </div>
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
        <!-- Global Toast Notification -->
        <div id="toast-notification" class="fixed top-5 right-5 z-[100] transform translate-y-[-100px] opacity-0 transition-all duration-300 pointer-events-none">
            <div class="bg-emerald-600 text-white px-5 py-3.5 rounded-2xl shadow-lg flex items-center gap-3 border border-emerald-500/20 text-xs font-bold">
                <i class="fa-solid fa-circle-check text-base"></i>
                <span id="toast-message">Success</span>
            </div>
        </div>

        <script>
            // Global Toast Notification engine
            function showToast(message) {
                const toast = document.getElementById('toast-notification');
                const msgEl = document.getElementById('toast-message');
                if (!toast || !msgEl) return;
                msgEl.textContent = message;
                toast.className = "fixed top-5 right-5 z-[100] transform translate-y-0 opacity-100 transition-all duration-300 pointer-events-auto";
                setTimeout(() => {
                    toast.className = "fixed top-5 right-5 z-[100] transform translate-y-[-100px] opacity-0 transition-all duration-300 pointer-events-none";
                }, 3000);
            }

            // Global Saved Provider Toggler AJAX helper
            function toggleSaveProvider(providerId, buttonElement, event) {
                if (event) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                fetch(`/providers/${providerId}/toggle-save`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.success) {
                        showToast(data.message);
                        
                        // Update all matching heart buttons on the page for this provider
                        const heartIcons = document.querySelectorAll(`[data-provider-id="${providerId}"] i, button[onclick*="toggleSaveProvider(${providerId}"] i`);
                        heartIcons.forEach(icon => {
                            if (data.is_saved) {
                                icon.className = "fa-solid fa-heart text-red-500";
                            } else {
                                icon.className = "fa-regular fa-heart";
                            }
                        });

                        // If on dashboard, reload the page or update list dynamically to reflect in modal
                        if (window.location.pathname.includes('/dashboard')) {
                            setTimeout(() => {
                                window.location.reload();
                            }, 500);
                        }
                    } else if (data && data.error) {
                        showToast(data.error);
                    }
                })
                .catch(err => {
                    console.error("Error toggling saved provider:", err);
                });
            }
        </script>
    </body>
</html>
