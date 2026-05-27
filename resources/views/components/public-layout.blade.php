<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'GreenLoop | Smart Waste. Green Future.' }}</title>
    <!-- Favicon Suite -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon_io/android-chrome-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon_io/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('favicon_io/favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'PT Sans', sans-serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        .landing-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        /* Nav links underline hover animation */
        .nav-link {
            position: relative;
            color: #1a1a1a;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: capitalize;
            transition: color 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -6px;
            left: 50%;
            background-color: #3E8B3A;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }
        
        .nav-link:hover {
            color: #3E8B3A;
        }

        /* Massive sweeping background gradient behind image placeholder */
        .hero-gradient-blob {
            position: absolute;
            right: -10%;
            top: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(62,139,58,0.08) 0%, rgba(250,252,251,0) 70%);
            border-radius: 50%;
            z-index: -1;
            pointer-events: none;
        }

        /* Stats Pill Glassmorphism */
        .stats-pill {
            background: #ffffff;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px rgba(62, 139, 58, 0.05);
        }

        /* Beautiful Green Text Gradient */
        .text-gradient-green {
            background: linear-gradient(135deg, #2E6F40 0%, #4CAF50 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="antialiased selection:bg-[#3E8B3A] selection:text-white">

    <!-- Navbar -->
    <nav class="bg-white pt-4 pb-3 px-6 lg:px-12 sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="landing-container flex items-center justify-between">
            
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="{{ asset('icon-landscap.svg') }}" alt="GreenLoop Logo" class="h-7 md:h-8 w-auto object-contain select-none pointer-events-none">
            </a>

            <!-- Center Links -->
            <div class="hidden lg:flex items-center gap-10">
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ route('services.list') }}" class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">Services</a>
                <a href="{{ route('public.blog.index') }}" class="nav-link {{ request()->routeIs('public.blog.*') ? 'active' : '' }}">Blog</a>
                <a href="{{ route('public.about') }}" class="nav-link {{ request()->routeIs('public.about') ? 'active' : '' }}">About Us</a>
                <a href="{{ route('public.contact') }}" class="nav-link {{ request()->routeIs('public.contact') ? 'active' : '' }}">Contact</a>
            </div>

            <!-- Right Actions -->
            <div class="hidden md:flex items-center gap-5">
                <!-- Auth Button -->
                @auth
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl bg-[#3E8B3A] hover:bg-[#2E6F40] text-white text-xs font-extrabold tracking-wide uppercase transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center gap-2">
                        <i class="fa-regular fa-user"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-[#3E8B3A] hover:bg-[#2E6F40] text-white text-[13px] font-extrabold transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center gap-2">
                        <i class="fa-regular fa-user"></i> Log In
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu -->
            <button class="lg:hidden text-gray-900 text-2xl">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>

        </div>
    </nav>

    <!-- Main Content -->
    {{ $slot }}

    <!-- Mega Footer Section -->
    <footer class="bg-white pt-16 pb-8 border-t border-gray-100 selection:bg-[#3E8B3A] selection:text-white">
        <div class="landing-container px-6 lg:px-12">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-16 select-none">
                
                <!-- Brand Column -->
                <div class="space-y-4">
                    <a href="/" class="flex items-center mb-6">
                        <img src="{{ asset('icon-landscap.svg') }}" alt="GreenLoop Logo" class="h-6 md:h-7 w-auto object-contain select-none pointer-events-none">
                    </a>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed max-w-[240px]">
                        Connecting communities with trusted waste management and composting services for a cleaner, greener tomorrow.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-5">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Home</a></li>
                        <li><a href="{{ route('services.list') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Services</a></li>
                        <li><a href="{{ route('public.blog.index') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Blog</a></li>
                        <li><a href="{{ route('public.about') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">About Us</a></li>
                        <li><a href="{{ route('public.contact') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-5">Support</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('public.help') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Help Center</a></li>
                        <li><a href="{{ route('public.faqs') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">FAQs</a></li>
                        <li><a href="{{ route('public.terms') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Terms & Conditions</a></li>
                        <li><a href="{{ route('public.privacy') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('public.refund-policy') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Refund Policy</a></li>
                        <li><a href="{{ route('public.contact') }}" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Contact Support</a></li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-6 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4 select-none">
                <p class="text-[11px] text-gray-500 font-medium">&copy; {{ date('Y') }} GreenLoop. All rights reserved.</p>
                <p class="text-[11px] text-gray-500 font-medium flex items-center gap-1.5">
                    Made with <i class="fa-solid fa-heart text-green-700 text-[10px]"></i> for a greener planet <i class="fa-solid fa-leaf text-[#3E8B3A] text-[10px]"></i>
                </p>
            </div>

        </div>
    </footer>

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
            <p class="text-xs text-gray-550 font-semibold leading-relaxed mb-6" id="confirm-modal-message">Are you sure you want to perform this action? This cannot be undone.</p>
            
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
