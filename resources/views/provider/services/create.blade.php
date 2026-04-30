<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 rounded-full border border-primary/15 bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-primary">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                    </svg>
                    <span>New Service</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">Create composting service</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-muted-foreground sm:text-base">Build a professional listing with clear pricing, capacity, and operational details so it is ready for admin review.</p>
                </div>
            </div>

            <a href="{{ route('provider.services.index') }}" class="inline-flex">
                <x-secondary-button type="button">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                    </svg>
                    <span>Back to services</span>
                </x-secondary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <x-card padding="p-0" class="overflow-hidden border-white/70 bg-white/92">
                @include('provider.services._form', [
                    'service' => $service,
                    'categories' => $categories,
                    'action' => route('provider.services.store'),
                ])
            </x-card>
        </div>
    </div>
</x-app-layout>
