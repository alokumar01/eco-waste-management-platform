@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#F4F7F6] font-sans overflow-hidden">
    @include('provider-dashboard-sidebar')

    @php
        $provider = Auth::user();
    @endphp

    <!-- Main Content Area Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('provider-dashboard-header')

        <div class="flex-1 overflow-y-auto bg-[#F4F7F6] p-6 md:p-10 pb-20">
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl shadow-sm" role="alert">
                     <p class="font-bold text-sm">Please correct the following errors:</p>
                     <ul class="list-disc pl-5 mt-1 text-xs font-semibold">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                     </ul>
                </div>
            @endif

            <!-- Back navigation link -->
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1.5 text-[11px] font-bold text-provider-green hover:underline mb-4 transition-all group">
                <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Back to Services</span>
            </a>

            <!-- Heading Title block -->
            <div class="mb-8">
                <h1 class="text-[22px] font-bold text-gray-950 leading-none tracking-tight">Edit Service</h1>
                <p class="text-[11.5px] text-gray-500 font-medium mt-1.5">Modify the details of your active service listing below.</p>
            </div>

            <!-- Main Form element Grid -->
            <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data" id="add_service_form">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    
                    <!-- Left Side Columns (Main Form details) -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Block 1: Basic Information -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Basic Information</h2>
                            
                            <!-- Service Title -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Service Title <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" name="name" id="service_title" maxlength="100" placeholder="Enter service title" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20" value="{{ old('name', $service->name) }}" required>
                                    <span id="title_counter" class="absolute right-4 top-1/2 -translate-y-1/2 text-[9.5px] font-bold text-gray-400">0/100</span>
                                </div>
                            </div>

                            <!-- Category & Type Container -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Category -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Category <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-provider-green pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>
                                        </div>
                                        <select id="service_category" name="category" class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 appearance-none text-gray-700">
                                            <option value="" disabled {{ !old('category', $service->category) ? 'selected' : '' }}>Select a category</option>
                                            <option value="Composting" {{ old('category', $service->category) == 'Composting' ? 'selected' : '' }}>Composting</option>
                                            <option value="Recycling" {{ old('category', $service->category) == 'Recycling' ? 'selected' : '' }}>Recycling</option>
                                            <option value="E-Waste" {{ old('category', $service->category) == 'E-Waste' ? 'selected' : '' }}>E-Waste</option>
                                            <option value="Organic Waste" {{ old('category', $service->category) == 'Organic Waste' ? 'selected' : '' }}>Organic Waste</option>
                                            <option value="Garden Waste" {{ old('category', $service->category) == 'Garden Waste' ? 'selected' : '' }}>Garden Waste</option>
                                            <option value="Commercial Waste" {{ old('category', $service->category) == 'Commercial Waste' ? 'selected' : '' }}>Commercial Waste</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Service Type -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Service Type</label>
                                    <div class="relative">
                                        <select name="type" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 appearance-none text-gray-700">
                                            <option value="pickup" {{ old('type', $service->type) == 'pickup' || !old('type', $service->type) ? 'selected' : '' }}>Pickup Service (You collect waste)</option>
                                            <option value="onsite" {{ old('type', $service->type) == 'onsite' ? 'selected' : '' }}>On-site Service (You visit customer)</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Short Description -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Short Description <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <textarea id="short_desc" name="description" maxlength="200" rows="2" placeholder="Briefly describe your service" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 resize-none text-gray-700" required>{{ old('description', $service->description) }}</textarea>
                                    <span id="short_desc_counter" class="absolute right-4 bottom-3 text-[9.5px] font-bold text-gray-400">0/200</span>
                                </div>
                            </div>

                            <!-- Detailed Description -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Detailed Description <span class="text-red-500">*</span></label>
                                <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">
                                    <!-- Quill Editor Container -->
                                    <div id="detailed_desc_editor" style="height: 200px;" class="text-xs text-gray-700 bg-white"></div>
                                    <input type="hidden" name="detailed_description" id="detailed_description_hidden" value="{{ old('detailed_description', $service->detailed_description) }}">
                                    <div class="flex justify-end bg-gray-50/40 border-t border-gray-100 px-4 py-1.5 text-[9.5px] text-gray-400 font-semibold select-none">
                                        <span id="word_counter">0 words</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Block 2: Service Details -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Service Details</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Price -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Price <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs pointer-events-none">₹</div>
                                        <input type="number" name="price" id="service_price" placeholder="Enter price" step="0.01" class="w-full pl-8 pr-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20" value="{{ old('price', $service->price) }}" required>
                                    </div>
                                </div>

                                <!-- Unit -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Unit</label>
                                    <div class="relative">
                                        <select name="unit" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 appearance-none text-gray-700">
                                            <option value="kg" {{ old('unit', $service->unit) == 'kg' ? 'selected' : '' }}>Per kg</option>
                                            <option value="visit" {{ old('unit', $service->unit) == 'visit' ? 'selected' : '' }}>Per visit</option>
                                            <option value="month" {{ old('unit', $service->unit) == 'month' ? 'selected' : '' }}>Per month</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Duration (Optional)</label>
                                    <input type="text" name="duration" placeholder="e.g., 2 hours, 1 day" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700" value="{{ old('duration', $service->duration) }}">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- What We Accept -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">What We Accept <span class="text-red-500">*</span></label>
                                    <input type="text" name="what_we_accept" placeholder="e.g., Kitchen waste, Food waste, Vegetable peels" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700" value="{{ old('what_we_accept', $service->what_we_accept) }}" required>
                                    <p class="text-[9px] text-gray-400 font-semibold mt-1">List the types of waste/materials you accept</p>
                                </div>
                                
                                <!-- What We Don't Accept -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">What We Don't Accept (Optional)</label>
                                    <input type="text" name="what_we_dont_accept" placeholder="e.g., Plastic, Glass, Metal" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700" value="{{ old('what_we_dont_accept', $service->what_we_dont_accept) }}">
                                    <p class="text-[9px] text-gray-400 font-semibold mt-1">List the types of waste/materials you don't accept</p>
                                </div>
                            </div>
                        </div>

                        <!-- Block 3: Service Area -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Service Area</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- City / Area -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">City / Area <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-provider-green pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <select name="city" class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 appearance-none text-gray-700">
                                            <option value="" disabled>Select your service area</option>
                                            <option value="Ahmedabad" {{ old('city', $service->city) == 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                                            <option value="Amritsar" {{ old('city', $service->city) == 'Amritsar' ? 'selected' : '' }}>Amritsar</option>
                                            <option value="Aurangabad" {{ old('city', $service->city) == 'Aurangabad' ? 'selected' : '' }}>Aurangabad</option>
                                            <option value="Bengaluru" {{ old('city', $service->city) == 'Bengaluru' || !old('city', $service->city) ? 'selected' : '' }}>Bengaluru</option>
                                            <option value="Bhopal" {{ old('city', $service->city) == 'Bhopal' ? 'selected' : '' }}>Bhopal</option>
                                            <option value="Bhubaneswar" {{ old('city', $service->city) == 'Bhubaneswar' ? 'selected' : '' }}>Bhubaneswar</option>
                                            <option value="Chandigarh" {{ old('city', $service->city) == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                            <option value="Chennai" {{ old('city', $service->city) == 'Chennai' ? 'selected' : '' }}>Chennai</option>
                                            <option value="Coimbatore" {{ old('city', $service->city) == 'Coimbatore' ? 'selected' : '' }}>Coimbatore</option>
                                            <option value="Dehradun" {{ old('city', $service->city) == 'Dehradun' ? 'selected' : '' }}>Dehradun</option>
                                            <option value="Delhi NCR" {{ old('city', $service->city) == 'Delhi NCR' || old('city', $service->city) == 'Delhi' ? 'selected' : '' }}>Delhi NCR</option>
                                            <option value="Dhanbad" {{ old('city', $service->city) == 'Dhanbad' ? 'selected' : '' }}>Dhanbad</option>
                                            <option value="Faridabad" {{ old('city', $service->city) == 'Faridabad' ? 'selected' : '' }}>Faridabad</option>
                                            <option value="Ghaziabad" {{ old('city', $service->city) == 'Ghaziabad' ? 'selected' : '' }}>Ghaziabad</option>
                                            <option value="Gurugram" {{ old('city', $service->city) == 'Gurugram' ? 'selected' : '' }}>Gurugram (Gurgaon)</option>
                                            <option value="Guwahati" {{ old('city', $service->city) == 'Guwahati' ? 'selected' : '' }}>Guwahati</option>
                                            <option value="Gwalior" {{ old('city', $service->city) == 'Gwalior' ? 'selected' : '' }}>Gwalior</option>
                                            <option value="Howrah" {{ old('city', $service->city) == 'Howrah' ? 'selected' : '' }}>Howrah</option>
                                            <option value="Hyderabad" {{ old('city', $service->city) == 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                                            <option value="Indore" {{ old('city', $service->city) == 'Indore' ? 'selected' : '' }}>Indore</option>
                                            <option value="Jabalpur" {{ old('city', $service->city) == 'Jabalpur' ? 'selected' : '' }}>Jabalpur</option>
                                            <option value="Jaipur" {{ old('city', $service->city) == 'Jaipur' ? 'selected' : '' }}>Jaipur</option>
                                            <option value="Jamshedpur" {{ old('city', $service->city) == 'Jamshedpur' ? 'selected' : '' }}>Jamshedpur</option>
                                            <option value="Jodhpur" {{ old('city', $service->city) == 'Jodhpur' ? 'selected' : '' }}>Jodhpur</option>
                                            <option value="Kalyan-Dombivli" {{ old('city', $service->city) == 'Kalyan-Dombivli' ? 'selected' : '' }}>Kalyan-Dombivli</option>
                                            <option value="Kanpur" {{ old('city', $service->city) == 'Kanpur' ? 'selected' : '' }}>Kanpur</option>
                                            <option value="Kochi" {{ old('city', $service->city) == 'Kochi' ? 'selected' : '' }}>Kochi</option>
                                            <option value="Kolkata" {{ old('city', $service->city) == 'Kolkata' ? 'selected' : '' }}>Kolkata</option>
                                            <option value="Kota" {{ old('city', $service->city) == 'Kota' ? 'selected' : '' }}>Kota</option>
                                            <option value="Lucknow" {{ old('city', $service->city) == 'Lucknow' ? 'selected' : '' }}>Lucknow</option>
                                            <option value="Ludhiana" {{ old('city', $service->city) == 'Ludhiana' ? 'selected' : '' }}>Ludhiana</option>
                                            <option value="Madurai" {{ old('city', $service->city) == 'Madurai' ? 'selected' : '' }}>Madurai</option>
                                            <option value="Mangaluru" {{ old('city', $service->city) == 'Mangaluru' ? 'selected' : '' }}>Mangaluru (Mangalore)</option>
                                            <option value="Meerut" {{ old('city', $service->city) == 'Meerut' ? 'selected' : '' }}>Meerut</option>
                                            <option value="Mumbai" {{ old('city', $service->city) == 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                                            <option value="Mysore" {{ old('city', $service->city) == 'Mysore' ? 'selected' : '' }}>Mysore</option>
                                            <option value="Nagpur" {{ old('city', $service->city) == 'Nagpur' ? 'selected' : '' }}>Nagpur</option>
                                            <option value="Nashik" {{ old('city', $service->city) == 'Nashik' ? 'selected' : '' }}>Nashik</option>
                                            <option value="Navi Mumbai" {{ old('city', $service->city) == 'Navi Mumbai' ? 'selected' : '' }}>Navi Mumbai</option>
                                            <option value="Noida" {{ old('city', $service->city) == 'Noida' ? 'selected' : '' }}>Noida</option>
                                            <option value="Patna" {{ old('city', $service->city) == 'Patna' ? 'selected' : '' }}>Patna</option>
                                            <option value="Pimpri-Chinchwad" {{ old('city', $service->city) == 'Pimpri-Chinchwad' ? 'selected' : '' }}>Pimpri-Chinchwad</option>
                                            <option value="Prayagraj" {{ old('city', $service->city) == 'Prayagraj' ? 'selected' : '' }}>Prayagraj (Allahabad)</option>
                                            <option value="Pune" {{ old('city', $service->city) == 'Pune' ? 'selected' : '' }}>Pune</option>
                                            <option value="Raipur" {{ old('city', $service->city) == 'Raipur' ? 'selected' : '' }}>Raipur</option>
                                            <option value="Rajkot" {{ old('city', $service->city) == 'Rajkot' ? 'selected' : '' }}>Rajkot</option>
                                            <option value="Ranchi" {{ old('city', $service->city) == 'Ranchi' ? 'selected' : '' }}>Ranchi</option>
                                            <option value="Srinagar" {{ old('city', $service->city) == 'Srinagar' ? 'selected' : '' }}>Srinagar</option>
                                            <option value="Surat" {{ old('city', $service->city) == 'Surat' ? 'selected' : '' }}>Surat</option>
                                            <option value="Thane" {{ old('city', $service->city) == 'Thane' ? 'selected' : '' }}>Thane</option>
                                            <option value="Thiruvananthapuram" {{ old('city', $service->city) == 'Thiruvananthapuram' ? 'selected' : '' }}>Thiruvananthapuram</option>
                                            <option value="Vadodara" {{ old('city', $service->city) == 'Vadodara' ? 'selected' : '' }}>Vadodara</option>
                                            <option value="Varanasi" {{ old('city', $service->city) == 'Varanasi' ? 'selected' : '' }}>Varanasi</option>
                                            <option value="Vijayawada" {{ old('city', $service->city) == 'Vijayawada' ? 'selected' : '' }}>Vijayawada</option>
                                            <option value="Visakhapatnam" {{ old('city', $service->city) == 'Visakhapatnam' ? 'selected' : '' }}>Visakhapatnam</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Areas -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Additional Areas (Optional)</label>
                                    <input type="text" name="additional_areas" placeholder="Select additional areas" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 text-gray-700" value="{{ old('additional_areas', $service->additional_areas) }}">
                                    <p class="text-[9px] text-gray-400 font-semibold mt-1">You can select multiple areas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status block for Edit -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Listing Status</h2>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Listing Status <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all bg-gray-50/20 appearance-none text-gray-700">
                                        <option value="active" {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>Active (Visible on marketplace)</option>
                                        <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>Inactive (Hidden / Out of service)</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Side Column Widgets -->
                    <div class="lg:col-span-1 space-y-6">
                        
                        <!-- Widget 1: Service Images -->
                        <div class="bg-white p-3.5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100">
                            <h3 class="text-[12.5px] font-bold text-gray-800 tracking-wide mb-0.5">Service Images</h3>
                            <p class="text-[9.5px] text-gray-400 font-medium mb-3">Upload a new image to replace the current one</p>
                            
                            <!-- Hidden inputs container (outside drag_drop_area to prevent bubbling) -->
                            <div class="hidden">
                                 <input type="file" id="image_upload_input_1" name="images[0]" class="hidden" accept="image/*" onchange="previewSlot(1, this)">
                                 <input type="file" id="image_upload_input_2" name="images[1]" class="hidden" accept="image/*" onchange="previewSlot(2, this)">
                                 <input type="file" id="image_upload_input_3" name="images[2]" class="hidden" accept="image/*" onchange="previewSlot(3, this)">
                                 <input type="file" id="image_upload_input_4" name="images[3]" class="hidden" accept="image/*" onchange="previewSlot(4, this)">
                                 <input type="file" id="image_upload_input_5" name="images[4]" class="hidden" accept="image/*" onchange="previewSlot(5, this)">
                            </div>

                            <!-- Dotted upload box -->
                            <div id="drag_drop_area" class="border-2 border-dashed border-gray-200 hover:border-provider-green rounded-xl p-3.5 text-center cursor-pointer bg-gray-50/30 hover:bg-provider-green-light transition-all duration-200 relative group">
                                <svg class="w-6 h-6 mx-auto text-gray-400 group-hover:text-provider-green transition-colors mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                </svg>
                                <p class="text-[10px] font-bold text-gray-800">Drag & drop new image here</p>
                                <p class="text-[9px] font-bold text-provider-green hover:underline mt-0.5">or click to browse</p>
                                <p class="text-[7.5px] text-gray-400 font-medium mt-1.5 leading-relaxed">Recommended: 1200 x 800px Max size: 2MB</p>
                            </div>

                            <!-- Thumbnails grid -->
                            <div class="grid grid-cols-5 gap-2 mt-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    @php $imgPath = $service->images[$i-1] ?? null; @endphp
                                    @if ($imgPath)
                                        <input type="hidden" name="existing_images[{{ $i-1 }}]" id="existing_image_{{ $i }}" value="{{ $imgPath }}">
                                    @endif
                                    <div class="aspect-square border border-gray-100 rounded-lg bg-gray-50/50 flex items-center justify-center cursor-pointer hover:border-provider-green transition-all group overflow-hidden relative" 
                                         onclick="triggerBrowse({{ $i }})"
                                         draggable="true"
                                         ondragstart="handleDragStart(event, {{ $i }})"
                                         ondragover="handleDragOver(event)"
                                         ondragleave="handleDragLeave(event)"
                                         ondrop="handleDrop(event, {{ $i }})">
                                        @if ($imgPath)
                                            <svg class="w-3.5 h-3.5 text-provider-green group-hover:scale-110 transition-transform hidden" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                                            <img id="thumb_{{ $i }}" src="{{ asset('storage/' . $imgPath) }}" class="absolute inset-0 w-full h-full object-cover" />
                                        @else
                                            <svg class="w-3.5 h-3.5 text-provider-green group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                                            <img id="thumb_{{ $i }}" class="absolute inset-0 w-full h-full object-cover hidden" />
                                        @endif

                                        <!-- Cross button to clear/remove the slot -->
                                        <button type="button" 
                                                id="remove_btn_{{ $i }}" 
                                                onclick="clearSlot(event, {{ $i }})" 
                                                class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-0.5 shadow-md transition-all duration-200 opacity-0 group-hover:opacity-100 focus:outline-none z-10 {{ $imgPath ? '' : 'hidden' }}">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endfor
                            </div>
                            <p class="text-[8.5px] text-gray-400 font-semibold mt-2">You can upload up to 5 images</p>
                        </div>

                        <!-- Widget 2: Service Preview -->
                        <div class="bg-white p-3.5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100">
                            <h3 class="text-[12.5px] font-bold text-gray-800 tracking-wide mb-2">Service Preview</h3>
                            
                            <div class="border border-gray-100 rounded-2xl p-3.5 text-center bg-white flex flex-col items-center justify-center min-h-[170px]">
                                <!-- Storefront illustration -->
                                <div id="preview_illustration_wrapper" class="w-18 h-18 flex items-center justify-center mb-2.5 transition-all overflow-hidden rounded-xl">
                                    @if ($service->image_path)
                                        <svg id="store_svg" class="w-full h-full hidden" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="60" cy="60" r="45" fill="#eef6ea" />
                                            <rect x="35" y="55" width="50" height="35" rx="3" fill="#ffffff" stroke="#40852b" stroke-width="2.5" />
                                            <path d="M32 55 L38 42 L48 42 L42 55 Z" fill="#40852b" stroke="#0e3c16" stroke-width="2" />
                                            <path d="M42 55 L48 42 L58 42 L52 55 Z" fill="#eef6ea" stroke="#40852b" stroke-width="2" />
                                            <path d="M52 55 L58 42 L68 42 L62 55 Z" fill="#40852b" stroke="#0e3c16" stroke-width="2" />
                                            <path d="M62 55 L68 42 L78 42 L72 55 Z" fill="#eef6ea" stroke="#40852b" stroke-width="2" />
                                            <path d="M72 55 L78 42 L88 42 L82 55 Z" fill="#40852b" stroke="#0e3c16" stroke-width="2" />
                                            <rect x="42" y="70" width="14" height="20" rx="1.5" fill="#eef6ea" stroke="#40852b" stroke-width="2" />
                                            <rect x="64" y="65" width="14" height="12" rx="1" fill="#40852b" opacity="0.15" stroke="#0e3c16" stroke-width="2" />
                                            <rect x="30" y="82" width="4" height="6" fill="#D97706" />
                                            <path d="M28 82 C28 80 30 78 32 78 C34 78 36 80 36 82 Z" fill="#40852b" />
                                            <rect x="86" y="82" width="4" height="6" fill="#D97706" />
                                            <path d="M84 82 C84 80 86 78 88 78 C90 78 92 80 92 82 Z" fill="#40852b" />
                                        </svg>
                                        <img id="preview_uploaded_img" src="{{ asset('storage/' . $service->image_path) }}" class="w-full h-full object-cover" />
                                    @else
                                        <svg id="store_svg" class="w-full h-full" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="60" cy="60" r="45" fill="#eef6ea" />
                                            <rect x="35" y="55" width="50" height="35" rx="3" fill="#ffffff" stroke="#40852b" stroke-width="2.5" />
                                            <path d="M32 55 L38 42 L48 42 L42 55 Z" fill="#40852b" stroke="#0e3c16" stroke-width="2" />
                                            <path d="M42 55 L48 42 L58 42 L52 55 Z" fill="#eef6ea" stroke="#40852b" stroke-width="2" />
                                            <path d="M52 55 L58 42 L68 42 L62 55 Z" fill="#40852b" stroke="#0e3c16" stroke-width="2" />
                                            <path d="M62 55 L68 42 L78 42 L72 55 Z" fill="#eef6ea" stroke="#40852b" stroke-width="2" />
                                            <path d="M72 55 L78 42 L88 42 L82 55 Z" fill="#40852b" stroke="#0e3c16" stroke-width="2" />
                                            <rect x="42" y="70" width="14" height="20" rx="1.5" fill="#eef6ea" stroke="#40852b" stroke-width="2" />
                                            <rect x="64" y="65" width="14" height="12" rx="1" fill="#40852b" opacity="0.15" stroke="#0e3c16" stroke-width="2" />
                                            <rect x="30" y="82" width="4" height="6" fill="#D97706" />
                                            <path d="M28 82 C28 80 30 78 32 78 C34 78 36 80 36 82 Z" fill="#40852b" />
                                            <rect x="86" y="82" width="4" height="6" fill="#D97706" />
                                            <path d="M84 82 C84 80 86 78 88 78 C90 78 92 80 92 82 Z" fill="#40852b" />
                                        </svg>
                                        <img id="preview_uploaded_img" class="w-full h-full object-cover hidden" />
                                    @endif
                                </div>

                                <h3 id="preview_title" class="text-[11px] font-bold text-gray-800 transition-all text-center max-w-full px-2 truncate">{{ $service->name }}</h3>
                                <p id="preview_desc" class="text-[8.5px] text-gray-400 font-semibold mt-0.5 px-2 text-center leading-relaxed">{{ Str::limit($service->description, 70) }}</p>
                                
                                <div id="preview_price_tag" class="mt-2 bg-provider-green-light text-provider-green text-[10px] font-bold px-3 py-1 rounded-full transition-all">
                                    ₹{{ number_format($service->price, 2) }}
                                </div>
                                
                                <button type="button" onclick="openMockPreview()" class="w-full mt-3.5 bg-provider-green-light hover:bg-provider-green/10 text-provider-green font-bold py-2.5 rounded-xl text-xs transition-colors flex items-center justify-center gap-1.5 border border-provider-green/20 select-none cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>Open Live Mock Preview</span>
                                </button>
                            </div>
                        </div>

                        <!-- Widget 3: Tips list -->
                        <div class="bg-white p-3.5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-4.5 h-4.5 flex items-center justify-center text-provider-green bg-provider-green-light rounded-full">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8M12 3a9 9 0 019 9c0 2.21-1.07 4.2-2.73 5.48A3.001 3.001 0 0017 20H7a3.001 3.001 0 00-1.27-2.52C4.07 16.2 3 14.21 3 12a9 9 0 019-9z"></path></svg>
                                </div>
                                <h4 class="text-xs font-bold text-gray-800">Tips for a Great Listing</h4>
                            </div>
                            <ul class="space-y-1.5 text-[9.5px] font-semibold text-gray-600">
                                <li class="flex items-center gap-2"><svg class="w-3 h-3 text-provider-green shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg> Keep details up to date</li>
                                <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-provider-green shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg> Highlight what you accept clearly</li>
                                <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-provider-green shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg> Set competitive, clear prices</li>
                            </ul>
                        </div>

                        <!-- Widget 4: Submit Buttons -->
                        <div class="space-y-2">
                            <button type="submit" class="w-full bg-provider-green hover:bg-provider-green-dark text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-sm active:scale-[0.98] cursor-pointer">Update Listing</button>
                            <button type="button" onclick="window.location.href='{{ route('services.index') }}'" class="w-full bg-white border border-gray-200 text-gray-700 font-bold py-2.5 px-4 rounded-xl text-xs hover:bg-gray-50 transition-colors shadow-sm cursor-pointer">Cancel</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceTitle = document.getElementById('service_title');
        const titleCounter = document.getElementById('title_counter');
        const shortDesc = document.getElementById('short_desc');
        const shortDescCounter = document.getElementById('short_desc_counter');
        const wordCounter = document.getElementById('word_counter');
        const hiddenInput = document.getElementById('detailed_description_hidden');

        const previewTitle = document.getElementById('preview_title');
        const previewDesc = document.getElementById('preview_desc');
        const previewPriceTag = document.getElementById('preview_price_tag');
        const servicePrice = document.getElementById('service_price');

        // Initialize Quill Rich Text Editor
        const quill = new Quill('#detailed_desc_editor', {
            theme: 'snow',
            placeholder: 'Provide a detailed description of your service, process, and benefits...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['clean']
                ]
            }
        });

        // Load initial state if old inputs exist
        if (hiddenInput.value) {
            quill.root.innerHTML = hiddenInput.value;
            const text = quill.getText().trim();
            const words = text === '' ? 0 : text.split(/\s+/).length;
            if (wordCounter) {
                wordCounter.innerText = `${words} ${words === 1 ? 'word' : 'words'}`;
            }
        }

        // Sync Quill changes to hidden input and update word counter
        quill.on('text-change', function() {
            hiddenInput.value = quill.root.innerHTML;
            const text = quill.getText().trim();
            const words = text === '' ? 0 : text.split(/\s+/).length;
            if (wordCounter) {
                wordCounter.innerText = `${words} ${words === 1 ? 'word' : 'words'}`;
            }
        });

        // Initial Counter populations on page load
        if (serviceTitle) {
            titleCounter.innerText = `${serviceTitle.value.length}/100`;
        }
        if (shortDesc) {
            shortDescCounter.innerText = `${shortDesc.value.length}/200`;
        }

        // Dynamic Char counter for title
        serviceTitle.addEventListener('input', function() {
            const length = serviceTitle.value.length;
            titleCounter.innerText = `${length}/100`;
            if (length > 0) {
                previewTitle.innerText = serviceTitle.value;
                previewTitle.classList.remove('text-gray-400');
            } else {
                previewTitle.innerText = 'Your service preview will appear here';
                previewTitle.classList.add('text-gray-400');
            }
        });

        // Dynamic Char counter for short description
        shortDesc.addEventListener('input', function() {
            const length = shortDesc.value.length;
            shortDescCounter.innerText = `${length}/200`;
            if (length > 0) {
                previewDesc.innerText = shortDesc.value;
            } else {
                previewDesc.innerText = 'Add details and images to see how your service will look to customers.';
            }
        });

        // Dynamic Price Tag
        servicePrice.addEventListener('input', function() {
            const val = servicePrice.value;
            if (val !== '' && !isNaN(val)) {
                previewPriceTag.innerText = `₹${parseFloat(val).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                previewPriceTag.classList.remove('hidden');
            } else {
                previewPriceTag.classList.add('hidden');
            }
        });

        // Upload and Drag-n-drop handling
        const dragDropArea = document.getElementById('drag_drop_area');
        const storeSvg = document.getElementById('store_svg');
        const previewUploadedImg = document.getElementById('preview_uploaded_img');

        // Clicking the main drag drop area triggers Slot 1
        dragDropArea.addEventListener('click', () => triggerBrowse(1));

        dragDropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dragDropArea.classList.add('border-provider-green', 'bg-provider-green-light/10');
        });

        dragDropArea.addEventListener('dragleave', () => {
            dragDropArea.classList.remove('border-provider-green', 'bg-provider-green-light/10');
        });

        dragDropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dragDropArea.classList.remove('border-provider-green', 'bg-provider-green-light/10');
            if (e.dataTransfer.files.length > 0) {
                // Distribute dropped files sequentially into empty inputs
                const files = e.dataTransfer.files;
                const limit = Math.min(files.length, 5);
                for (let i = 0; i < limit; i++) {
                    const input = document.getElementById(`image_upload_input_${i + 1}`);
                    if (input) {
                        const dt = new DataTransfer();
                        dt.items.add(files[i]);
                        input.files = dt.files;
                        previewSlot(i + 1, input);
                    }
                }
            }
        });

        window.triggerBrowse = function(slotNum) {
            const input = document.getElementById(`image_upload_input_${slotNum}`);
            if (input) {
                input.click();
            }
        }

        // Prevent click bubbling up to dragDropArea
        for (let i = 1; i <= 5; i++) {
            const input = document.getElementById(`image_upload_input_${i}`);
            if (input) {
                input.addEventListener('click', (e) => e.stopPropagation());
            }
        }

        window.previewSlot = function(slotNum, input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Update thumbnail
                        const thumb = document.getElementById(`thumb_${slotNum}`);
                        if (thumb) {
                            thumb.src = e.target.result;
                            thumb.classList.remove('hidden');
                            if (thumb.previousElementSibling) {
                                thumb.previousElementSibling.classList.add('hidden');
                            }
                        }

                        // Show cross/remove button
                        const removeBtn = document.getElementById(`remove_btn_${slotNum}`);
                        if (removeBtn) {
                            removeBtn.classList.remove('hidden');
                        }

                        // Update main hero preview
                        if (slotNum === 1) {
                            if (storeSvg) storeSvg.classList.add('hidden');
                            if (previewUploadedImg) {
                                previewUploadedImg.src = e.target.result;
                                previewUploadedImg.classList.remove('hidden');
                            }
                        }

                        // Clear the existing image hidden input if it exists
                        const existingInput = document.getElementById(`existing_image_${slotNum}`);
                        if (existingInput) {
                            existingInput.value = '';
                        }
                    }
                    reader.readAsDataURL(file);
                }
            }
        }

        window.clearSlot = function(event, slotNum) {
            if (event) event.stopPropagation(); // Stop triggering file selector!
            
            const input = document.getElementById(`image_upload_input_${slotNum}`);
            if (input) {
                input.value = ''; // Clear file input
            }
            
            const thumb = document.getElementById(`thumb_${slotNum}`);
            if (thumb) {
                thumb.src = '';
                thumb.classList.add('hidden');
                if (thumb.previousElementSibling) {
                    thumb.previousElementSibling.classList.remove('hidden'); // Show placeholder plus icon
                }
            }
            
            const removeBtn = document.getElementById(`remove_btn_${slotNum}`);
            if (removeBtn) {
                removeBtn.classList.add('hidden'); // Hide remove button
            }
            
            // Handle edit mode existing images
            const existingInput = document.getElementById(`existing_image_${slotNum}`);
            if (existingInput) {
                existingInput.value = '';
            }
            
            // Refresh hero preview
            if (slotNum === 1) {
                refreshHeroPreview();
            }
        }

        window.refreshHeroPreview = function() {
            const thumb1 = document.getElementById('thumb_1');
            const storeSvg = document.getElementById('store_svg');
            const previewUploadedImg = document.getElementById('preview_uploaded_img');
            
            if (thumb1 && !thumb1.classList.contains('hidden') && thumb1.src) {
                if (storeSvg) storeSvg.classList.add('hidden');
                if (previewUploadedImg) {
                    previewUploadedImg.src = thumb1.src;
                    previewUploadedImg.classList.remove('hidden');
                }
            } else {
                if (storeSvg) storeSvg.classList.remove('hidden');
                if (previewUploadedImg) {
                    previewUploadedImg.classList.add('hidden');
                    previewUploadedImg.src = '';
                }
            }
        }

        window.swapSlots = function(i, j) {
            if (i === j) return;
            
            const inputI = document.getElementById(`image_upload_input_${i}`);
            const inputJ = document.getElementById(`image_upload_input_${j}`);
            
            const thumbI = document.getElementById(`thumb_${i}`);
            const thumbJ = document.getElementById(`thumb_${j}`);
            
            const plusI = thumbI.previousElementSibling;
            const plusJ = thumbJ.previousElementSibling;

            const removeBtnI = document.getElementById(`remove_btn_${i}`);
            const removeBtnJ = document.getElementById(`remove_btn_${j}`);
            
            // Swap file inputs
            const tempFiles = inputI.files;
            inputI.files = inputJ.files;
            inputJ.files = tempFiles;
            
            // Swap preview images src & hidden status
            const tempSrc = thumbI.src;
            const tempHidden = thumbI.classList.contains('hidden');
            
            if (thumbJ.classList.contains('hidden')) {
                thumbI.src = '';
                thumbI.classList.add('hidden');
                if (plusI) plusI.classList.remove('hidden');
                if (removeBtnI) removeBtnI.classList.add('hidden');
            } else {
                thumbI.src = thumbJ.src;
                thumbI.classList.remove('hidden');
                if (plusI) plusI.classList.add('hidden');
                if (removeBtnI) removeBtnI.classList.remove('hidden');
            }
            
            if (tempHidden) {
                thumbJ.src = '';
                thumbJ.classList.add('hidden');
                if (plusJ) plusJ.classList.remove('hidden');
                if (removeBtnJ) removeBtnJ.classList.add('hidden');
            } else {
                thumbJ.src = tempSrc;
                thumbJ.classList.remove('hidden');
                if (plusJ) plusJ.classList.add('hidden');
                if (removeBtnJ) removeBtnJ.classList.remove('hidden');
            }
            
            // Swap existing images values (for edit mode)
            const existingI = document.getElementById(`existing_image_${i}`);
            const existingJ = document.getElementById(`existing_image_${j}`);
            if (existingI || existingJ) {
                const tempExist = existingI ? existingI.value : '';
                if (existingI && existingJ) {
                    existingI.value = existingJ.value;
                    existingJ.value = tempExist;
                }
            }
            
            // Refresh main hero preview if slot 1 is changed
            if (i === 1 || j === 1) {
                refreshHeroPreview();
            }
        }

        let draggedSlotNum = null;

        window.handleDragStart = function(event, slotNum) {
            const thumb = document.getElementById(`thumb_${slotNum}`);
            if (thumb && !thumb.classList.contains('hidden') && thumb.src) {
                draggedSlotNum = slotNum;
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', slotNum.toString());
                event.currentTarget.classList.add('border-provider-green', 'scale-95');
            } else {
                event.preventDefault();
            }
        }

        window.handleDragOver = function(event) {
            event.preventDefault();
            event.currentTarget.classList.add('border-provider-green', 'bg-provider-green-light/10');
        }

        window.handleDragLeave = function(event) {
            event.currentTarget.classList.remove('border-provider-green', 'bg-provider-green-light/10');
        }

        window.handleDrop = function(event, targetSlotNum) {
            event.preventDefault();
            event.currentTarget.classList.remove('border-provider-green', 'bg-provider-green-light/10');
            
            const dragSource = document.querySelector('[draggable="true"].scale-95');
            if (dragSource) {
                dragSource.classList.remove('border-provider-green', 'scale-95');
            }

            if (draggedSlotNum !== null && draggedSlotNum !== targetSlotNum) {
                swapSlots(draggedSlotNum, targetSlotNum);
                draggedSlotNum = null;
            }
        }
    });

    window.openMockPreview = function() {
        // 1. Get values from input elements
        const nameVal = document.getElementById('service_title')?.value || 'Unnamed Service';
        const categorySelect = document.querySelector('select[name="category"]');
        const categoryVal = categorySelect?.options[categorySelect.selectedIndex]?.text || 'Composting';
        const descVal = document.querySelector('textarea[name="description"]')?.value || 'Short description placeholder...';
        const detailedVal = document.getElementById('detailed_description_hidden')?.value || 'Detailed description placeholder...';
        const typeSelect = document.querySelector('select[name="type"]');
        const typeVal = typeSelect?.options[typeSelect.selectedIndex]?.text || 'Pickup Service';
        const priceVal = document.querySelector('input[name="price"]')?.value || '0';
        const unitVal = document.querySelector('select[name="unit"]');
        const unitValText = unitVal?.options[unitVal.selectedIndex]?.text || 'kg';
        const acceptVal = document.querySelector('input[name="what_we_accept"]')?.value || 'All organic waste';

        // 2. Populate modal texts
        const setEl = (id, val, isHtml = false) => { const el = document.getElementById(id); if (el) isHtml ? el.innerHTML = val : el.textContent = val; };
        setEl('mock_preview_name', nameVal);
        setEl('mock_preview_category', categoryVal);
        setEl('mock_preview_desc', descVal);
        setEl('mock_preview_detailed', detailedVal, true);
        setEl('mock_preview_price', `₹${priceVal}`);
        setEl('mock_preview_unit', ` / ${unitValText}`);
        setEl('mock_preview_total', `₹${priceVal}`);

        // 3. Populate cover & gallery from current preview images
        const galleryContainer = document.getElementById('mock_preview_gallery');
        galleryContainer.innerHTML = '';
        
        let activeImages = [];
        
        // Find all thumbnail slots that currently have loaded previews
        for (let idx = 1; idx <= 5; idx++) {
            const thumb = document.getElementById(`thumb_${idx}`);
            if (thumb && !thumb.classList.contains('hidden') && thumb.src) {
                activeImages.push(thumb.src);
            }
        }
        
        const coverImg = document.getElementById('mock_preview_cover');
        const placeholder = document.getElementById('mock_preview_svg_placeholder');
        
        if (activeImages.length > 0) {
            coverImg.src = activeImages[0];
            coverImg.classList.remove('hidden');
            placeholder.classList.add('hidden');
            
            // Populate thumbnail gallery if more than 1 image (show ALL images as tiles)
            if (activeImages.length > 1) {
                activeImages.forEach((imgSrc, index) => {
                    const thumbDiv = document.createElement('div');
                    thumbDiv.className = `w-20 h-16 rounded-xl overflow-hidden border-2 ${index === 0 ? 'border-provider-green' : 'border-gray-100'} bg-gray-50 cursor-pointer select-none transition-all hover:scale-105 duration-200`;
                    thumbDiv.onclick = function() {
                        coverImg.src = imgSrc;
                        document.querySelectorAll('#mock_preview_gallery > div').forEach(d => {
                            d.classList.remove('border-provider-green');
                            d.classList.add('border-gray-100');
                        });
                        thumbDiv.classList.add('border-provider-green');
                        thumbDiv.classList.remove('border-gray-100');
                    };
                    
                    const img = document.createElement('img');
                    img.src = imgSrc;
                    img.className = 'w-full h-full object-cover';
                    
                    thumbDiv.appendChild(img);
                    galleryContainer.appendChild(thumbDiv);
                });
            }
        } else {
            coverImg.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        // Show the modal
        document.getElementById('mock_preview_modal').classList.remove('hidden');
    }

    window.closeMockPreview = function() {
        document.getElementById('mock_preview_modal').classList.add('hidden');
    }
</script>

<!-- Live Mock Preview Modal -->
<div id="mock_preview_modal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm overflow-y-auto flex items-center justify-center p-4">
    <div class="bg-[#F8F9FA] rounded-3xl w-full max-w-[1100px] max-h-[90vh] overflow-y-auto relative shadow-2xl animate-fade-in text-left select-none">
        <!-- Close button & header -->
        <div class="sticky top-0 bg-white z-10 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="bg-provider-green-light text-provider-green text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Live Preview Mode</span>
                <span class="text-xs text-gray-400 font-medium">This is a dynamic mock simulation of how your service appears to customers</span>
            </div>
            <button type="button" onclick="closeMockPreview()" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Modal body replicating bookings/create.blade.php layout -->
        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Left Column: Details -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 space-y-6">
                        <!-- Cover & mini gallery -->
                        <div class="space-y-3">
                            <div class="h-80 w-full rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 relative">
                                <img id="mock_preview_cover" src="" class="w-full h-full object-cover hidden" />
                                <div id="mock_preview_svg_placeholder" class="w-full h-full bg-gradient-to-br from-[#E2E4DE] to-[#C2C9BD] flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-provider-green/60 mb-2" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18M12 3c4 0 7 3 7 7v4c0 3-3 5-7 5s-7-2-7-5v-4c0-4 3-7 7-7z" />
                                    </svg>
                                    <span class="text-xs font-bold text-gray-500 tracking-wider uppercase">No Image Uploaded</span>
                                </div>
                            </div>
                            
                            <!-- Mini Gallery -->
                            <div id="mock_preview_gallery" class="flex flex-wrap gap-3 select-none">
                                <!-- Previews dynamically populated by JS -->
                            </div>
                        </div>
                        
                        <!-- Title & short description -->
                        <div class="space-y-3 pt-2">
                            <span id="mock_preview_category" class="inline-block bg-provider-green-light text-provider-green text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                Composting
                            </span>
                            <h1 id="mock_preview_name" class="text-3xl font-extrabold text-gray-950 tracking-tight leading-tight">
                                Service Title Placeholder
                            </h1>
                            <p id="mock_preview_desc" class="text-sm text-gray-500 font-medium leading-relaxed">
                                Short description placeholder...
                            </p>
                        </div>
                        
                        <!-- Divider -->
                        <div class="h-px bg-gray-100 my-2"></div>
                        
                        <!-- Provider mock info -->
                        <div class="flex items-center justify-between bg-[#F8F9FA]/50 border border-gray-100/70 p-4 rounded-2xl">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-provider-green-light overflow-hidden flex items-center justify-center text-provider-green font-bold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="font-extrabold text-sm text-gray-900 leading-tight">{{ Auth::user()->business_name ?? Auth::user()->name }}</p>
                                        <span class="bg-provider-green-light text-provider-green text-[8.5px] font-bold px-1.5 py-0.5 rounded-md uppercase">Verified</span>
                                    </div>
                                    <p class="text-[11px] text-gray-400 font-bold uppercase mt-0.5 tracking-wider">Service Provider</p>
                                </div>
                            </div>
                            <div class="text-xs font-bold text-gray-500">
                                <span>{{ Auth::user()->city ?? 'Your City' }}, {{ Auth::user()->state ?? 'Your State' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- About Service / Detailed Description -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 space-y-5">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">About this Service</h3>
                        <div id="mock_preview_detailed" class="text-xs text-gray-500 font-medium leading-relaxed prose prose-sm max-w-none">
                            Detailed description goes here...
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Mock Booking Box -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.02)] space-y-6">
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900 tracking-tight leading-tight">Book This Service</h2>
                            <p class="text-[11px] text-gray-400 font-semibold mt-0.5">Fill in the details to schedule your service</p>
                        </div>
                        <div class="bg-[#F8F9FA] border border-gray-100 px-4 py-3 rounded-xl flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-600">Service Price</span>
                            <span class="text-sm font-extrabold text-provider-green"><span id="mock_preview_price">₹0</span><span id="mock_preview_unit" class="text-[10px] text-gray-400 font-bold"> / kg</span></span>
                        </div>
                        
                        <div class="h-px bg-gray-100"></div>
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-bold text-gray-900 leading-none">Total Amount</p>
                            <p id="mock_preview_total" class="text-3xl font-extrabold text-provider-green leading-none">₹0</p>
                        </div>
                        <button type="button" class="w-full bg-[#0e3c16] text-white font-extrabold py-3.5 rounded-xl text-xs uppercase tracking-wider opacity-90 cursor-not-allowed">
                            Confirm Booking (Simulation)
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
