<div class="bg-white border border-gray-100 rounded-2xl p-6">
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-leaf text-green-theme text-xs"></i>
        <h3 class="font-bold text-gray-900">Categories</h3>
    </div>
    <ul class="space-y-1 text-sm p-0 m-0 list-none">
        @php
            $categories = [
                ['name' => 'All Articles', 'count' => 42, 'icon' => 'fa-solid fa-border-all', 'active' => true],
                ['name' => 'Composting', 'count' => 12, 'icon' => 'fa-solid fa-leaf'],
                ['name' => 'Waste Management', 'count' => 10, 'icon' => 'fa-solid fa-trash-can'],
                ['name' => 'Sustainability', 'count' => 8, 'icon' => 'fa-solid fa-recycle'],
                ['name' => 'Eco Living', 'count' => 6, 'icon' => 'fa-solid fa-house'],
                ['name' => 'Recycling', 'count' => 4, 'icon' => 'fa-solid fa-boxes-packing'],
                ['name' => 'Guides', 'count' => 2, 'icon' => 'fa-solid fa-book'],
            ];
        @endphp
        @foreach ($categories as $category)
            <li>
                <a href="#" class="flex justify-between items-center px-3 py-2.5 rounded-lg {{ ($category['active'] ?? false) ? 'bg-green-50 text-green-theme font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <div class="flex items-center gap-2"><i class="{{ $category['icon'] }} w-4 {{ ($category['active'] ?? false) ? '' : 'text-gray-400' }}"></i> {{ $category['name'] }}</div>
                    <span class="{{ ($category['active'] ?? false) ? 'bg-green-100' : 'bg-gray-100' }} text-xs px-2 py-0.5 rounded-md">{{ $category['count'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <a href="#" class="text-green-theme font-semibold text-sm mt-4 inline-flex items-center gap-1 px-3">View All Categories <i class="fa-solid fa-arrow-right text-xs"></i></a>
</div>
