<div class="bg-green-tint rounded-2xl p-8 relative overflow-hidden flex flex-col md:flex-row items-center border border-green-50">
    <div class="md:w-[60%] z-10">
        <div class="inline-flex items-center gap-2 bg-green-100 text-green-theme text-xs font-semibold px-2.5 py-1 rounded-md mb-4">
            <i class="fa-solid fa-leaf"></i> Our Blog
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-4">
            Knowledge for a <br> <span class="text-green-theme">Sustainable Future</span>
        </h1>
        <p class="text-gray-600 mb-6 text-sm md:text-base">Explore expert insights, tips, and guides on composting, waste management, and sustainable living.</p>
        
        <div class="relative flex items-center mb-6">
            <input type="text" placeholder="Search articles..." class="w-full bg-white border border-gray-200 rounded-lg pl-4 pr-12 py-3 focus:outline-none focus:border-green-theme text-sm shadow-sm">
            <button class="absolute right-1.5 bg-green-theme text-white w-9 h-9 rounded-md flex items-center justify-center hover-bg-green-theme transition-colors">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </button>
        </div>

        <div class="flex flex-wrap gap-2 text-xs font-medium">
            <span class="bg-green-theme text-white px-3 py-1.5 rounded-full cursor-pointer flex items-center gap-1.5"><i class="fa-solid fa-border-all"></i> All Articles</span>
            <span class="bg-white border border-gray-200 text-gray-600 px-3 py-1.5 rounded-full cursor-pointer hover:border-gray-300 flex items-center gap-1.5"><i class="fa-solid fa-leaf"></i> Composting</span>
            <span class="bg-white border border-gray-200 text-gray-600 px-3 py-1.5 rounded-full cursor-pointer hover:border-gray-300 flex items-center gap-1.5"><i class="fa-solid fa-trash-can"></i> Waste Management</span>
            <span class="bg-white border border-gray-200 text-gray-600 px-3 py-1.5 rounded-full cursor-pointer hover:border-gray-300 flex items-center gap-1.5"><i class="fa-solid fa-recycle"></i> Sustainability</span>
            <span class="bg-white border border-gray-200 text-gray-600 px-3 py-1.5 rounded-full cursor-pointer hover:border-gray-300 flex items-center gap-1.5"><i class="fa-solid fa-house"></i> Eco Living</span>
        </div>
    </div>
    <div class="md:w-[40%] mt-6 md:mt-0 relative flex justify-center h-full min-h-[250px] z-0">
        <img src="{{ asset('images/blog-hero-bin.png') }}" alt="Sustainable Compost Illustration" class="w-full max-w-sm object-contain mix-blend-multiply scale-110">
    </div>
</div>
