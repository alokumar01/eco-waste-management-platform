<x-public-layout title="Help Center | GreenLoop">

    <!-- Header / Hero Section -->
    <section class="relative pt-16 pb-20 px-6 lg:px-12 bg-white overflow-hidden border-b border-gray-150">
        <div class="landing-container max-w-4xl text-center space-y-6">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#F0F7F2] text-[#3E8B3A] text-xs font-extrabold tracking-wide">
                <i class="fa-solid fa-headset text-[10px]"></i>
                Help Center
            </div>
            <h1 class="text-4xl lg:text-5xl font-black text-gray-900 leading-[1.1] tracking-tight">
                How Can We Help You?
            </h1>
            <p class="text-[14px] text-gray-500 font-medium leading-relaxed max-w-xl mx-auto">
                Find articles, guides, and customer support channels to resolve your queries.
            </p>
        </div>
    </section>

    <!-- Support Categories -->
    <section class="py-20 px-6 lg:px-12 bg-[#FAFCFB]">
        <div class="landing-container max-w-4xl space-y-16">
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Card 1 -->
                <div class="bg-white border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.01)] hover:border-green-150 rounded-2xl p-8 flex gap-5 items-start transition-all">
                    <div class="w-12 h-12 rounded-full bg-[#F0F7F2] text-[#3E8B3A] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-circle-user text-xl"></i>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-extrabold text-gray-900">Account & Verification</h3>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed">
                            Need help verifying your provider account or resetting credentials? Read our account guides.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.01)] hover:border-green-150 rounded-2xl p-8 flex gap-5 items-start transition-all">
                    <div class="w-12 h-12 rounded-full bg-[#F0F7F2] text-[#3E8B3A] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-calendar-check text-xl"></i>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-extrabold text-gray-900">Bookings & Pickups</h3>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed">
                            Learn how request scheduling, routing, accepting bookings, and completing pickups works on GreenLoop.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.01)] hover:border-green-150 rounded-2xl p-8 flex gap-5 items-start transition-all">
                    <div class="w-12 h-12 rounded-full bg-[#F0F7F2] text-[#3E8B3A] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-credit-card text-xl"></i>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-extrabold text-gray-900">Payments & Refunds</h3>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed">
                            Find details regarding UPI payments, booking statuses, automated refund payouts, and invoice tracking.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.01)] hover:border-green-150 rounded-2xl p-8 flex gap-5 items-start transition-all">
                    <div class="w-12 h-12 rounded-full bg-[#F0F7F2] text-[#3E8B3A] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-extrabold text-gray-900">Safety & Prohibited Items</h3>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed">
                            Understand guidelines for acceptable materials, hazardous waste regulations, and neighborhood safety policies.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Get in touch Banner -->
            <div class="bg-white border border-gray-100 shadow-md rounded-3xl p-8 text-center max-w-xl mx-auto space-y-6">
                <h3 class="text-lg font-extrabold text-gray-900">Still have questions?</h3>
                <p class="text-xs text-gray-500 font-medium leading-relaxed">
                    Our team is here to assist you with any questions or support requests. Get in touch directly and we'll reply as soon as possible.
                </p>
                <div>
                    @auth
                        <a href="{{ route('help.message-admin') }}" class="inline-block bg-[#3E8B3A] hover:bg-[#2D662A] text-white font-extrabold text-xs py-3.5 px-8 rounded-full transition-all hover:shadow-lg">
                            Message Admin Support
                        </a>
                    @else
                        <a href="{{ route('public.contact') }}" class="inline-block bg-[#3E8B3A] hover:bg-[#2D662A] text-white font-extrabold text-xs py-3.5 px-8 rounded-full transition-all hover:shadow-lg">
                            Contact Support Team
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </section>

</x-public-layout>
