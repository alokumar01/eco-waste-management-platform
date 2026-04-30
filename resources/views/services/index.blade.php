<x-app-layout>
    <x-slot name="header">
        <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-end">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.28em] text-primary">Eco Services</p>
                <h1 class="mt-2 text-4xl font-bold tracking-tight text-foreground">Find approved composting partners</h1>
                <p class="mt-3 max-w-2xl text-muted-foreground">Browse verified providers who can turn food scraps, garden waste, and organic byproducts into soil value.</p>
            </div>

            <form method="GET" action="{{ route('services.index') }}" class="grid gap-3 rounded-3xl border border-border bg-card/90 p-4 shadow-sm sm:grid-cols-[1fr_auto]">
                <div class="grid gap-3 sm:grid-cols-2">
                    <x-text-input name="search" :value="request('search')" placeholder="Search location or service" />
                    <select name="category" class="rounded-xl border border-border bg-input/80 px-3 py-2.5 text-foreground shadow-sm focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="">All categories</option>
                        @foreach ($categories as $value => $label)
                            <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button type="submit">Filter</x-primary-button>
            </form>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($services as $service)
                    <x-card class="flex min-h-full flex-col">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary">{{ $categories[$service->category] ?? $service->category }}</p>
                                <h2 class="mt-2 text-xl font-semibold">{{ $service->title }}</h2>
                            </div>
                            <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">Approved</span>
                        </div>

                        <p class="mt-3 text-sm text-muted-foreground">{{ $service->location }}</p>
                        <p class="mt-4 flex-1 text-sm leading-6 text-foreground/80">{{ \Illuminate\Support\Str::limit($service->description, 190) }}</p>

                        <div class="mt-5 rounded-2xl bg-secondary/70 p-4 text-sm">
                            <p class="font-semibold">{{ $service->provider->business_name ?: $service->provider->name }}</p>
                            <p class="mt-1 text-muted-foreground">{{ $service->provider->service_area ?: 'Service area available on request' }}</p>
                        </div>

                        <div class="mt-5 flex items-center justify-between gap-4 text-sm">
                            <span class="font-semibold">
                                @if ($service->price)
                                    ₹{{ number_format((float) $service->price, 2) }} / {{ $service->unit }}
                                @else
                                    Quote-based
                                @endif
                            </span>
                            @if ($service->capacity_kg_per_week)
                                <span class="text-muted-foreground">{{ $service->capacity_kg_per_week }} kg/week</span>
                            @endif
                        </div>
                    </x-card>
                @empty
                    <x-card class="md:col-span-2 xl:col-span-3 border-dashed border-primary/30 bg-primary/5 text-center">
                        <h2 class="text-xl font-semibold">No approved services found</h2>
                        <p class="mt-2 text-sm text-muted-foreground">Try another search, or check back after providers publish newly approved services.</p>
                    </x-card>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
