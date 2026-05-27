<div class="bg-white border border-gray-100 rounded-2xl p-6">
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-leaf text-green-theme text-xs"></i>
        <h3 class="font-bold text-gray-900">Categories</h3>
    </div>
    <ul class="space-y-1 text-sm p-0 m-0 list-none">
        @foreach ($categoriesList as $category)
            <li>
                <a href="{{ $category['url'] }}" class="flex justify-between items-center px-3 py-2.5 rounded-lg {{ ($category['active'] ?? false) ? 'bg-green-50 text-green-theme font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <div class="flex items-center gap-2"><i class="{{ $category['icon'] }} w-4 {{ ($category['active'] ?? false) ? '' : 'text-gray-400' }}"></i> {{ $category['name'] }}</div>
                    <span class="{{ ($category['active'] ?? false) ? 'bg-green-100' : 'bg-gray-100' }} text-xs px-2 py-0.5 rounded-md">{{ $category['count'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
