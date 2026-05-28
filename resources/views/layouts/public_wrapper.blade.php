<x-public-layout>
    <div class="bg-gray-100 min-h-screen">
        @hasSection('no_container')
            @yield('content')
        @else
            <div class="container mx-auto px-4 py-4">
                @yield('content')
            </div>
        @endif
    </div>
</x-public-layout>
