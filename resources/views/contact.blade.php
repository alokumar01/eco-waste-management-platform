<x-public-layout title="Contact Us | GreenLoop">

    <!-- Hero Section -->
    <section class="relative pt-16 pb-20 px-6 lg:px-12 bg-white overflow-hidden">
        <div class="landing-container grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left Text Content -->
            <div class="space-y-6 relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#F0F7F2] text-[#3E8B3A] text-xs font-extrabold tracking-wide">
                    <i class="fa-solid fa-headset text-[10px]"></i>
                    We're Here to Help
                </div>
                
                <h1 class="text-4xl lg:text-[3.2rem] font-black text-gray-900 leading-[1.1] tracking-tight">
                    Get in Touch<br>
                    <span class="text-[#3E8B3A]">We'd Love to Hear from You!</span>
                </h1>
                
                <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-xl">
                    Have questions, feedback, or need support? Our team is here to help you on your journey toward a cleaner, greener planet.
                </p>
                
                <div class="flex flex-wrap gap-6 pt-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#F0F7F2] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <h4 class="text-[12px] font-extrabold text-gray-900">Quick Response</h4>
                            <p class="text-[10px] text-gray-500 font-medium">We reply within 24 hours</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#F0F7F2] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h4 class="text-[12px] font-extrabold text-gray-900">Trusted Support</h4>
                            <p class="text-[10px] text-gray-500 font-medium">Reliable help from our team</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#F0F7F2] text-[#3E8B3A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div>
                            <h4 class="text-[12px] font-extrabold text-gray-900">Together Green</h4>
                            <p class="text-[10px] text-gray-500 font-medium">Committed to sustainable future</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Image Area -->
            <div class="relative z-10 w-full flex items-center justify-center mt-8 lg:mt-0 pointer-events-none">
                <img src="{{ asset('images/contact-page.png') }}" alt="Contact Us" class="w-full max-w-[400px] lg:max-w-none lg:w-[110%] object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-700">
            </div>
            
        </div>
    </section>

    <!-- Ways to Reach Us Section -->
    <section class="py-16 px-6 lg:px-12 bg-[#FAFCFB]">
        <div class="landing-container text-center">
            
            <h2 class="text-2xl lg:text-3xl font-extrabold text-gray-900 leading-tight mb-12">
                Ways to Reach Us
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1 -->
                <div class="bg-white border border-gray-100 rounded-[1.5rem] p-8 flex flex-col items-center hover:border-green-100 hover:shadow-[0_10px_30px_rgb(62,139,58,0.06)] transition-all">
                    <div class="w-14 h-14 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-6 border border-green-50">
                        <i class="fa-regular fa-envelope text-xl"></i>
                    </div>
                    <h4 class="text-[14px] font-extrabold text-gray-900 mb-2">Email Us</h4>
                    <a href="mailto:hello@greenloop.com" class="text-[12px] text-gray-600 font-bold hover:text-[#3E8B3A] transition-colors mb-3">hello@greenloop.com</a>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">We'll get back to you as soon as possible.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border border-gray-100 rounded-[1.5rem] p-8 flex flex-col items-center hover:border-green-100 hover:shadow-[0_10px_30px_rgb(62,139,58,0.06)] transition-all">
                    <div class="w-14 h-14 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-6 border border-green-50">
                        <i class="fa-solid fa-phone text-xl"></i>
                    </div>
                    <h4 class="text-[14px] font-extrabold text-gray-900 mb-2">Call Us</h4>
                    <a href="tel:+919876543210" class="text-[12px] text-gray-600 font-bold hover:text-[#3E8B3A] transition-colors mb-3">+91 98765 43210</a>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Mon - Sat: 9:00 AM - 6:00 PM</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border border-gray-100 rounded-[1.5rem] p-8 flex flex-col items-center hover:border-green-100 hover:shadow-[0_10px_30px_rgb(62,139,58,0.06)] transition-all">
                    <div class="w-14 h-14 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-6 border border-green-50">
                        <i class="fa-solid fa-location-dot text-xl"></i>
                    </div>
                    <h4 class="text-[14px] font-extrabold text-gray-900 mb-2">Visit Us</h4>
                    <p class="text-[11px] text-gray-600 font-bold leading-relaxed mb-1">Lovely Professional University,</p>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Jalandhar - Delhi, G.T. Road,<br>Phagwara, Punjab - 144411<br>India</p>
                </div>

                <!-- Card 4 -->
                <div class="bg-white border border-gray-100 rounded-[1.5rem] p-8 flex flex-col items-center hover:border-green-100 hover:shadow-[0_10px_30px_rgb(62,139,58,0.06)] transition-all">
                    <div class="w-14 h-14 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center mb-6 border border-green-50">
                        <i class="fa-solid fa-headset text-xl"></i>
                    </div>
                    <h4 class="text-[14px] font-extrabold text-gray-900 mb-2">Support</h4>
                    @auth
                        <a href="{{ route('help.message-admin') }}" class="text-[12px] text-gray-600 font-bold hover:text-[#3E8B3A] transition-colors mb-3">Chat with Admin</a>
                    @else
                        <a href="mailto:support@greenloop.com" class="text-[12px] text-gray-600 font-bold hover:text-[#3E8B3A] transition-colors mb-3">support@greenloop.com</a>
                    @endauth
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">For help with bookings and services.</p>
                </div>

            </div>

        </div>
    </section>

    <!-- Map & Contact Form Section -->
    <section class="py-20 px-6 lg:px-12 bg-white">
        <div class="landing-container grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            
            <!-- Left Map Embed -->
            <div class="relative w-full aspect-square md:aspect-[4/3] rounded-[2rem] overflow-hidden border border-gray-100 shadow-md">
                <!-- Google Maps Iframe -->
                <iframe 
                    src="https://maps.google.com/maps?q=Lovely+Professional+University,+Phagwara,+Punjab&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                    class="absolute inset-0 w-full h-full border-0 z-0" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- Right Contact Form -->
            <div class="bg-white border border-gray-100 shadow-[0_10px_40px_rgb(0,0,0,0.03)] rounded-[2rem] p-8 lg:p-10">
                <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Send Us a Message</h3>
                <p class="text-[13px] text-gray-500 font-medium mb-8">Fill out the form and we'll get back to you soon.</p>

                <form class="space-y-5" onsubmit="event.preventDefault(); alert('Message Sent!');">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-regular fa-user text-sm"></i>
                            </div>
                            <input type="text" placeholder="Your Name*" required class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3.5 focus:outline-none focus:border-[#3E8B3A] focus:ring-2 focus:ring-[#3E8B3A]/20 text-[13px] font-medium text-gray-900 shadow-sm transition-all">
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </div>
                            <input type="email" placeholder="Your Email*" required class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3.5 focus:outline-none focus:border-[#3E8B3A] focus:ring-2 focus:ring-[#3E8B3A]/20 text-[13px] font-medium text-gray-900 shadow-sm transition-all">
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-tag text-sm"></i>
                        </div>
                        <input type="text" placeholder="Subject*" required class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3.5 focus:outline-none focus:border-[#3E8B3A] focus:ring-2 focus:ring-[#3E8B3A]/20 text-[13px] font-medium text-gray-900 shadow-sm transition-all">
                    </div>

                    <div class="relative">
                        <div class="absolute top-3.5 left-4 pointer-events-none text-gray-400">
                            <i class="fa-solid fa-pen text-sm"></i>
                        </div>
                        <textarea rows="5" placeholder="Your Message*" required class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3.5 focus:outline-none focus:border-[#3E8B3A] focus:ring-2 focus:ring-[#3E8B3A]/20 text-[13px] font-medium text-gray-900 shadow-sm transition-all resize-none"></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-2">
                        <div class="flex items-center gap-3 text-left">
                            <div class="w-10 h-10 rounded-full bg-[#F4FCF4] text-[#3E8B3A] flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-shield-halved text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-900">We respect your privacy.</p>
                                <p class="text-[10px] text-gray-500 font-medium">Your information is safe with us.</p>
                            </div>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-[#3E8B3A] hover:bg-[#2E6F40] text-white text-[13px] font-extrabold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            Send Message <i class="fa-regular fa-paper-plane"></i>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 px-6 lg:px-12 bg-[#FAFCFB]">
        <div class="landing-container max-w-4xl mx-auto">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#F0F7F2] text-[#3E8B3A] text-[10px] font-extrabold tracking-wide mb-4">
                        <i class="fa-regular fa-circle-question"></i> FAQ
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-[13px] text-gray-500 font-medium mt-2">Find quick answers to common questions.</p>
                </div>
                
                <a href="#" class="inline-flex items-center gap-2 text-[#3E8B3A] text-xs font-extrabold hover:text-[#2E6F40] transition-colors bg-white px-5 py-2.5 rounded-full shadow-sm border border-gray-100 hover:border-green-100">
                    View All FAQs <div class="w-5 h-5 rounded-full bg-[#3E8B3A] text-white flex items-center justify-center"><i class="fa-solid fa-arrow-right text-[9px]"></i></div>
                </a>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                
                <!-- FAQ Item 1 -->
                <div class="bg-white border border-gray-100 rounded-xl p-5 flex items-center justify-between cursor-pointer hover:border-[#3E8B3A] hover:shadow-md transition-all group">
                    <span class="text-[13px] font-bold text-gray-900">What types of waste do you accept?</span>
                    <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-[#3E8B3A] transition-colors"></i>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white border border-gray-100 rounded-xl p-5 flex items-center justify-between cursor-pointer hover:border-[#3E8B3A] hover:shadow-md transition-all group">
                    <span class="text-[13px] font-bold text-gray-900">Do you offer services outside Bengaluru?</span>
                    <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-[#3E8B3A] transition-colors"></i>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white border border-gray-100 rounded-xl p-5 flex items-center justify-between cursor-pointer hover:border-[#3E8B3A] hover:shadow-md transition-all group">
                    <span class="text-[13px] font-bold text-gray-900">How do I book a service?</span>
                    <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-[#3E8B3A] transition-colors"></i>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white border border-gray-100 rounded-xl p-5 flex items-center justify-between cursor-pointer hover:border-[#3E8B3A] hover:shadow-md transition-all group">
                    <span class="text-[13px] font-bold text-gray-900">How is pricing calculated?</span>
                    <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-[#3E8B3A] transition-colors"></i>
                </div>

            </div>

        </div>
    </section>

    <!-- Newsletter Section (Appended as requested by mockup) -->
    <section class="pb-12 px-6 lg:px-12 bg-[#FAFCFB]">
        <div class="landing-container bg-white border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] rounded-[1.5rem] p-6 lg:p-8 flex flex-col xl:flex-row items-center justify-between gap-8 select-none">
            
            <!-- Left Info -->
            <div class="flex items-center gap-4 shrink-0">
                <div class="w-12 h-12 rounded-full bg-[#F4FCF4] text-[#3E8B3A] border border-green-50 flex items-center justify-center shadow-sm">
                    <i class="fa-regular fa-envelope text-lg"></i>
                </div>
                <div>
                    <h3 class="text-[14px] font-extrabold text-gray-900 mb-0.5">Stay Updated with GreenLoop</h3>
                    <p class="text-[11px] text-gray-500 font-medium">Subscribe to our newsletter for tips, updates, and offers.</p>
                </div>
            </div>

            <!-- Center Input & Submit -->
            <div class="flex-1 max-w-xl w-full flex items-center gap-3">
                <input type="email" placeholder="Enter your email address" class="flex-1 bg-white border border-gray-200 rounded-xl px-5 py-3 focus:outline-none focus:border-[#3E8B3A] focus:ring-2 focus:ring-[#3E8B3A]/20 text-[12px] font-medium text-gray-700 shadow-sm transition-all">
                <button class="px-8 py-3 rounded-xl bg-[#3E8B3A] hover:bg-[#2E6F40] text-white text-[12px] font-extrabold transition-colors shadow-md">
                    Subscribe
                </button>
            </div>

        </div>
    </section>

</x-public-layout>
