<x-public-layout title="About Us | GreenLoop">

    <!-- Hero Section -->
    <section class="relative pt-16 pb-24 px-6 lg:px-12 bg-white overflow-hidden">
        <div class="landing-container grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left Text Content -->
            <div class="space-y-6 relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#F0F7F2] text-[#3E8B3A] text-xs font-extrabold tracking-wide">
                    <i class="fa-solid fa-leaf text-[10px]"></i>
                    About GreenLoop
                </div>
                
                <h1 class="text-4xl lg:text-[3.2rem] font-black text-gray-900 leading-[1.1] tracking-tight">
                    Building a Cleaner,<br>
                    <span class="text-[#3E8B3A]">Greener</span> Tomorrow
                </h1>
                
                <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-xl">
                    GreenLoop is a digital platform that connects communities with trusted waste management and composting experts. Our mission is to make sustainable living simple, accessible, and impactful for everyone.
                </p>
                
                <div class="grid sm:grid-cols-2 gap-6 pt-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#F0F7F2] text-[#3E8B3A] flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa-solid fa-bullseye text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-[14px] font-extrabold text-gray-900 mb-1">Our Mission</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">
                                To promote eco-friendly waste management practices and build a cleaner, greener world for future generations.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#F0F7F2] text-[#3E8B3A] flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa-regular fa-eye text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-[14px] font-extrabold text-gray-900 mb-1">Our Vision</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">
                                A world where every household and business manages waste responsibly and contributes to a sustainable planet.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Image Area -->
            <div class="relative z-10 w-full mt-8 lg:mt-0 group">
                <div class="w-full aspect-[4/3] rounded-[2rem] overflow-hidden shadow-xl">
                    <img src="{{ asset('images/about-page-1.png') }}" alt="About GreenLoop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
                
                <!-- Floating Sustainable Impact Card -->
                <div class="absolute bottom-6 right-6 bg-[#2D4A22]/95 backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-2xl max-w-[220px]">
                    <div class="w-8 h-8 rounded-full bg-[#4CAF50] text-white flex items-center justify-center mb-3 shadow-md">
                        <i class="fa-solid fa-leaf text-xs"></i>
                    </div>
                    <h4 class="text-white text-[13px] font-extrabold mb-1">Sustainable Impact</h4>
                    <p class="text-green-100 text-[10px] font-medium leading-snug">Every small step today creates a big change tomorrow.</p>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-24 px-6 lg:px-12 bg-[#FAFCFB] relative overflow-hidden">
        <div class="landing-container grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left Image Area -->
            <div class="relative z-10 w-full mb-8 lg:mb-0 group">
                <div class="w-full aspect-[4/3] rounded-[2rem] overflow-hidden shadow-xl">
                    <img src="{{ asset('images/about-page-2.png') }}" alt="Our Story" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>

                <!-- Floating Join Us Card (Breaks outside the box slightly) -->
                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-6 shadow-xl max-w-[180px] border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-4">
                        <i class="fa-solid fa-users text-sm"></i>
                    </div>
                    <p class="text-gray-600 text-[11px] font-bold leading-relaxed">Join thousands of people making a positive impact.</p>
                </div>
            </div>

            <!-- Right Text Content & Timeline -->
            <div class="space-y-6 relative z-10">
                <span class="text-[#3E8B3A] text-xs font-extrabold tracking-wide uppercase">Our Story</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight">
                    How GreenLoop Began
                </h2>
                
                <div class="space-y-4 text-[14px] text-gray-500 font-medium leading-relaxed">
                    <p>
                        GreenLoop was born out of a simple idea—that waste isn't useless, it's a resource. We saw a gap between people who want to live sustainably and the lack of trusted services to help them do it easily.
                    </p>
                    <p>
                        So, we built GreenLoop to bring everything together in one place—from composting and recycling to waste pickups and expert guidance.
                    </p>
                    <p>
                        Today, we're proud to be a growing community of eco-conscious individuals, verified service providers, and sustainability advocates working together for a better planet.
                    </p>
                </div>

                <!-- Horizontal Timeline -->
                <div class="pt-8 grid grid-cols-4 gap-4 relative">
                    
                    <!-- Milestone 1 -->
                    <div class="flex flex-col relative z-10">
                        <div class="w-12 h-12 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-4">
                            <i class="fa-solid fa-seedling text-lg"></i>
                        </div>
                        <h4 class="text-[#3E8B3A] font-black text-sm mb-1">2022</h4>
                        <span class="text-gray-900 font-bold text-[12px] mb-1">The Idea</span>
                        <p class="text-gray-500 text-[9px] font-medium leading-tight">Recognized the need for sustainable waste solutions.</p>
                        <!-- Connector Arrow -->
                        <div class="hidden sm:flex absolute top-6 -right-3 text-gray-200"><i class="fa-solid fa-arrow-right-long text-sm"></i></div>
                    </div>

                    <!-- Milestone 2 -->
                    <div class="flex flex-col relative z-10">
                        <div class="w-12 h-12 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-4">
                            <i class="fa-solid fa-users-gear text-lg"></i>
                        </div>
                        <h4 class="text-[#3E8B3A] font-black text-sm mb-1">2023</h4>
                        <span class="text-gray-900 font-bold text-[12px] mb-1">We Started</span>
                        <p class="text-gray-500 text-[9px] font-medium leading-tight">Built the platform and onboarded our first service providers.</p>
                        <!-- Connector Arrow -->
                        <div class="hidden sm:flex absolute top-6 -right-3 text-gray-200"><i class="fa-solid fa-arrow-right-long text-sm"></i></div>
                    </div>

                    <!-- Milestone 3 -->
                    <div class="flex flex-col relative z-10">
                        <div class="w-12 h-12 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-4">
                            <i class="fa-solid fa-globe text-lg"></i>
                        </div>
                        <h4 class="text-[#3E8B3A] font-black text-sm mb-1">2024</h4>
                        <span class="text-gray-900 font-bold text-[12px] mb-1">Growing Together</span>
                        <p class="text-gray-500 text-[9px] font-medium leading-tight">Expanded to more cities and helped thousands live sustainably.</p>
                        <!-- Connector Arrow -->
                        <div class="hidden sm:flex absolute top-6 -right-3 text-gray-200"><i class="fa-solid fa-arrow-right-long text-sm"></i></div>
                    </div>

                    <!-- Milestone 4 -->
                    <div class="flex flex-col relative z-10">
                        <div class="w-12 h-12 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-4">
                            <i class="fa-solid fa-tree text-lg"></i>
                        </div>
                        <h4 class="text-[#3E8B3A] font-black text-sm mb-1">Future</h4>
                        <span class="text-gray-900 font-bold text-[12px] mb-1">A Greener World</span>
                        <p class="text-gray-500 text-[9px] font-medium leading-tight">Continuing to innovate and create a lasting environmental impact.</p>
                    </div>

                </div>

            </div>
            
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="py-24 px-6 lg:px-12 bg-white text-center">
        <div class="landing-container">
            
            <span class="text-[#3E8B3A] text-xs font-extrabold tracking-wide uppercase block mb-3">Our Values</span>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight mb-16">
                What Drives Us Every Day
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                
                <!-- Value 1 -->
                <div class="bg-white border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] hover:shadow-[0_10px_30px_rgb(62,139,58,0.06)] hover:border-green-100 rounded-[1.5rem] p-8 flex flex-col items-center transition-all">
                    <div class="w-14 h-14 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-6">
                        <i class="fa-solid fa-leaf text-xl"></i>
                    </div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-2">Sustainability First</h4>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">We prioritize eco-friendly practices in everything we do.</p>
                </div>

                <!-- Value 2 -->
                <div class="bg-white border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] hover:shadow-[0_10px_30px_rgb(62,139,58,0.06)] hover:border-green-100 rounded-[1.5rem] p-8 flex flex-col items-center transition-all">
                    <div class="w-14 h-14 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-6">
                        <i class="fa-solid fa-shield-halved text-xl"></i>
                    </div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-2">Trust & Transparency</h4>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">We verify our service providers and ensure complete transparency.</p>
                </div>

                <!-- Value 3 -->
                <div class="bg-white border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] hover:shadow-[0_10px_30px_rgb(62,139,58,0.06)] hover:border-green-100 rounded-[1.5rem] p-8 flex flex-col items-center transition-all">
                    <div class="w-14 h-14 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-6">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-2">Community Focused</h4>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">We empower communities to take charge of their waste responsibly.</p>
                </div>

                <!-- Value 4 -->
                <div class="bg-white border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] hover:shadow-[0_10px_30px_rgb(62,139,58,0.06)] hover:border-green-100 rounded-[1.5rem] p-8 flex flex-col items-center transition-all">
                    <div class="w-14 h-14 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-6">
                        <i class="fa-regular fa-lightbulb text-xl"></i>
                    </div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-2">Innovation</h4>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">We use technology and smart solutions to make sustainability simple.</p>
                </div>

                <!-- Value 5 -->
                <div class="bg-white border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] hover:shadow-[0_10px_30px_rgb(62,139,58,0.06)] hover:border-green-100 rounded-[1.5rem] p-8 flex flex-col items-center transition-all">
                    <div class="w-14 h-14 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-6">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </div>
                    <h4 class="text-[13px] font-extrabold text-gray-900 mb-2">Care & Responsibility</h4>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">We care for our planet and take responsibility for a better tomorrow.</p>
                </div>

            </div>

        </div>
    </section>

    <!-- Our Impact Section -->
    <section class="pb-24 px-6 lg:px-12 bg-white">
        <div class="landing-container bg-[#214321] rounded-[2rem] p-10 lg:p-16 flex flex-col lg:flex-row items-center justify-between gap-12 relative overflow-hidden">
            
            <!-- Abstract subtle texture -->
            <div class="absolute right-0 top-0 w-1/2 h-full opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at center, #ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>

            <!-- Left Text -->
            <div class="relative z-10 lg:w-1/3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded border border-white/20 bg-white/5 text-green-100 text-[10px] font-bold tracking-wide mb-4">
                    <i class="fa-solid fa-chart-line"></i> Our Impact
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white leading-tight mb-4">
                    Small Steps,<br>
                    <span class="text-[#94C563]">Big Impact</span>
                </h2>
                <p class="text-[13px] text-green-100/80 font-medium leading-relaxed">
                    Together, we're creating a cleaner and healthier planet.
                </p>
            </div>

            <!-- Right Stats Grid -->
            <div class="relative z-10 lg:w-2/3 grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-4 text-center divide-x-0 md:divide-x divide-white/10">
                
                <div class="flex flex-col items-center px-4">
                    <div class="w-12 h-12 rounded-full bg-[#3E8B3A] text-white flex items-center justify-center mb-4">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <span class="text-2xl font-black text-white mb-1">1,250+</span>
                    <h4 class="text-white text-[12px] font-bold mb-1">Services Listed</h4>
                    <p class="text-[9px] text-green-100/60 font-medium">Wide range of eco-services</p>
                </div>

                <div class="flex flex-col items-center px-4">
                    <div class="w-12 h-12 rounded-full bg-[#3E8B3A] text-white flex items-center justify-center mb-4">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <span class="text-2xl font-black text-white mb-1">850+</span>
                    <h4 class="text-white text-[12px] font-bold mb-1">Happy Customers</h4>
                    <p class="text-[9px] text-green-100/60 font-medium">Satisfaction you can trust</p>
                </div>

                <div class="flex flex-col items-center px-4">
                    <div class="w-12 h-12 rounded-full bg-[#3E8B3A] text-white flex items-center justify-center mb-4">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <span class="text-2xl font-black text-white mb-1">150+</span>
                    <h4 class="text-white text-[12px] font-bold mb-1">Verified Providers</h4>
                    <p class="text-[9px] text-green-100/60 font-medium">Experts you can rely on</p>
                </div>

                <div class="flex flex-col items-center px-4">
                    <div class="w-12 h-12 rounded-full bg-[#3E8B3A] text-white flex items-center justify-center mb-4">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <span class="text-2xl font-black text-white mb-1">12+</span>
                    <h4 class="text-white text-[12px] font-bold mb-1">Cities Covered</h4>
                    <p class="text-[9px] text-green-100/60 font-medium">Expanding for a greener world</p>
                </div>

            </div>

        </div>
    </section>

</x-public-layout>
