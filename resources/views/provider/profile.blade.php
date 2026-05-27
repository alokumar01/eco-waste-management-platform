@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#F4F7F6] font-sans overflow-hidden">
    @include('provider-dashboard-sidebar')

    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('provider-dashboard-header')

        <div class="flex-1 overflow-y-auto bg-[#F4F7F6] p-6 md:p-10 pb-20">

            <!-- Page Title -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">Provider Profile</h1>
                    <p class="text-sm text-gray-400 font-medium mt-1">Update your business details and public profile information.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-provider-green text-provider-green p-4 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl text-sm">
                    <p class="font-bold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('provider.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Left: Main Form (2/3) -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Business Info -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Business Information</h2>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Business Name <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-provider-green pointer-events-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <input type="text" name="business_name" id="business_name" required
                                        value="{{ old('business_name', $user->business_name) }}"
                                        placeholder="Your registered business name"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Business Address <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-provider-green pointer-events-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    </div>
                                    <input type="text" name="business_address" id="business_address" required
                                        value="{{ old('business_address', $user->business_address) }}"
                                        placeholder="Street address, locality"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700">
                                </div>
                            </div>

                            <!-- City / State / Pincode -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="city" id="city" required
                                        value="{{ old('city', $user->city) }}"
                                        placeholder="e.g. Bengaluru"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">State <span class="text-red-500">*</span></label>
                                    <input type="text" name="state" id="state" required
                                        value="{{ old('state', $user->state) }}"
                                        placeholder="e.g. Karnataka"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Pincode <span class="text-red-500">*</span></label>
                                    <input type="text" name="pincode" id="pincode" required maxlength="6"
                                        value="{{ old('pincode', $user->pincode) }}"
                                        placeholder="e.g. 560001"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700">
                                </div>
                            </div>
                        </div>

                        <!-- Verification & Media -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Verification & Media</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Profile Picture Upload -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Profile Picture</label>
                                    <div class="flex items-center gap-4">
                                        <div class="relative group w-16 h-16 shrink-0 rounded-full overflow-hidden border-2 border-provider-green/20 bg-gray-50">
                                            <img id="avatar-preview" src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=eef6ea&color=40852b' }}" alt="Profile Picture" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                                            <button type="button" onclick="document.getElementById('profile_picture').click()" class="bg-white border border-provider-green/30 hover:border-provider-green text-provider-green hover:bg-provider-green-light px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm active:scale-[0.98] cursor-pointer inline-flex items-center gap-2">
                                                Change Picture
                                            </button>
                                            <p class="text-[9px] text-gray-400 font-semibold mt-1.5">JPG, PNG up to 2MB</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Verification Document -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Verification Document <span class="text-red-500">*</span> <span class="text-gray-400 font-normal">(Proof of business/ID)</span></label>
                                    <div class="flex flex-col gap-2">
                                        @if($user->verification_document)
                                            <div class="flex items-center gap-2 bg-green-50/50 border border-green-100 rounded-xl p-2.5 text-xs text-provider-green">
                                                <svg class="w-4 h-4 text-provider-green shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                                <div class="truncate flex-1 font-medium">
                                                    Document uploaded
                                                </div>
                                                <a href="{{ asset('storage/' . $user->verification_document) }}" target="_blank" class="text-provider-green hover:text-provider-green-dark font-bold underline whitespace-nowrap">
                                                    View File
                                                </a>
                                            </div>
                                        @endif
                                        <div class="relative">
                                            <input type="file" name="verification_document" id="verification_document" accept=".pdf,image/*,.zip,.doc,.docx" class="hidden" onchange="updateDocLabel(this)">
                                            <button type="button" onclick="document.getElementById('verification_document').click()" class="bg-white border border-provider-green/30 hover:border-provider-green text-provider-green hover:bg-provider-green-light px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm active:scale-[0.98] cursor-pointer inline-flex items-center justify-center gap-2 w-full">
                                                <svg class="w-4 h-4 text-provider-green" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span id="doc-upload-label">Upload Proof of Business</span>
                                            </button>
                                        </div>
                                        <p class="text-[9px] text-gray-400 font-semibold mt-0.5">PDF, Word, Zip or Image up to 5MB. E.g. business license, tax registration, identity proof.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Bio -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Contact & About</h2>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-provider-green pointer-events-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <input type="text" name="phone_number" id="phone_number" required
                                        value="{{ old('phone_number', $user->phone_number) }}"
                                        placeholder="e.g. 9876543210"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Bio / Description <span class="text-gray-400 font-normal">(Optional)</span></label>
                                <textarea name="bio" id="bio" rows="4"
                                    placeholder="Tell customers about your business, experience, and what makes your service special..."
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 resize-none text-gray-700">{{ old('bio', $user->bio) }}</textarea>
                                <p class="text-[9px] text-gray-400 font-semibold mt-1">A good bio helps customers trust and choose your services.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Actions & Info (1/3) -->
                    <div class="space-y-5">

                        <!-- Save Card -->
                        <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-4">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Save Changes</h2>
                            <p class="text-[10.5px] text-gray-500 leading-relaxed">Keep your profile accurate so customers can find and trust your services.</p>
                            <button type="submit" class="w-full bg-provider-green hover:bg-provider-green-dark text-white font-bold text-sm py-2.5 px-4 rounded-xl transition-all shadow-sm active:scale-[0.98] select-none cursor-pointer">
                                Save Profile
                            </button>
                        </div>

                        <!-- Account Info -->
                        <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3 mb-4">Account Details</h2>
                            <div class="space-y-3.5">
                                <div>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wide mb-0.5">Full Name</p>
                                    <p class="text-xs font-bold text-gray-800">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wide mb-0.5">Email Address</p>
                                    <p class="text-xs font-bold text-gray-800">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wide mb-0.5">Verification Status</p>
                                    @if($user->is_verified)
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-provider-green bg-provider-green-light px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-provider-green"></span> Verified Provider
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Verification
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wide mb-0.5">Member Since</p>
                                    <p class="text-xs font-bold text-gray-800">{{ $user->created_at->format('M Y') }}</p>
                                </div>
                            </div>
                        </div>

            </form>

            <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 max-w-xl mt-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function updateDocLabel(input) {
    if (input.files && input.files[0]) {
        document.getElementById('doc-upload-label').textContent = input.files[0].name;
    }
}
</script>
@endsection
