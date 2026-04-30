<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="space-y-3">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-primary/15 bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-primary">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3l7 4v5c0 4.25-2.55 8.24-7 9-4.45-.76-7-4.75-7-9V7l7-4Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.5 12 1.7 1.7 3.8-4.2" />
                    </svg>
                    <span>Provider Hub</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">Grow your composting
                        impact</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-muted-foreground sm:text-base">Manage your profile,
                        refine your services, and keep every listing ready for review and publishing from one responsive
                        operations space.</p>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('provider.services.index') }}" class="inline-flex">
                    <x-secondary-button type="button">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h9l3 3v13H6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 4v4h4M9 12h6M9 16h6" />
                        </svg>
                        <span>Manage services</span>
                    </x-secondary-button>
                </a>
                <a href="{{ route('provider.services.create') }}" class="inline-flex">
                    <x-primary-button type="button">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                        </svg>
                        <span>Create service</span>
                    </x-primary-button>
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $categories = \App\Models\CompostingService::categories();
        $profileChecks = [
            'Business details added' => filled($provider->business_name),
            'Phone number added' => filled($provider->phone),
            'Service area defined' => filled($provider->service_area),
            'Address shared' => filled($provider->address),
            'Bio completed' => filled($provider->bio),
        ];
        $completedProfileFields = collect($profileChecks)->filter()->count();
        $profileCompletion = (int) round(($completedProfileFields / max(count($profileChecks), 1)) * 100);
    @endphp

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <x-card class="border-primary/20 bg-primary/10 text-sm font-medium text-foreground">
                    {{ session('status') }}
                </x-card>
            @endif

            <x-card
                class="overflow-hidden border-primary/10 bg-[linear-gradient(135deg,rgba(34,197,94,0.12),rgba(255,255,255,0.92)_42%,rgba(250,204,21,0.08))]">
                <div class="grid gap-8 lg:grid-cols-[minmax(0,1.2fr)_minmax(320px,0.8fr)] lg:items-center">
                    <div>
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-white/70 bg-white/80 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary shadow-sm">
                            <span>{{ $provider->business_name ?: $provider->name }}</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-foreground sm:text-3xl">Turn your
                            provider profile into a high-trust storefront.</h2>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-muted-foreground sm:text-base">Complete the
                            essentials, keep services fresh, and move more listings from draft to approved to live
                            without losing track of the admin review flow.</p>

                        <div class="mt-6 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-3xl border border-white/80 bg-white/75 p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-muted-foreground">
                                    Profile status</p>
                                <div class="mt-3 flex items-center gap-3">
                                    <span
                                        class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 3l7 4v5c0 4.25-2.55 8.24-7 9-4.45-.76-7-4.75-7-9V7l7-4Z" />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-foreground">
                                            {{ ucfirst(str_replace('_', ' ', $provider->provider_status ?? 'incomplete')) }}
                                        </p>
                                        <p class="text-xs text-muted-foreground">{{ $profileCompletion }}% profile
                                            complete</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-white/80 bg-white/75 p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-muted-foreground">
                                    Coverage</p>
                                <div class="mt-3 flex items-center gap-3">
                                    <span
                                        class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                                            <circle cx="12" cy="10" r="2.5" />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-foreground">
                                            {{ $provider->service_area ?: 'Add your service area' }}</p>
                                        <p class="text-xs text-muted-foreground">Helps customers and admins understand
                                            your reach</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-white/80 bg-white/75 p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-muted-foreground">
                                    Pipeline</p>
                                <div class="mt-3 flex items-center gap-3">
                                    <span
                                        class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 12h14M12 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-foreground">{{ $stats['pending'] }}
                                            awaiting review</p>
                                        <p class="text-xs text-muted-foreground">Keep descriptions detailed to speed
                                            approvals</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                        <div
                            class="rounded-[1.75rem] border border-foreground/5 bg-foreground px-5 py-5 text-white shadow-[0_30px_90px_-36px_rgba(17,24,39,0.9)]">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/60">Next best
                                        step</p>
                                    <h3 class="mt-2 text-lg font-semibold">
                                        {{ $stats['total'] ? 'Keep service listings moving' : 'Launch your first service' }}
                                    </h3>
                                </div>
                                <span
                                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-white">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-white/75">
                                {{ $stats['total'] ? 'Review recent listings, submit any drafts, and publish approved services to stay visible.' : 'Create a detailed service with pricing, coverage, and availability so it is ready for review.' }}
                            </p>
                        </div>

                        <div class="rounded-[1.75rem] border border-white/70 bg-white/80 p-5 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-muted-foreground">Quick
                                actions</p>
                            <div class="mt-4 space-y-3">
                                <a href="{{ route('provider.services.create') }}"
                                    class="flex items-center justify-between rounded-2xl border border-border/70 bg-background/70 px-4 py-3 text-sm font-semibold text-foreground transition hover:-translate-y-0.5 hover:border-primary/30 hover:shadow-sm">
                                    <span class="flex items-center gap-3">
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 5v14M5 12h14" />
                                            </svg>
                                        </span>
                                        <span>Create a new service</span>
                                    </span>
                                    <svg class="h-4 w-4 text-muted-foreground" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <a href="{{ route('provider.services.index') }}"
                                    class="flex items-center justify-between rounded-2xl border border-border/70 bg-background/70 px-4 py-3 text-sm font-semibold text-foreground transition hover:-translate-y-0.5 hover:border-primary/30 hover:shadow-sm">
                                    <span class="flex items-center gap-3">
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 4h9l3 3v13H6z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 4v4h4M9 12h6M9 16h6" />
                                            </svg>
                                        </span>
                                        <span>Review all services</span>
                                    </span>
                                    <svg class="h-4 w-4 text-muted-foreground" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <x-card class="border-primary/10 bg-white/88">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Total services</p>
                            <p class="mt-3 text-3xl font-bold text-foreground">{{ $stats['total'] }}</p>
                            <p class="mt-2 text-sm text-muted-foreground">Everything in your provider catalog, from
                                drafts to live listings.</p>
                        </div>
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M7 12h10M10 17h4" />
                            </svg>
                        </span>
                    </div>
                </x-card>
                <x-card class="border-emerald-100 bg-white/88">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Published</p>
                            <p class="mt-3 text-3xl font-bold text-foreground">{{ $stats['published'] }}</p>
                            <p class="mt-2 text-sm text-muted-foreground">Approved services that are currently visible
                                to customers.</p>
                        </div>
                        <span
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 10 17l9-10" />
                            </svg>
                        </span>
                    </div>
                </x-card>
                <x-card class="border-amber-100 bg-white/88">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Pending review</p>
                            <p class="mt-3 text-3xl font-bold text-foreground">{{ $stats['pending'] }}</p>
                            <p class="mt-2 text-sm text-muted-foreground">Services waiting on admin approval before they
                                can go live.</p>
                        </div>
                        <span
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v5l3 3" />
                                <circle cx="12" cy="12" r="9" />
                            </svg>
                        </span>
                    </div>
                </x-card>
                <x-card class="border-sky-100 bg-white/88">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Approved</p>
                            <p class="mt-3 text-3xl font-bold text-foreground">{{ $stats['approved'] }}</p>
                            <p class="mt-2 text-sm text-muted-foreground">Listings cleared for launch once you decide to
                                publish them.</p>
                        </div>
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-100 text-sky-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3l7 4v5c0 4.25-2.55 8.24-7 9-4.45-.76-7-4.75-7-9V7l7-4Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.5 12 1.7 1.7 3.8-4.2" />
                            </svg>
                        </span>
                    </div>
                </x-card>
            </div>

            <div class="grid gap-6 xl:grid-cols-[minmax(0,1.35fr)_minmax(320px,0.65fr)]">
                <x-card class="border-white/70 bg-white/90">
                    <div
                        class="flex flex-col gap-4 border-b border-border/70 pb-5 sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xl font-semibold text-foreground">Provider profile</h2>
                                <p class="mt-1 text-sm text-muted-foreground">Complete and maintain this profile so
                                    admins can approve your provider identity with confidence.</p>
                            </div>
                        </div>
                        <x-status-badge :status="$provider->provider_status ?? 'incomplete'" />
                    </div>

                    <div class="mt-5 rounded-3xl border border-border/70 bg-background/70 p-4">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-foreground">Profile completion</p>
                                <p class="mt-1 text-sm text-muted-foreground">{{ $completedProfileFields }} of
                                    {{ count($profileChecks) }} essentials are filled in.</p>
                            </div>
                            <p class="text-2xl font-bold text-foreground">{{ $profileCompletion }}%</p>
                        </div>
                        <div class="mt-4 h-2 overflow-hidden rounded-full bg-muted">
                            <div class="h-full rounded-full bg-primary transition-all"
                                style="width: {{ $profileCompletion }}%"></div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('provider.profile.update') }}"
                        class="mt-6 grid gap-5 md:grid-cols-2">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="business_name" :value="__('Business name')" />
                            <x-text-input id="business_name" name="business_name" class="mt-1"
                                :value="old('business_name', $provider->business_name)" required
                                placeholder="GreenCycle Organics" />
                            <x-input-error class="mt-2" :messages="$errors->get('business_name')" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" name="phone" class="mt-1" :value="old('phone', $provider->phone)"
                                required placeholder="+91 98765 43210" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="service_area" :value="__('Service area')" />
                            <x-text-input id="service_area" name="service_area" class="mt-1" :value="old('service_area', $provider->service_area)" required
                                placeholder="Neighborhoods, city, or region you serve" />
                            <p class="mt-2 text-xs text-muted-foreground">Be as specific as possible so your coverage
                                looks trustworthy and easy to understand.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('service_area')" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="address" :value="__('Address')" />
                            <textarea id="address" name="address" rows="3"
                                class="mt-1 w-full rounded-2xl border border-border bg-input/80 px-4 py-3 text-foreground shadow-sm transition focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30"
                                placeholder="Your registered business address">{{ old('address', $provider->address) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="bio" :value="__('Provider bio')" />
                            <textarea id="bio" name="bio" rows="5"
                                class="mt-1 w-full rounded-2xl border border-border bg-input/80 px-4 py-3 text-foreground shadow-sm transition focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30"
                                placeholder="Tell customers how you manage organic waste responsibly, what materials you accept, and what makes your process reliable.">{{ old('bio', $provider->bio) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                        </div>

                        <div
                            class="md:col-span-2 flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-sm text-muted-foreground">A complete profile helps with both admin approval
                                and customer trust.</p>
                            <x-primary-button>
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 10 17l9-10" />
                                </svg>
                                <span>Save provider profile</span>
                            </x-primary-button>
                        </div>
                    </form>
                </x-card>

                <div class="space-y-6">
                    <x-card class="border-white/70 bg-white/90">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 10 17l9-10" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xl font-semibold text-foreground">Launch checklist</h2>
                                <p class="mt-1 text-sm text-muted-foreground">Use this to keep your provider account
                                    publication-ready.</p>
                            </div>
                        </div>

                        <div class="mt-5 space-y-3">
                            @foreach ($profileChecks as $label => $isComplete)
                                <div
                                    class="flex items-center gap-3 rounded-2xl border border-border/70 bg-background/70 px-4 py-3">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-2xl {{ $isComplete ? 'bg-emerald-100 text-emerald-700' : 'bg-muted text-muted-foreground' }}">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8">
                                            @if ($isComplete)
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 10 17l9-10" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                            @endif
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-foreground">{{ $label }}</p>
                                        <p class="text-xs text-muted-foreground">
                                            {{ $isComplete ? 'Complete' : 'Needs attention' }}</p>
                                    </div>
                                </div>
                            @endforeach

                            <div
                                class="flex items-center gap-3 rounded-2xl border border-border/70 bg-background/70 px-4 py-3">
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-2xl {{ $stats['total'] > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-muted text-muted-foreground' }}">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8">
                                        @if ($stats['total'] > 0)
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 10 17l9-10" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                        @endif
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-foreground">At least one service created</p>
                                    <p class="text-xs text-muted-foreground">
                                        {{ $stats['total'] > 0 ? 'Your catalog is started.' : 'Create your first service to begin the review flow.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </x-card>

                    <x-card class="border-white/70 bg-white/90">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-100 text-sky-700">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h9l3 3v13H6z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 4v4h4M9 12h6M9 16h6" />
                                    </svg>
                                </span>
                                <div>
                                    <h2 class="text-xl font-semibold text-foreground">Recent services</h2>
                                    <p class="mt-1 text-sm text-muted-foreground">Draft, submit, approve, then publish
                                        with confidence.</p>
                                </div>
                            </div>
                            <a class="text-sm font-semibold text-primary transition hover:text-primary/80"
                                href="{{ route('provider.services.index') }}">View all</a>
                        </div>

                        <div class="mt-5 space-y-3">
                            @forelse ($services as $service)
                                <div class="rounded-3xl border border-border/70 bg-background/70 p-4 shadow-sm">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="min-w-0">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <h3 class="text-base font-semibold text-foreground">{{ $service->title }}
                                                </h3>
                                                <x-status-badge :status="$service->approval_status" />
                                                @if ($service->is_published)
                                                    <span
                                                        class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Live</span>
                                                @endif
                                            </div>
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                                                        <circle cx="12" cy="10" r="2.5" />
                                                    </svg>
                                                    <span>{{ $service->location }}</span>
                                                </span>
                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full bg-muted px-3 py-1 text-xs font-medium text-muted-foreground">
                                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4 7h16M7 12h10M10 17h4" />
                                                    </svg>
                                                    <span>{{ $categories[$service->category] ?? $service->category }}</span>
                                                </span>
                                            </div>
                                        </div>

                                        <p class="text-xs font-medium uppercase tracking-[0.24em] text-muted-foreground">
                                            {{ $service->updated_at?->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="rounded-3xl border border-dashed border-primary/30 bg-primary/5 p-6 text-sm text-muted-foreground">
                                    No services yet. Create your first composting service and submit it for review.
                                </div>
                            @endforelse
                        </div>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>