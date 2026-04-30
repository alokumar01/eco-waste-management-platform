<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 rounded-full border border-primary/15 bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-primary">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h9l3 3v13H6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 4v4h4M9 12h6M9 16h6" />
                    </svg>
                    <span>Service Library</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">Manage your composting services</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-muted-foreground sm:text-base">Track the full lifecycle of each listing with a cleaner review workflow, clearer actions, and better at-a-glance service details.</p>
                </div>
            </div>

            <a href="{{ route('provider.services.create') }}" class="inline-flex">
                <x-primary-button type="button">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                    </svg>
                    <span>Create service</span>
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    @php
        $categories = \App\Models\CompostingService::categories();
    @endphp

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

            <div class="grid gap-5 xl:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)]">
                <x-card class="overflow-hidden border-primary/10 bg-[linear-gradient(135deg,rgba(34,197,94,0.12),rgba(255,255,255,0.92)_44%,rgba(59,130,246,0.08))]">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-2xl">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-primary/80">Catalog overview</p>
                            <h2 class="mt-3 text-2xl font-bold tracking-tight text-foreground sm:text-3xl">{{ $services->total() }} service{{ $services->total() === 1 ? '' : 's' }} in your pipeline</h2>
                            <p class="mt-3 text-sm leading-6 text-muted-foreground sm:text-base">Keep each listing complete, submit drafts when they are ready, and publish approved services only when the information is sharp and current.</p>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="rounded-3xl border border-white/80 bg-white/80 px-4 py-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-muted-foreground">Showing</p>
                                <p class="mt-3 text-2xl font-bold text-foreground">{{ $services->count() }}</p>
                                <p class="mt-1 text-xs text-muted-foreground">on this page</p>
                            </div>
                            <div class="rounded-3xl border border-white/80 bg-white/80 px-4 py-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-muted-foreground">Page</p>
                                <p class="mt-3 text-2xl font-bold text-foreground">{{ $services->currentPage() }}</p>
                                <p class="mt-1 text-xs text-muted-foreground">of {{ $services->lastPage() }}</p>
                            </div>
                            <div class="rounded-3xl border border-white/80 bg-white/80 px-4 py-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-muted-foreground">Freshness</p>
                                <p class="mt-3 text-2xl font-bold text-foreground">{{ $services->firstItem() ?: 0 }}-{{ $services->lastItem() ?: 0 }}</p>
                                <p class="mt-1 text-xs text-muted-foreground">recently updated</p>
                            </div>
                        </div>
                    </div>
                </x-card>

                <x-card class="border-white/70 bg-white/90">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v5l3 3" />
                                <circle cx="12" cy="12" r="9" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="text-lg font-semibold text-foreground">Review workflow</h2>
                            <p class="mt-1 text-sm text-muted-foreground">A simple path from draft to live listing.</p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-3">
                        <div class="rounded-2xl border border-border/70 bg-background/70 px-4 py-3">
                            <p class="text-sm font-semibold text-foreground">1. Build a solid draft</p>
                            <p class="mt-1 text-sm text-muted-foreground">Use clear descriptions, pricing, and availability so admins have everything they need.</p>
                        </div>
                        <div class="rounded-2xl border border-border/70 bg-background/70 px-4 py-3">
                            <p class="text-sm font-semibold text-foreground">2. Submit for review</p>
                            <p class="mt-1 text-sm text-muted-foreground">Drafts become pending review and wait for admin approval.</p>
                        </div>
                        <div class="rounded-2xl border border-border/70 bg-background/70 px-4 py-3">
                            <p class="text-sm font-semibold text-foreground">3. Publish approved services</p>
                            <p class="mt-1 text-sm text-muted-foreground">Only approved services can go live, and profile approval is required too.</p>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="grid gap-4">
                @forelse ($services as $service)
                    <x-card class="border-white/70 bg-white/92">
                        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="text-xl font-semibold text-foreground">{{ $service->title }}</h2>
                                    <x-status-badge :status="$service->approval_status" />
                                    @if ($service->is_published)
                                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Live</span>
                                    @endif
                                </div>
                                <p class="mt-2 text-sm text-muted-foreground">{{ \Illuminate\Support\Str::limit($service->description, 180) }}</p>

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                                            <circle cx="12" cy="10" r="2.5" />
                                        </svg>
                                        <span>{{ $service->location }}</span>
                                    </span>
                                    <span class="inline-flex items-center gap-2 rounded-full bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M7 12h10M10 17h4" />
                                        </svg>
                                        <span>{{ $categories[$service->category] ?? $service->category }}</span>
                                    </span>
                                    @if ($service->service_radius_km)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M12 3a15.3 15.3 0 0 1 4 9 15.3 15.3 0 0 1-4 9 15.3 15.3 0 0 1-4-9 15.3 15.3 0 0 1 4-9Z" />
                                            </svg>
                                            <span>{{ $service->service_radius_km }} km radius</span>
                                        </span>
                                    @endif
                                    @if ($service->capacity_kg_per_week)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 20h10M12 4v16M8 8h8" />
                                            </svg>
                                            <span>{{ number_format((float) $service->capacity_kg_per_week) }} kg/week</span>
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center gap-2 rounded-full bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7H14.5a3.5 3.5 0 0 1 0 7H6" />
                                        </svg>
                                        <span>{{ $service->price !== null ? number_format((float) $service->price, 2).' / '.$service->unit : 'Quote based pricing' }}</span>
                                    </span>
                                </div>

                                @if ($service->approval_notes)
                                    <div class="mt-4 rounded-[1.25rem] border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                                        Admin feedback: {{ $service->approval_notes }}
                                    </div>
                                @endif

                                <p class="mt-4 text-xs font-medium uppercase tracking-[0.22em] text-muted-foreground">Updated {{ $service->updated_at?->diffForHumans() }}</p>
                            </div>

                            <div class="flex flex-wrap gap-2 lg:max-w-xs lg:justify-end">
                                <a href="{{ route('provider.services.edit', $service) }}">
                                    <x-secondary-button type="button">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4 20 4.5-1 9-9a2.12 2.12 0 1 0-3-3l-9 9L4 20Z" />
                                        </svg>
                                        <span>Edit</span>
                                    </x-secondary-button>
                                </a>

                                @if (! $service->is_published && $service->approval_status !== \App\Models\CompostingService::STATUS_PENDING && $service->approval_status !== \App\Models\CompostingService::STATUS_APPROVED)
                                    <form method="POST" action="{{ route('provider.services.submit', $service) }}">
                                        @csrf
                                        @method('patch')
                                        <x-secondary-button type="submit">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                                            </svg>
                                            <span>Submit</span>
                                        </x-secondary-button>
                                    </form>
                                @endif

                                @if ($service->is_published)
                                    <form method="POST" action="{{ route('provider.services.unpublish', $service) }}">
                                        @csrf
                                        @method('patch')
                                        <x-secondary-button type="submit">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                            <span>Unpublish</span>
                                        </x-secondary-button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('provider.services.publish', $service) }}">
                                        @csrf
                                        @method('patch')
                                        <x-primary-button type="submit">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 10 17l9-10" />
                                            </svg>
                                            <span>Publish</span>
                                        </x-primary-button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('provider.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?');">
                                    @csrf
                                    @method('delete')
                                    <x-danger-button>
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2m-9 0 1 14h8l1-14" />
                                        </svg>
                                        <span>Delete</span>
                                    </x-danger-button>
                                </form>
                            </div>
                        </div>
                    </x-card>
                @empty
                    <x-card class="border-dashed border-primary/30 bg-primary/5 py-10 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-primary/10 text-primary">
                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                            </svg>
                        </div>
                        <h2 class="mt-5 text-xl font-semibold text-foreground">No services yet</h2>
                        <p class="mt-2 text-sm text-muted-foreground">Start with a draft, then submit it for admin review when it is ready.</p>
                        <a class="mt-5 inline-flex" href="{{ route('provider.services.create') }}">
                            <x-primary-button type="button">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                </svg>
                                <span>Create your first service</span>
                            </x-primary-button>
                        </a>
                    </x-card>
                @endforelse
            </div>

            {{ $services->links() }}
        </div>
    </div>
</x-app-layout>
