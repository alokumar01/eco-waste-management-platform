<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-primary">Admin Review</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-foreground">Approve provider services</h1>
            <p class="mt-2 text-sm text-muted-foreground">Services must be approved before a provider can publish them publicly.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <x-card class="border-primary/20 bg-primary/10 text-sm font-medium text-foreground">
                    {{ session('status') }}
                </x-card>
            @endif

            @if ($errors->any())
                <x-card class="border-red-200 bg-red-50 text-sm font-medium text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </x-card>
            @endif

            <div class="space-y-5">
                @forelse ($services as $service)
                    <x-card>
                        <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="text-xl font-semibold">{{ $service->title }}</h2>
                                    <x-status-badge :status="$service->approval_status" />
                                </div>
                                <p class="mt-2 text-sm text-muted-foreground">{{ $service->location }} · {{ \App\Models\CompostingService::categories()[$service->category] ?? $service->category }}</p>
                                <p class="mt-4 text-sm leading-6 text-foreground/80">{{ $service->description }}</p>

                                <div class="mt-5 rounded-2xl bg-secondary/70 p-4 text-sm">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <p class="font-semibold">{{ $service->provider->business_name ?: $service->provider->name }}</p>
                                        <x-status-badge :status="$service->provider->provider_status ?? 'incomplete'" />
                                    </div>
                                    <p class="mt-2 text-muted-foreground">{{ $service->provider->email }} · {{ $service->provider->phone ?: 'No phone provided' }}</p>
                                    <p class="mt-1 text-muted-foreground">{{ $service->provider->service_area ?: 'No service area provided' }}</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @if (! $service->provider->hasApprovedProviderProfile())
                                    <form method="POST" action="{{ route('admin.providers.approve', $service->provider) }}">
                                        @csrf
                                        @method('patch')
                                        <x-secondary-button type="submit" class="w-full">Approve provider profile</x-secondary-button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.services.approve', $service) }}">
                                    @csrf
                                    @method('patch')
                                    <x-primary-button type="submit" class="w-full">Approve service</x-primary-button>
                                </form>

                                <form method="POST" action="{{ route('admin.services.reject', $service) }}" class="space-y-3">
                                    @csrf
                                    @method('patch')
                                    <textarea name="approval_notes" rows="4" class="w-full rounded-xl border border-border bg-input/80 px-3 py-2.5 text-sm text-foreground shadow-sm transition focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30" placeholder="Explain what the provider should improve before approval." required>{{ old('approval_notes') }}</textarea>
                                    <x-danger-button type="submit" class="w-full">Reject with feedback</x-danger-button>
                                </form>
                            </div>
                        </div>
                    </x-card>
                @empty
                    <x-card class="border-dashed border-primary/30 bg-primary/5 text-center">
                        <h2 class="text-xl font-semibold">No services waiting for review</h2>
                        <p class="mt-2 text-sm text-muted-foreground">Submitted provider services will appear here.</p>
                    </x-card>
                @endforelse
            </div>

            {{ $services->links() }}
        </div>
    </div>
</x-app-layout>
