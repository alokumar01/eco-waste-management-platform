<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Favicon Suite -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon_io/android-chrome-512x512.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon_io/android-chrome-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}">
        <link rel="shortcut icon" href="{{ asset('favicon_io/favicon.ico') }}">

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

        <!-- Global Premium Confirmation Modal -->
        <div id="confirm-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4">
            <!-- Backdrop with premium glassmorphism blur -->
            <div id="confirm-modal-backdrop" class="absolute inset-0 bg-gray-900/60 backdrop-blur-[4px] opacity-0 transition-opacity duration-300"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-white rounded-3xl border border-gray-100 max-w-sm w-full p-6 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 flex flex-col items-center text-center select-none" id="confirm-modal-content">
                <!-- Warning Icon -->
                <div class="w-14 h-14 rounded-full bg-red-50 text-red-500 flex items-center justify-center mb-4 shadow-sm border border-red-100">
                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                </div>
                
                <!-- Title & Message -->
                <h3 class="text-base font-extrabold text-gray-900 mb-2" id="confirm-modal-title">Confirm Action</h3>
                <p class="text-xs text-gray-505 font-semibold leading-relaxed mb-6" id="confirm-modal-message">Are you sure you want to perform this action? This cannot be undone.</p>
                
                <!-- Actions Row -->
                <div class="flex items-center gap-3 w-full">
                    <button type="button" id="confirm-modal-cancel" class="flex-1 py-2.5 border border-gray-200 hover:bg-gray-50 text-gray-650 text-xs font-bold rounded-xl transition-all shadow-sm cursor-pointer">
                        Cancel
                    </button>
                    <button type="button" id="confirm-modal-confirm" class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm cursor-pointer">
                        Confirm
                    </button>
                </div>
            </div>
        </div>

        <script>
            (function() {
                let activeCallback = null;

                window.showConfirmModal = function(options) {
                    const modal = document.getElementById('confirm-modal');
                    const backdrop = document.getElementById('confirm-modal-backdrop');
                    const content = document.getElementById('confirm-modal-content');
                    const titleEl = document.getElementById('confirm-modal-title');
                    const messageEl = document.getElementById('confirm-modal-message');
                    const confirmBtn = document.getElementById('confirm-modal-confirm');

                    if (!modal || !backdrop || !content) return;

                    titleEl.textContent = options.title || 'Confirm Action';
                    messageEl.textContent = options.message || 'Are you sure you want to proceed?';
                    activeCallback = options.onConfirm || null;

                    if (options.confirmText) {
                        confirmBtn.textContent = options.confirmText;
                    } else {
                        confirmBtn.textContent = 'Confirm';
                    }

                    if (options.confirmClass) {
                        confirmBtn.className = `flex-1 py-2.5 text-white text-xs font-bold rounded-xl transition-all shadow-sm cursor-pointer ${options.confirmClass}`;
                    } else {
                        confirmBtn.className = "flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm cursor-pointer";
                    }

                    // Show elements
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');

                    // Force reflow
                    modal.offsetHeight;

                    // Animate in
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                };

                window.hideConfirmModal = function() {
                    const modal = document.getElementById('confirm-modal');
                    const backdrop = document.getElementById('confirm-modal-backdrop');
                    const content = document.getElementById('confirm-modal-content');

                    if (!modal || !backdrop || !content) return;

                    backdrop.classList.remove('opacity-100');
                    backdrop.classList.add('opacity-0');
                    content.classList.remove('scale-100', 'opacity-100');
                    content.classList.add('scale-95', 'opacity-0');

                    setTimeout(() => {
                        modal.classList.remove('flex');
                        modal.classList.add('hidden');
                        activeCallback = null;
                    }, 300);
                };

                document.addEventListener('DOMContentLoaded', function() {
                    const confirmBtn = document.getElementById('confirm-modal-confirm');
                    const cancelBtn = document.getElementById('confirm-modal-cancel');
                    const backdrop = document.getElementById('confirm-modal-backdrop');

                    if (confirmBtn) {
                        confirmBtn.addEventListener('click', function() {
                            if (activeCallback) activeCallback();
                            window.hideConfirmModal();
                        });
                    }

                    if (cancelBtn) {
                        cancelBtn.addEventListener('click', function() {
                            window.hideConfirmModal();
                        });
                    }

                    if (backdrop) {
                        backdrop.addEventListener('click', function() {
                            window.hideConfirmModal();
                        });
                    }

                    // Global interception of form submission with data-confirm
                    document.addEventListener('submit', function(e) {
                        const confirmMsg = e.target.getAttribute('data-confirm');
                        if (confirmMsg) {
                            if (e.target.dataset.confirmed === 'true') {
                                return;
                            }
                            e.preventDefault();
                            
                            const confirmText = e.target.getAttribute('data-confirm-text') || 'Confirm';
                            const confirmTitle = e.target.getAttribute('data-confirm-title') || 'Confirm Action';
                            const confirmClass = e.target.getAttribute('data-confirm-class') || 'bg-red-600 hover:bg-red-700';

                            window.showConfirmModal({
                                title: confirmTitle,
                                message: confirmMsg,
                                confirmText: confirmText,
                                confirmClass: confirmClass,
                                onConfirm: function() {
                                    e.target.dataset.confirmed = 'true';
                                    e.target.submit();
                                }
                            });
                        }
                    });
                });
            })();
        </script>
    </body>
</html>
