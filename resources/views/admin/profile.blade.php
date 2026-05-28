@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#FAFCFB] font-sans overflow-hidden">
    @include('admin-dashboard-sidebar')

    <!-- Main Content Panel -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('admin-dashboard-header')

        <!-- Scrollable content -->
        <main class="flex-1 overflow-y-auto p-8 bg-[#FAFCFB] space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">Admin Profile Settings</h1>
                    <p class="text-sm text-gray-400 font-medium mt-1">Manage your administrative name, email address, and security password.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm text-xs font-semibold">
                    <p class="font-bold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Overview Profile Card -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.015)] text-center flex flex-col items-center justify-center">
                        <div class="relative group w-24 h-24 rounded-full overflow-hidden border-4 border-green-50 shadow-sm mb-4 bg-[#E8F5E9]">
                            @if($user->profile_picture)
                                <img id="avatar-preview" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                            @else
                                <div id="avatar-monogram" class="w-full h-full text-[#2E6F40] font-black text-3xl flex items-center justify-center select-none">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <img id="avatar-preview" src="" alt="Profile Picture" class="w-full h-full object-cover hidden">
                            @endif
                        </div>

                        <!-- Change photo triggers -->
                        <div class="mb-2">
                            <input type="file" name="profile_picture" id="profile_picture_input" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                            <button type="button" onclick="document.getElementById('profile_picture_input').click()" class="bg-white border border-gray-200 hover:border-green-600 text-gray-700 hover:text-green-700 px-3 py-1.5 rounded-xl text-[10px] font-bold transition-all shadow-sm active:scale-[0.98] cursor-pointer inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-camera"></i> Change Photo
                            </button>
                        </div>
                        <p class="text-[9px] text-gray-450 font-medium">JPG, PNG, GIF up to 2MB</p>
                        
                        <h3 class="text-lg font-extrabold text-gray-900 leading-snug mt-4">{{ $user->name }}</h3>
                        <p class="text-xs text-gray-400 font-medium mt-1">{{ $user->email }}</p>
                        
                        <div class="inline-flex items-center gap-1.5 bg-[#E8F5E9] text-[#2E6F40] text-[10px] font-extrabold px-3 py-1 rounded-full mt-4 select-none">
                            <i class="fa-solid fa-shield-halved text-[9px]"></i> Administrator
                        </div>

                        <div class="h-px bg-gray-50 w-full my-6"></div>

                        <div class="text-[11px] text-gray-400 font-bold w-full text-left space-y-2">
                            <div class="flex justify-between">
                                <span>ACCOUNT SINCE</span>
                                <span class="text-gray-650">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>LAST UPDATED</span>
                                <span class="text-gray-650">{{ $user->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Settings Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.015)] overflow-hidden">

                            <!-- Block 1: Details -->
                            <div class="p-6 space-y-5">
                                <h3 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Personal Details</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Name -->
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" required placeholder="Enter full name"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 text-gray-700 font-medium"
                                            value="{{ old('name', $user->name) }}">
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Email Address <span class="text-red-500">*</span></label>
                                        <input type="email" name="email" required placeholder="name@domain.com"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 text-gray-700 font-medium"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Block 2: Security Password -->
                            <div class="p-6 pt-0 space-y-5">
                                <h3 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Update Password <span class="text-[10px] text-gray-400 font-medium lowercase">(leave blank to keep current)</span></h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- New Password -->
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">New Password</label>
                                        <input type="password" name="password" placeholder="••••••••" minlength="8"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 text-gray-700 font-medium">
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" placeholder="••••••••" minlength="8"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 text-gray-700 font-medium">
                                    </div>
                                </div>
                            </div>

                            <!-- Actions bar -->
                            <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-50 flex items-center justify-end">
                                <button type="submit" class="px-5 py-2.5 bg-[#1A4D2E] hover:bg-green-900 text-white text-xs font-bold rounded-xl transition-all cursor-pointer shadow-sm">
                                    Save Profile Changes
                                </button>
                            </div>
                        </div>
            </form>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.015)] max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </main>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('avatar-preview');
            var monogram = document.getElementById('avatar-monogram');
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            if (monogram) {
                monogram.classList.add('hidden');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
