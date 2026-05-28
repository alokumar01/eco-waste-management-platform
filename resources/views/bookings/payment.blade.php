@extends('layouts.app')
@section('no_container', true)

@section('content')
@php
    $booking = $booking ?? null;
    $serviceAmount = $booking ? $booking->price : $service->price;
    $platformFee = 150;
    $totalAmount = $serviceAmount + $platformFee;
@endphp

<!-- Payment Page Wrapper -->
<div class="min-h-screen bg-[#F8F9FA] font-sans pb-16 select-none">
    
    <!-- Main Container -->
    <div class="max-w-[1250px] mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        
        @if(!$booking)
        <!-- Step Progress Tracker -->
        <div class="flex items-center justify-center gap-3 md:gap-6 mb-8 text-xs font-bold text-gray-400 select-none">
            <a href="{{ route('services.show', $service) }}" class="flex items-center gap-2 text-green-700 hover:underline">
                <span class="w-5 h-5 rounded-full bg-green-150 text-green-700 flex items-center justify-center text-[10px]"><i class="fa-solid fa-check"></i></span>
                <span>1. Service</span>
            </a>
            <div class="w-12 h-0.5 bg-green-200"></div>
            <a href="{{ route('bookings.create', $service) }}" class="flex items-center gap-2 text-green-700 hover:underline">
                <span class="w-5 h-5 rounded-full bg-green-150 text-green-700 flex items-center justify-center text-[10px]"><i class="fa-solid fa-check"></i></span>
                <span>2. Details</span>
            </a>
            <div class="w-12 h-0.5 bg-green-200"></div>
            <div class="flex items-center gap-2 text-green-700">
                <span class="w-5 h-5 rounded-full bg-green-700 text-white flex items-center justify-center text-[10px]">3</span>
                <span class="text-gray-900 font-extrabold">3. Payment</span>
            </div>
        </div>
        @else
        <!-- Back to My Bookings link -->
        <a href="{{ route('bookings.my') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#3E8B3A] hover:underline mb-6 transition-all group select-none">
            <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to My Bookings</span>
        </a>
        @endif

        <!-- Two Column Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left Column: UPI Payment Form (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-150 shadow-[0_2px_15px_rgba(0,0,0,0.015)] space-y-8">
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-950 tracking-tight">Complete Your Payment</h2>
                        <p class="text-xs text-gray-400 font-semibold mt-1">Verify your UPI ID and complete your booking securely.</p>
                    </div>

                    <!-- Submission Form to store booking in DB -->
                    <form action="{{ $booking ? route('bookings.pay', $booking->id) : route('bookings.store') }}" method="POST" id="payment_execution_form" onsubmit="handleUPISubmit(event)" class="space-y-6">
                        @csrf
                        
                        @if($booking)
                            <!-- Existing booking, no hidden fields needed -->
                        @else
                            <!-- Hidden details forwarded from Step 2 -->
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <input type="hidden" name="scheduled_at" value="{{ $scheduled_at }}">
                            <input type="hidden" name="instructions" value="{{ $instructions }}">
                        @endif

                        <!-- UPI Detail Fields -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider">UPI Payment Method</h3>
                                <span class="bg-green-100 text-green-700 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Instant Auto-Verify</span>
                            </div>
                            
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">Enter Virtual Payment Address (VPA) *</label>
                                <div class="flex gap-2.5">
                                    <div class="relative flex-1">
                                        <input type="text" id="upi_vpa" name="upi_vpa" placeholder="e.g. success@upi or user@okaxis" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 bg-gray-50/20" required>
                                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                            <i class="fa-solid fa-mobile-screen-button"></i>
                                        </div>
                                    </div>
                                    <button type="button" id="verify-vpa-btn" onclick="verifyUPI()" class="px-5 py-2.5 border border-gray-200 hover:bg-gray-50 rounded-xl text-xs font-extrabold text-gray-600 transition-colors shadow-sm cursor-pointer select-none">
                                        Verify
                                    </button>
                                </div>
                                <p class="text-[9.5px] text-gray-400 font-semibold leading-tight">Enter your UPI ID (VPA) and click Verify before checking out.</p>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Secure Pay Button -->
                        <button type="submit" id="pay-submit-btn" class="w-full bg-[#1A4D2E] hover:bg-green-900 text-white font-bold text-sm px-4 py-3.5 rounded-xl flex items-center justify-center gap-2 transition-all shadow-md active:scale-[0.99] transform select-none cursor-pointer">
                            <i class="fa-solid fa-lock"></i>
                            <span id="btn-text">Pay ₹{{ number_format($totalAmount, 2) }}</span>
                        </button>

                        <p class="text-[10px] text-gray-400 font-semibold text-center leading-normal">
                            By proceeding, you agree to GreenLoop's <a href="#" class="text-green-700 hover:underline">Terms & Conditions</a> and <a href="#" class="text-green-700 hover:underline">Privacy Policy</a>.
                        </p>
                    </form>
                </div>
            </div>

            <!-- Right Column: Booking Summary Card (1/3 width) -->
            <div class="lg:col-span-1 lg:sticky lg:top-8 space-y-4">
                
                <!-- Main summary card -->
                <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-[0_2px_15_rgba(0,0,0,0.02)] space-y-6">
                    <h3 class="text-sm font-bold text-gray-950 uppercase tracking-wider">Booking Summary</h3>
                    
                    <!-- Service card block -->
                    <div class="bg-[#F8F9FA]/60 border border-gray-100 p-4.5 rounded-xl flex gap-3.5 items-center select-none">
                        <div class="w-14 h-11.5 rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shrink-0">
                            @if ($service->image_path)
                                <img src="{{ asset('storage/' . $service->image_path) }}" class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#E2E4DE] to-[#C2C9BD] flex items-center justify-center">
                                    <i class="fa-regular fa-image text-gray-400 text-xs"></i>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-extrabold text-xs text-gray-900 truncate leading-snug">{{ $service->name }}</h4>
                            <p class="text-[9.5px] text-gray-400 font-bold mt-0.5 truncate flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-green-700 text-[10px]"></i>
                                <span>{{ $service->user->business_name ?? $service->user->name }}</span>
                            </p>
                            <p class="text-[9.5px] text-gray-400 font-semibold mt-0.5 truncate"><i class="fa-solid fa-location-dot mr-0.5 text-gray-400"></i>{{ $service->user->city }}, {{ $service->user->state }}</p>
                        </div>
                    </div>

                    <!-- Pricing table -->
                    <div class="space-y-3.5 border-t border-b border-gray-100 py-4 text-xs font-semibold text-gray-500">
                        <div class="flex items-center justify-between select-none">
                            <span>Service Amount</span>
                            <span class="text-gray-900 font-bold">₹{{ number_format($serviceAmount, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between select-none">
                            <span>Platform Fee</span>
                            <span class="text-gray-900 font-bold">₹{{ number_format($platformFee, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between select-none">
                            <span>Discount</span>
                            <span class="text-green-700 font-bold">- ₹0.00</span>
                        </div>
                    </div>

                    <!-- Total amount display -->
                    <div class="flex items-center justify-between select-none">
                        <span class="text-xs font-extrabold text-gray-900 uppercase">Total Amount</span>
                        <span class="text-2xl font-black text-green-700">₹{{ number_format($totalAmount, 2) }}</span>
                    </div>

                    <!-- Safe payments banner -->
                    <div class="bg-green-50/50 border border-green-100/50 p-4 rounded-xl flex items-start gap-3 select-none">
                        <div class="text-green-700 mt-0.5"><i class="fa-solid fa-circle-check text-base"></i></div>
                        <div>
                            <p class="text-xs font-extrabold text-green-800 leading-tight">Safe & Secure Payments</p>
                            <p class="text-[9.5px] text-green-700 font-semibold leading-normal mt-0.5">Your payment information is encrypted and never stored on our servers.</p>
                        </div>
                    </div>

                    <!-- Booking user block -->
                    <div class="bg-gray-50/50 border border-gray-100 p-4 rounded-xl flex items-center justify-between select-none">
                        <div class="flex items-center gap-3">
                            <div class="w-8.5 h-8.5 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs"><i class="fa-solid fa-user"></i></div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mt-0.5 tracking-wider">Booking For</p>
                                <p class="font-extrabold text-xs text-gray-900 mt-0.5 leading-none">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        @if(!$booking)
                        <a href="{{ route('bookings.create', $service) }}" class="text-xs font-bold text-green-700 hover:underline">Change</a>
                        @endif
                    </div>
                </div>

            </div>

        </div>

        <!-- Trust Badges Footer Row -->
        <div class="bg-white border border-gray-150 rounded-2xl p-6 mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 select-none shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center border border-green-150"><i class="fa-solid fa-shield-halved text-base"></i></div>
                <div>
                    <h5 class="text-xs font-extrabold text-gray-900 leading-tight">100% Secure</h5>
                    <p class="text-[10px] text-gray-400 font-semibold mt-0.5">Encrypted transactions</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center border border-green-150"><i class="fa-solid fa-award text-base"></i></div>
                <div>
                    <h5 class="text-xs font-extrabold text-gray-900 leading-tight">Trusted Platform</h5>
                    <p class="text-[10px] text-gray-400 font-semibold mt-0.5">Thousands of happy customers</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center border border-green-150"><i class="fa-solid fa-arrows-rotate text-base"></i></div>
                <div>
                    <h5 class="text-xs font-extrabold text-gray-900 leading-tight">Easy Cancellation</h5>
                    <p class="text-[10px] text-gray-400 font-semibold mt-0.5">Cancel anytime before service</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center border border-green-150"><i class="fa-solid fa-headset text-base"></i></div>
                <div>
                    <h5 class="text-xs font-extrabold text-gray-900 leading-tight">24/7 Support</h5>
                    <p class="text-[10px] text-gray-400 font-semibold mt-0.5">We're here to help</p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal simulation structure -->
<div id="simulated-payment-modal" class="fixed inset-0 z-[150] flex items-center justify-center bg-gray-950/40 backdrop-blur-[4px] opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full mx-4 border border-gray-100 text-center space-y-5 transform scale-95 transition-all duration-300" id="simulated-modal-box">
        <div id="simulation-spinner" class="flex justify-center py-2">
            <svg class="animate-spin h-10 w-10 text-green-700" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <div id="simulation-success-icon" class="hidden flex justify-center py-2">
            <div class="w-12 h-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center border border-green-200">
                <i class="fa-solid fa-circle-check text-2xl animate-bounce"></i>
            </div>
        </div>
        <div class="space-y-2">
            <h4 class="text-base font-extrabold text-gray-900" id="simulation-title">Simulating Payment Request</h4>
            <p class="text-xs text-gray-500 font-semibold leading-relaxed" id="simulation-desc">Please open your UPI app to approve the payment request of ₹{{ number_format($totalAmount, 2) }}.</p>
        </div>
        <div class="text-[10px] text-gray-400 font-extrabold tracking-wider uppercase bg-gray-50 py-2 rounded-xl" id="simulation-countdown">
            Simulating Completion in <span id="countdown-num">2</span>s
        </div>
    </div>
</div>

<script>
    let isUPIVerified = false;

    function verifyUPI() {
        const vpa = document.getElementById('upi_vpa').value;
        if (!vpa || !vpa.includes('@')) {
            showToast('Please enter a valid UPI ID (e.g. success@upi or user@okaxis)');
            return;
        }
        
        const verifyBtn = document.getElementById('verify-vpa-btn');
        verifyBtn.textContent = 'Verifying...';
        verifyBtn.disabled = true;

        setTimeout(() => {
            isUPIVerified = true;
            verifyBtn.className = "px-5 py-2.5 bg-green-50 border border-green-200 rounded-xl text-xs font-extrabold text-green-700 transition-colors shadow-sm";
            verifyBtn.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Verified';
            verifyBtn.disabled = false;
            showToast('UPI VPA Verified successfully.');
        }, 800);
    }

    function handleUPISubmit(e) {
        e.preventDefault();
        
        const vpa = document.getElementById('upi_vpa').value;
        if (!vpa || !vpa.includes('@')) {
            showToast('Please enter and verify a valid UPI ID before checking out.');
            return;
        }

        // Show Overlay Modal
        const modal = document.getElementById('simulated-payment-modal');
        const box = document.getElementById('simulated-modal-box');
        
        modal.classList.remove('opacity-0', 'pointer-events-none');
        box.classList.remove('scale-95');
        box.classList.add('scale-100');

        let seconds = 2;
        const countdownNum = document.getElementById('countdown-num');
        
        const interval = setInterval(() => {
            seconds--;
            countdownNum.textContent = seconds;
            if (seconds === 0) {
                clearInterval(interval);
                
                // Show success UI
                document.getElementById('simulation-spinner').classList.add('hidden');
                document.getElementById('simulation-success-icon').classList.remove('hidden');
                document.getElementById('simulation-title').textContent = "Payment Approved!";
                document.getElementById('simulation-desc').textContent = "Transaction completed. Preparing your booking...";
                document.getElementById('simulation-countdown').className = "text-[10px] text-green-700 font-extrabold tracking-wider uppercase bg-green-50 py-2 rounded-xl";
                document.getElementById('simulation-countdown').textContent = "REDIRECTING...";

                setTimeout(() => {
                    document.getElementById('payment_execution_form').submit();
                }, 1000);
            }
        }, 1000);
    }
</script>
@endsection
