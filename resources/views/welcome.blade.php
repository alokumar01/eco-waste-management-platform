<x-public-layout>

    <main class="relative pt-12 pb-24 px-6 lg:px-12 overflow-hidden bg-[#f4fcf4]">
        
        <!-- Abstract gradient blob -->
        <div class="hero-gradient-blob"></div>

        <div class="landing-container grid lg:grid-cols-2 gap-16 items-center min-h-[600px] relative z-10">
            
            <!-- Left Content Column -->
            <div class="space-y-8 max-w-2xl relative z-20">
                
                <!-- Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#F0F7F2] border border-[#E1EFE4] text-[#3E8B3A] text-xs font-extrabold tracking-wide select-none">
                    <i class="fa-solid fa-leaf text-[10px]"></i>
                    Sustainable Living Starts Here
                </div>

                <!-- Massive Headline -->
                <h1 class="text-5xl lg:text-[4rem] font-extrabold text-gray-900 leading-[1.05] tracking-tight">
                    Together for a <br>
                    Cleaner, <span class="text-gradient-green">Greener Future</span>
                </h1>

                <!-- Subheadline -->
                <p class="text-[17px] text-gray-500 font-medium leading-relaxed max-w-xl">
                    Discover reliable composting, recycling, and waste management services near you. Book, track, and make a positive impact on our planet.
                </p>

                <!-- Features Row (Exact match to screenshot) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6 select-none">
                    
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#F0F7F2] flex items-center justify-center shrink-0 text-[#3E8B3A]">
                            <i class="fa-solid fa-leaf text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-extrabold text-[#3E8B3A] leading-tight">Eco-Friendly</span>
                            <span class="text-[9.5px] text-gray-400 font-semibold leading-tight mt-1">Sustainable solutions<br>for a better tomorrow</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#F0F7F2] flex items-center justify-center shrink-0 text-[#3E8B3A]">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-extrabold text-[#3E8B3A] leading-tight">Verified Providers</span>
                            <span class="text-[9.5px] text-gray-400 font-semibold leading-tight mt-1">Trusted & verified<br>service experts</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#F0F7F2] flex items-center justify-center shrink-0 text-[#3E8B3A]">
                            <i class="fa-regular fa-clock text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-extrabold text-[#3E8B3A] leading-tight">Easy Booking</span>
                            <span class="text-[9.5px] text-gray-400 font-semibold leading-tight mt-1">Book services in<br>just a few clicks</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#F0F7F2] flex items-center justify-center shrink-0 text-[#3E8B3A]">
                            <i class="fa-solid fa-location-dot text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-extrabold text-[#3E8B3A] leading-tight">Local & Nearby</span>
                            <span class="text-[9.5px] text-gray-400 font-semibold leading-tight mt-1">Services available<br>in your area</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Visual Column -->
            <div class="relative h-full min-h-[500px] w-full flex items-center justify-center z-10 pointer-events-none">
                
                <img src="{{ asset('images/landingpage.png') }}" alt="Green bins and compost" class="relative z-10 w-full max-w-[700px] scale-110 object-contain pointer-events-auto drop-shadow-2xl">

                <!-- Floating Leaves Decor (CSS Only) -->
                <div class="absolute top-20 left-10 w-4 h-4 bg-[#94C563] rounded-full blur-[2px] opacity-60 animate-bounce" style="border-radius: 50% 0 50% 50%; transform: rotate(45deg);"></div>
                <div class="absolute bottom-40 right-10 w-6 h-6 bg-[#4CAF50] rounded-full blur-[1px] opacity-70 animate-pulse" style="border-radius: 50% 0 50% 50%; transform: rotate(-20deg);"></div>
                <div class="absolute top-40 right-32 w-3 h-3 bg-[#3E8B3A] rounded-full blur-[1px] opacity-50" style="border-radius: 50% 0 50% 50%; transform: rotate(80deg);"></div>

            </div>
        </div>

        <!-- Bottom Stats Pill -->
        <div class="landing-container mt-16 relative z-20">
            <div class="stats-pill rounded-[2.5rem] p-8 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 divide-y md:divide-y-0 md:divide-x divide-green-900/10 select-none">
                    
                    <!-- Stat 1 -->
                    <div class="flex items-center gap-5 px-4">
                        <div class="w-16 h-16 rounded-full bg-[#E5F2E7] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-leaf text-2xl text-[#3E8B3A]"></i>
                        </div>
                        <div>
                            <h4 class="text-[28px] font-black text-gray-900 leading-none mb-1">1,250+</h4>
                            <p class="text-sm font-bold text-gray-900 leading-tight">Services Listed</p>
                            <p class="text-[10px] font-semibold text-gray-500 mt-1">Wide range of eco-services</p>
                        </div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="flex items-center gap-5 px-4 pt-6 md:pt-0">
                        <div class="w-16 h-16 rounded-full bg-[#E5F2E7] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user-group text-xl text-[#3E8B3A]"></i>
                        </div>
                        <div>
                            <h4 class="text-[28px] font-black text-gray-900 leading-none mb-1">850+</h4>
                            <p class="text-sm font-bold text-gray-900 leading-tight">Happy Customers</p>
                            <p class="text-[10px] font-semibold text-gray-500 mt-1">Satisfaction you can trust</p>
                        </div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="flex items-center gap-5 px-4 pt-6 md:pt-0">
                        <div class="w-16 h-16 rounded-full bg-[#E5F2E7] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-check text-xl text-[#3E8B3A]"></i>
                        </div>
                        <div>
                            <h4 class="text-[28px] font-black text-gray-900 leading-none mb-1">150+</h4>
                            <p class="text-sm font-bold text-gray-900 leading-tight">Verified Providers</p>
                            <p class="text-[10px] font-semibold text-gray-500 mt-1">Experts you can rely on</p>
                        </div>
                    </div>

                    <!-- Stat 4 -->
                    <div class="flex items-center gap-5 px-4 pt-6 md:pt-0">
                        <div class="w-16 h-16 rounded-full bg-[#E5F2E7] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-earth-americas text-xl text-[#3E8B3A]"></i>
                        </div>
                        <div>
                            <h4 class="text-[28px] font-black text-gray-900 leading-none mb-1">12+</h4>
                            <p class="text-sm font-bold text-gray-900 leading-tight">Cities Covered</p>
                            <p class="text-[10px] font-semibold text-gray-500 mt-1">Expanding for a greener world</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>

    <!-- Our Services Section -->
    <section class="bg-white py-24 px-6 lg:px-12">
        <div class="landing-container grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <!-- Left Text Content -->
            <div class="lg:col-span-5 space-y-6 select-none">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#F0F7F2] text-[#3E8B3A] text-xs font-extrabold tracking-wide">
                    <i class="fa-solid fa-leaf text-[10px]"></i>
                    Our Services
                </div>
                
                <h2 class="text-4xl lg:text-[2.75rem] font-extrabold text-gray-900 leading-[1.1] tracking-tight">
                    Services for Every<br>Sustainable Need
                </h2>
                
                <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-md">
                    From composting to recycling and beyond, we connect you with trusted experts for a cleaner, greener tomorrow.
                </p>
                
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('services.list') }}" class="px-6 py-3.5 rounded-xl bg-[#3E8B3A] hover:bg-[#2D7A28] text-white text-xs font-extrabold tracking-wide transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        Explore All Services <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Right Cards Grid -->
            <div class="lg:col-span-7 grid sm:grid-cols-2 gap-4 lg:gap-5 select-none relative z-10">
                <!-- Floating decorative leaf -->
                <div class="absolute -top-10 -left-10 w-4 h-4 bg-[#94C563] rounded-full blur-[1px] opacity-60 pointer-events-none" style="border-radius: 50% 0 50% 50%; transform: rotate(-30deg);"></div>
                <div class="absolute top-20 -left-6 w-3 h-3 bg-[#4CAF50] rounded-full blur-[1px] opacity-70 pointer-events-none" style="border-radius: 50% 0 50% 50%; transform: rotate(15deg);"></div>

                @php
                    $services = [
                        ['icon' => 'fa-seedling', 'title' => 'Composting Services', 'desc' => 'Convert kitchen waste into nutrient-rich compost.'],
                        ['icon' => 'fa-recycle', 'title' => 'Recycling Services', 'desc' => 'Recycle plastic, paper, glass, metal and more.'],
                        ['icon' => 'fa-battery-empty', 'title' => 'E-Waste Management', 'desc' => 'Safe collection and responsible disposal of e-waste.'],
                        ['icon' => 'fa-truck-fast', 'title' => 'Organic Waste Pickup', 'desc' => 'Doorstep pickup of organic waste from your home.'],
                        ['icon' => 'fa-sack-xmark', 'title' => 'Garden Waste Collection', 'desc' => 'We collect and recycle garden waste efficiently.'],
                        ['icon' => 'fa-building', 'title' => 'Commercial Solutions', 'desc' => 'Tailored waste management for businesses.']
                    ];
                @endphp

                @foreach($services as $service)
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgba(62,139,58,0.06)] hover:border-green-100 transition-all group flex gap-4 cursor-pointer">
                    <div class="w-14 h-14 rounded-2xl bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid {{ $service['icon'] }} text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[14px] font-extrabold text-gray-900 leading-tight mb-1">{{ $service['title'] }}</h3>
                        <p class="text-[11px] text-gray-500 font-medium leading-snug max-w-[200px]">{{ $service['desc'] }}</p>
                    </div>
                    <div class="ml-auto mt-auto mb-1 w-6 h-6 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shrink-0 -translate-x-2 group-hover:translate-x-0">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="bg-[#f4fcf4] py-24 px-6 lg:px-12 relative overflow-hidden">
        
        <!-- Background Leaf Decor -->
        <div class="absolute left-0 top-20 opacity-30 pointer-events-none select-none">
            <!-- Simulated large branch using CSS borders and rounded corners -->
            <div class="w-64 h-64 border-t-4 border-r-4 border-[#3E8B3A]/40 rounded-tr-[100%] absolute -left-10 top-0"></div>
            <!-- Leaves attached to branch -->
            <div class="absolute top-10 left-20 w-8 h-8 bg-[#94C563] rounded-full blur-[1px]" style="border-radius: 50% 0 50% 50%; transform: rotate(15deg);"></div>
            <div class="absolute top-32 left-40 w-12 h-12 bg-[#4CAF50] rounded-full blur-[1px]" style="border-radius: 50% 0 50% 50%; transform: rotate(45deg);"></div>
            <div class="absolute top-48 left-20 w-10 h-10 bg-[#3E8B3A] rounded-full blur-[1px]" style="border-radius: 50% 0 50% 50%; transform: rotate(100deg);"></div>
        </div>
        <div class="absolute right-10 top-32 opacity-40 pointer-events-none select-none">
            <div class="absolute top-0 right-10 w-6 h-6 bg-[#94C563] rounded-full blur-[1px]" style="border-radius: 50% 0 50% 50%; transform: rotate(-30deg);"></div>
            <div class="absolute top-16 right-32 w-5 h-5 bg-[#4CAF50] rounded-full blur-[1px]" style="border-radius: 50% 0 50% 50%; transform: rotate(-70deg);"></div>
            <div class="absolute top-40 right-16 w-8 h-8 bg-[#3E8B3A] rounded-full blur-[1px]" style="border-radius: 50% 0 50% 50%; transform: rotate(-10deg);"></div>
        </div>

        <div class="landing-container relative z-10">
            
            <!-- Center Header -->
            <div class="text-center max-w-2xl mx-auto space-y-4 mb-16 select-none">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-green-100 text-[#3E8B3A] text-[11px] font-extrabold tracking-wide shadow-sm">
                    <i class="fa-solid fa-leaf text-[10px]"></i> How It Works
                </div>
                <h2 class="text-3xl lg:text-[2.5rem] font-extrabold text-gray-900 leading-tight">
                    Simple Steps, Big Impact
                </h2>
                <p class="text-[14px] text-gray-500 font-medium">
                    Getting started with GreenLoop is easy. Follow these simple steps to make a difference.
                </p>
            </div>

            <!-- Steps Grid -->
            <div class="relative grid md:grid-cols-4 gap-6 lg:gap-8 mb-20 select-none">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden md:block absolute top-6 left-[10%] right-[10%] h-[2px] border-t-2 border-dashed border-[#3E8B3A]/30 z-0"></div>

                @php
                    $steps = [
                        ['num' => '1', 'icon' => 'fa-magnifying-glass', 'title' => 'Search Services', 'desc' => 'Find the best waste management or composting services near you.'],
                        ['num' => '2', 'icon' => 'fa-calendar-check', 'title' => 'Book & Schedule', 'desc' => 'Choose a convenient time and book the service with ease.'],
                        ['num' => '3', 'icon' => 'fa-truck-ramp-box', 'title' => 'We Collect / Serve', 'desc' => 'Our verified experts collect your waste or provide the service.'],
                        ['num' => '4', 'icon' => 'fa-hand-holding-hand', 'title' => 'You Make an Impact', 'desc' => 'Your small step helps create a cleaner and greener planet.']
                    ];
                @endphp

                @foreach($steps as $step)
                <div class="relative z-10 flex flex-col items-center text-center mt-6 md:mt-0">
                    <!-- Step Number Indicator -->
                    <div class="w-8 h-8 rounded-full bg-[#3E8B3A] text-white text-xs font-black flex items-center justify-center absolute -top-4 shadow-sm z-20">
                        {{ $step['num'] }}
                    </div>
                    
                    <!-- Card Body -->
                    <div class="bg-white rounded-2xl w-full p-8 pt-10 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] h-full flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-5 shrink-0">
                            <i class="fa-solid {{ $step['icon'] }} text-2xl"></i>
                        </div>
                        <h3 class="text-[15px] font-extrabold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                        <p class="text-[12px] text-gray-500 font-medium leading-relaxed max-w-[200px]">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Trusted by Thousands Footer Block -->
            <div class="bg-white rounded-[2rem] p-6 lg:p-8 shadow-[0_10px_40px_rgb(0,0,0,0.03)] border border-gray-50 flex flex-col xl:flex-row items-center justify-between gap-8 select-none">
                
                <!-- Left Content -->
                <div class="flex items-center gap-5 shrink-0">
                    <div class="w-14 h-14 rounded-2xl bg-[#F4FCF4] text-[#3E8B3A] border border-green-100 flex items-center justify-center">
                        <i class="fa-solid fa-shield-check text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900 leading-tight mb-1">Trusted by Thousands</h3>
                        <p class="text-[11px] text-gray-500 font-medium max-w-[200px] leading-snug">Join a growing community that cares for the environment.</p>
                    </div>
                </div>

                <!-- Right Trust Indicators -->
                <div class="flex flex-wrap md:flex-nowrap items-center gap-x-8 gap-y-6 flex-1 xl:justify-end divide-y md:divide-y-0 md:divide-x divide-gray-100">
                    
                    <div class="flex items-center gap-3 md:px-6 pt-4 md:pt-0 w-full sm:w-auto">
                        <div class="w-10 h-10 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-heart text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[12px] font-extrabold text-gray-800 leading-tight">Verified & Trusted</span>
                            <span class="text-[10px] text-gray-400 font-medium mt-0.5">Service Providers</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 md:px-6 pt-4 md:pt-0 w-full sm:w-auto">
                        <div class="w-10 h-10 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[12px] font-extrabold text-gray-800 leading-tight">Secure & Easy</span>
                            <span class="text-[10px] text-gray-400 font-medium mt-0.5">Online Booking</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 md:px-6 pt-4 md:pt-0 w-full sm:w-auto">
                        <div class="w-10 h-10 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-tags text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[12px] font-extrabold text-gray-800 leading-tight">Transparent Pricing</span>
                            <span class="text-[10px] text-gray-400 font-medium mt-0.5">No Hidden Charges</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 md:pl-6 pt-4 md:pt-0 w-full sm:w-auto">
                        <div class="w-10 h-10 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-headset text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[12px] font-extrabold text-gray-800 leading-tight">Customer Support</span>
                            <span class="text-[10px] text-gray-400 font-medium mt-0.5">We're Here to Help</span>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="bg-white py-24 px-6 lg:px-12 overflow-hidden">
        <div class="landing-container grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Left Text Column -->
            <div class="lg:col-span-4 space-y-6 select-none relative z-10 pr-4">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#F0F7F2] text-[#3E8B3A] text-xs font-extrabold tracking-wide">
                    <i class="fa-regular fa-comment-dots text-[11px]"></i>
                    What Our Customers Say
                </div>
                
                <h2 class="text-3xl lg:text-[2.5rem] font-extrabold text-gray-900 leading-[1.1] tracking-tight">
                    Trusted by Thousands<br>of Happy Customers
                </h2>
                
                <p class="text-[14px] text-gray-500 font-medium leading-relaxed">
                    Real stories from real people making a positive impact with GreenLoop.
                </p>

                <div class="flex items-center gap-4 pt-2">
                    <span class="text-5xl font-black text-[#3E8B3A] tracking-tighter">4.8</span>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1 text-[#FFC107] text-sm">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-[11px] text-gray-500 font-bold">(1,250+ Reviews)</span>
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm" src="https://i.pravatar.cc/100?img=1" alt="Avatar">
                        <img class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm" src="https://i.pravatar.cc/100?img=2" alt="Avatar">
                        <img class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm" src="https://i.pravatar.cc/100?img=3" alt="Avatar">
                        <img class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm" src="https://i.pravatar.cc/100?img=4" alt="Avatar">
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-[#E5F2E7] text-[#3E8B3A] flex items-center justify-center text-[10px] font-black z-10 shadow-sm">+1K</div>
                    </div>
                    <p class="text-[11px] text-gray-500 font-medium leading-snug max-w-[120px]">Join thousands of satisfied customers</p>
                </div>
            </div>

            <!-- Right Testimonials Slider -->
            <div class="lg:col-span-8 relative">
                <div class="flex gap-6 overflow-x-auto pb-8 snap-x hide-scrollbar" style="scrollbar-width: none;">
                    
                    <!-- Card 1 -->
                    <div class="min-w-[320px] md:min-w-[350px] bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] snap-start flex flex-col justify-between select-none">
                        <div>
                            <div class="flex items-start justify-between mb-4">
                                <i class="fa-solid fa-quote-left text-3xl text-[#94C563]/30"></i>
                                <div class="flex items-center gap-1 text-[#FFC107] text-xs">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                            </div>
                            <p class="text-[14px] text-gray-600 font-medium leading-relaxed mb-8">
                                GreenLoop made composting so easy! The team set up everything at my home and explained the process well. My kitchen waste has never been more useful.
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <img class="w-11 h-11 rounded-full object-cover" src="https://i.pravatar.cc/100?img=5" alt="Sneha R.">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-[13px] font-extrabold text-gray-900">Sneha R.</h4>
                                    <span class="bg-[#F0F7F2] text-[#3E8B3A] text-[9px] font-extrabold px-1.5 py-0.5 rounded flex items-center gap-1"><i class="fa-solid fa-circle-check"></i> Verified Buyer</span>
                                </div>
                                <p class="text-[11px] text-gray-400 font-medium flex items-center gap-1 mt-0.5"><i class="fa-solid fa-location-dot"></i> Bengaluru</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="min-w-[320px] md:min-w-[350px] bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] snap-start flex flex-col justify-between select-none">
                        <div>
                            <div class="flex items-start justify-between mb-4">
                                <i class="fa-solid fa-quote-left text-3xl text-[#94C563]/30"></i>
                                <div class="flex items-center gap-1 text-[#FFC107] text-xs">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                            </div>
                            <p class="text-[14px] text-gray-600 font-medium leading-relaxed mb-8">
                                Excellent service! They collect e-waste from our office regularly. Very professional and committed to environment sustainability.
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <img class="w-11 h-11 rounded-full object-cover" src="https://i.pravatar.cc/100?img=8" alt="Rohit Mehta">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-[13px] font-extrabold text-gray-900">Rohit Mehta</h4>
                                    <span class="bg-[#F0F7F2] text-[#3E8B3A] text-[9px] font-extrabold px-1.5 py-0.5 rounded flex items-center gap-1"><i class="fa-solid fa-circle-check"></i> Verified Buyer</span>
                                </div>
                                <p class="text-[11px] text-gray-400 font-medium flex items-center gap-1 mt-0.5"><i class="fa-solid fa-location-dot"></i> Koramangala, Bengaluru</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="min-w-[320px] md:min-w-[350px] bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] snap-start flex flex-col justify-between select-none">
                        <div>
                            <div class="flex items-start justify-between mb-4">
                                <i class="fa-solid fa-quote-left text-3xl text-[#94C563]/30"></i>
                                <div class="flex items-center gap-1 text-[#FFC107] text-xs">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                            </div>
                            <p class="text-[14px] text-gray-600 font-medium leading-relaxed mb-8">
                                I love the garden waste pickup service. My balcony garden stays clean and the plants love the compost I receive!
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <img class="w-11 h-11 rounded-full object-cover" src="https://i.pravatar.cc/100?img=9" alt="Ananya P.">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-[13px] font-extrabold text-gray-900">Ananya P.</h4>
                                    <span class="bg-[#F0F7F2] text-[#3E8B3A] text-[9px] font-extrabold px-1.5 py-0.5 rounded flex items-center gap-1"><i class="fa-solid fa-circle-check"></i> Verified Buyer</span>
                                </div>
                                <p class="text-[11px] text-gray-400 font-medium flex items-center gap-1 mt-0.5"><i class="fa-solid fa-location-dot"></i> Whitefield, Bengaluru</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slider Controls -->
                <div class="flex items-center justify-between mt-2 px-2 select-none">
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-[#3E8B3A]"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-gray-200 cursor-pointer"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-gray-200 cursor-pointer"></div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="w-8 h-8 rounded-full bg-[#F0F7F2] text-[#3E8B3A] hover:bg-[#E1EFE4] flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                        </button>
                        <button class="w-8 h-8 rounded-full bg-[#3E8B3A] text-white hover:bg-[#2D7A28] flex items-center justify-center transition-colors shadow-md">
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Banner Section -->
    <section class="py-12 px-6 lg:px-12 bg-white">
        <div class="landing-container bg-[#F4FCF4] rounded-[2.5rem] relative overflow-hidden flex flex-col lg:flex-row items-center border border-green-50/50 shadow-inner">
            
            <!-- Background Graphic Elements -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="absolute -left-20 -top-20 w-[400px] h-[400px] border-[40px] border-[#3E8B3A]/5 rounded-full blur-sm"></div>
                <div class="absolute right-[20%] top-1/2 -translate-y-1/2 w-[500px] h-[500px] border-[60px] border-white/50 rounded-full blur-md"></div>
                <!-- Flying Leaves -->
                <i class="fa-solid fa-leaf text-[#94C563] text-xl absolute top-12 left-1/3 opacity-40 rotate-12 blur-[1px]"></i>
                <i class="fa-solid fa-leaf text-[#4CAF50] text-3xl absolute bottom-20 left-1/2 opacity-50 -rotate-45"></i>
                <i class="fa-solid fa-leaf text-[#3E8B3A] text-2xl absolute top-32 right-[45%] opacity-60 rotate-[120deg] blur-[2px]"></i>
            </div>

            <!-- Left Content -->
            <div class="lg:w-5/12 p-10 lg:p-16 relative z-10 select-none">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-transparent text-[#3E8B3A] text-[11px] font-black tracking-widest uppercase mb-4">
                    <i class="fa-solid fa-leaf text-[10px]"></i> Make a Difference Today
                </div>
                
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                    Join the <span class="text-gradient-green">Green</span> Movement
                </h2>
                
                <p class="text-[14px] text-gray-600 font-medium leading-relaxed mb-8 max-w-sm">
                    Whether you're looking to compost, recycle, or dispose of waste responsibly, GreenLoop connects you with trusted experts near you.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('login') }}" class="px-6 py-3.5 rounded-xl bg-[#3E8B3A] hover:bg-[#2D7A28] text-white text-xs font-extrabold tracking-wide transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        Get Started Now <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-3.5 rounded-xl bg-transparent border-2 border-[#3E8B3A] text-[#3E8B3A] hover:bg-[#3E8B3A] hover:text-white text-xs font-extrabold tracking-wide transition-all flex items-center gap-2">
                        Become a Service Provider <i class="fa-solid fa-users text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Center Image -->
            <div class="lg:w-3/12 relative z-10 flex justify-center items-center h-full min-h-[300px] pointer-events-none mt-8 lg:mt-0">
                <img src="{{ asset('images/landing-page-2.png') }}" alt="Join the Green Movement" class="w-full max-w-[280px] lg:max-w-none lg:w-[120%] lg:-ml-[10%] object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-700">
            </div>

            <!-- Right Content (Features Card) -->
            <div class="lg:w-4/12 p-8 lg:p-16 relative z-10 flex justify-end">
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 shadow-[0_10px_40px_rgb(0,0,0,0.05)] border border-white w-full max-w-sm flex flex-col gap-6 select-none">
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-[13px] font-extrabold text-gray-900 mb-0.5">Reduce Waste</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-snug">Help reduce waste in landfills</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-leaf text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-[13px] font-extrabold text-gray-900 mb-0.5">Save Environment</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-snug">Contribute to a cleaner planet</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-hands-holding-circle text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-[13px] font-extrabold text-gray-900 mb-0.5">Build a Better Future</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-snug">Create a sustainable future for all</p>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="pb-12 px-6 lg:px-12 bg-white">
        <div class="landing-container bg-[#F9F9F8] rounded-2xl p-6 lg:p-8 flex flex-col xl:flex-row items-center justify-between gap-8 select-none">
            
            <!-- Left Info -->
            <div class="flex items-center gap-4 shrink-0">
                <div class="w-12 h-12 rounded-full bg-[#3E8B3A] text-white flex items-center justify-center shadow-md">
                    <i class="fa-regular fa-envelope text-lg"></i>
                </div>
                <div>
                    <h3 class="text-[15px] font-extrabold text-gray-900 mb-0.5">Stay Updated with Green News</h3>
                    <p class="text-[12px] text-gray-500 font-medium">Subscribe to our newsletter for tips, updates, and offers.</p>
                </div>
            </div>

            <!-- Center Input -->
            <div class="flex-1 max-w-xl w-full">
                <div class="relative flex items-center w-full">
                    <input type="email" placeholder="Enter your email address" class="w-full bg-white border border-gray-200 rounded-xl pl-5 pr-32 py-3.5 focus:outline-none focus:border-[#3E8B3A] focus:ring-2 focus:ring-[#3E8B3A]/20 text-[13px] font-medium text-gray-700 shadow-sm transition-all">
                    <button class="absolute right-1.5 px-6 py-2.5 rounded-lg bg-[#3E8B3A] hover:bg-[#2D7A28] text-white text-[12px] font-extrabold transition-colors">
                        Subscribe
                    </button>
                </div>
            </div>

            <!-- Right Socials -->
            <div class="flex items-center gap-4 shrink-0">
                <span class="text-[12px] font-extrabold text-gray-900 mr-2">Follow Us On</span>
                <div class="flex items-center gap-2">
                    <a href="#" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#1877F2] hover:bg-gray-50 transition-colors"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#E4405F] hover:bg-gray-50 transition-colors"><i class="fa-brands fa-instagram text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#1DA1F2] hover:bg-gray-50 transition-colors"><i class="fa-brands fa-twitter text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#0A66C2] hover:bg-gray-50 transition-colors"><i class="fa-brands fa-linkedin-in text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#FF0000] hover:bg-gray-50 transition-colors"><i class="fa-brands fa-youtube text-xs"></i></a>
                </div>
            </div>

        </div>
    </section>

</x-public-layout>