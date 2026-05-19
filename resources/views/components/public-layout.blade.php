<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'GreenLoop | Smart Waste. Green Future.' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
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
            background: linear-gradient(135deg, #2D7A28 0%, #4CAF50 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="antialiased selection:bg-[#3E8B3A] selection:text-white">

    <!-- Navbar -->
    <nav class="bg-white pt-6 pb-4 px-6 lg:px-12 relative z-50 border-b border-gray-50">
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
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl bg-[#3E8B3A] hover:bg-[#2D7A28] text-white text-xs font-extrabold tracking-wide uppercase transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center gap-2">
                        <i class="fa-regular fa-user"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-[#3E8B3A] hover:bg-[#2D7A28] text-white text-[13px] font-extrabold transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center gap-2">
                        <i class="fa-regular fa-user"></i> Login
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-16 select-none">
                
                <!-- Brand Column -->
                <div class="lg:col-span-1 space-y-4">
                    <a href="/" class="flex items-center mb-6">
                        <img src="{{ asset('icon-landscap.svg') }}" alt="GreenLoop Logo" class="h-6 md:h-7 w-auto object-contain select-none pointer-events-none">
                    </a>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed max-w-[200px]">
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

                <!-- Services -->
                <div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-5">Services</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Composting</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Recycling</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">E-Waste Management</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Organic Waste Pickup</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Garden Waste Collection</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Commercial Solutions</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-5">Support</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">FAQs</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Terms & Conditions</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Refund Policy</a></li>
                        <li><a href="#" class="text-[12px] text-gray-500 hover:text-[#3E8B3A] font-medium transition-colors">Contact Support</a></li>
                    </ul>
                </div>

                <!-- Download App -->
                <div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-5">Download Our App</h4>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed max-w-[200px] mb-4">
                        Book services, track pickups and more from our mobile app.
                    </p>
                    <div class="flex gap-2">
                        <!-- Generic Play Store Badge -->
                        <a href="#" class="h-9 rounded flex items-center justify-center bg-black hover:bg-gray-900 text-white transition-colors px-2.5">
                            <i class="fa-brands fa-google-play text-lg mr-1.5"></i>
                            <div class="flex flex-col items-start leading-none">
                                <span class="text-[6px] text-gray-300 uppercase">Get it on</span>
                                <span class="text-[11px] font-semibold">Google Play</span>
                            </div>
                        </a>
                        <!-- Generic App Store Badge -->
                        <a href="#" class="h-9 rounded flex items-center justify-center bg-black hover:bg-gray-900 text-white transition-colors px-2.5">
                            <i class="fa-brands fa-apple text-xl mr-1.5 pb-0.5"></i>
                            <div class="flex flex-col items-start leading-none">
                                <span class="text-[6px] text-gray-300">Download on the</span>
                                <span class="text-[11px] font-semibold">App Store</span>
                            </div>
                        </a>
                    </div>
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

</body>
</html>
