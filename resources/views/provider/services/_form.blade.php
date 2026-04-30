<form method="POST" action="{{ $action }}" class="space-y-0">
    @csrf
    @if (($method ?? 'POST') !== 'POST')
        @method($method)
    @endif

    <div class="grid gap-0 lg:grid-cols-[minmax(0,1.25fr)_minmax(280px,0.75fr)]">
        <div class="space-y-6 p-5 sm:p-6 lg:p-8">
            @if ($service->exists && $service->approval_status === \App\Models\CompostingService::STATUS_APPROVED)
                <div class="rounded-[1.5rem] border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                    Editing an approved service will unpublish it and send it back for admin review.
                </div>
            @endif

            <section class="rounded-[1.75rem] border border-border/70 bg-background/70 p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M7 12h10M10 17h4" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-semibold text-foreground">Service basics</h2>
                        <p class="mt-1 text-sm text-muted-foreground">Start with the core identity of your offering so customers and admins understand it quickly.</p>
                    </div>
                </div>

                <div class="mt-6 grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-input-label for="title" :value="__('Service title')" />
                        <x-text-input id="title" name="title" class="mt-1" :value="old('title', $service->title)" required placeholder="Weekly apartment compost pickup" />
                        <p class="mt-2 text-xs text-muted-foreground">Use a clear, benefit-driven title that describes exactly what the service does.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="category" :value="__('Category')" />
                        <select id="category" name="category" class="mt-1 w-full rounded-2xl border border-border bg-input/80 px-4 py-3 text-foreground shadow-sm transition focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30" required>
                            <option value="">Select a category</option>
                            @foreach ($categories as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $service->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('category')" />
                    </div>

                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" class="mt-1" :value="old('location', $service->location)" required placeholder="Bengaluru, Indiranagar" />
                        <x-input-error class="mt-2" :messages="$errors->get('location')" />
                    </div>
                </div>
            </section>

            <section class="rounded-[1.75rem] border border-border/70 bg-background/70 p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7H14.5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-semibold text-foreground">Capacity and pricing</h2>
                        <p class="mt-1 text-sm text-muted-foreground">Make the business side easy to understand with realistic coverage, volume, and billing info.</p>
                    </div>
                </div>

                <div class="mt-6 grid gap-5 md:grid-cols-2">
                    <div>
                        <x-input-label for="service_radius_km" :value="__('Service radius (km)')" />
                        <x-text-input id="service_radius_km" name="service_radius_km" type="number" min="1" max="500" class="mt-1" :value="old('service_radius_km', $service->service_radius_km)" />
                        <x-input-error class="mt-2" :messages="$errors->get('service_radius_km')" />
                    </div>

                    <div>
                        <x-input-label for="capacity_kg_per_week" :value="__('Capacity (kg/week)')" />
                        <x-text-input id="capacity_kg_per_week" name="capacity_kg_per_week" type="number" min="1" class="mt-1" :value="old('capacity_kg_per_week', $service->capacity_kg_per_week)" />
                        <x-input-error class="mt-2" :messages="$errors->get('capacity_kg_per_week')" />
                    </div>

                    <div>
                        <x-input-label for="price" :value="__('Price')" />
                        <x-text-input id="price" name="price" type="number" min="0" step="0.01" class="mt-1" :value="old('price', $service->price)" placeholder="Leave empty for quote-based pricing" />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>

                    <div>
                        <x-input-label for="unit" :value="__('Pricing unit')" />
                        <x-text-input id="unit" name="unit" class="mt-1" :value="old('unit', $service->unit ?: 'service')" required placeholder="month, pickup, service" />
                        <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                    </div>
                </div>
            </section>

            <section class="rounded-[1.75rem] border border-border/70 bg-background/70 p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12h12M12 6v12" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-semibold text-foreground">Operational details</h2>
                        <p class="mt-1 text-sm text-muted-foreground">Add the detail that helps reviewers trust the service and customers know what to expect.</p>
                    </div>
                </div>

                <div class="mt-6 grid gap-5">
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="6" class="mt-1 w-full rounded-2xl border border-border bg-input/80 px-4 py-3 text-foreground shadow-sm transition focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30" required placeholder="Describe what is included, accepted waste types, pickup flow, and composting method.">{{ old('description', $service->description) }}</textarea>
                        <p class="mt-2 text-xs text-muted-foreground">Good descriptions usually explain what is collected, how pickup works, and what outcomes the customer gets.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div>
                        <x-input-label for="availability" :value="__('Availability')" />
                        <textarea id="availability" name="availability" rows="4" class="mt-1 w-full rounded-2xl border border-border bg-input/80 px-4 py-3 text-foreground shadow-sm transition focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30" placeholder="Pickup days, booking lead time, or seasonal notes.">{{ old('availability', $service->availability) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('availability')" />
                    </div>
                </div>
            </section>

            <div class="flex flex-col gap-3 border-t border-border/70 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-muted-foreground">Save a draft while refining details, or submit now if the listing is ready for review.</p>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <x-secondary-button type="submit" name="submit_for_review" value="1">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        <span>{{ __('Submit for admin review') }}</span>
                    </x-secondary-button>
                    <x-primary-button>
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 10 17l9-10" />
                        </svg>
                        <span>{{ $service->exists ? __('Save changes') : __('Save draft') }}</span>
                    </x-primary-button>
                </div>
            </div>
        </div>

        <aside class="border-t border-border/70 bg-muted/35 p-5 sm:p-6 lg:sticky lg:top-28 lg:h-fit lg:border-l lg:border-t-0 lg:p-8">
            <div class="space-y-6">
                <div class="rounded-[1.5rem] border border-white/70 bg-white/85 p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary/80">Listing health</p>
                    <h3 class="mt-3 text-lg font-semibold text-foreground">{{ $service->exists ? 'Keep this service review-ready' : 'Shape a strong first draft' }}</h3>
                    <p class="mt-2 text-sm leading-6 text-muted-foreground">{{ $service->exists ? 'Any major update should keep pricing, coverage, and operations aligned so approval remains smooth.' : 'Strong details here reduce back-and-forth later and make it easier to publish quickly once approved.' }}</p>
                </div>

                <div class="rounded-[1.5rem] border border-white/70 bg-white/85 p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <h3 class="text-sm font-semibold uppercase tracking-[0.24em] text-muted-foreground">Current status</h3>
                        <x-status-badge :status="$service->approval_status" />
                    </div>
                    <div class="mt-4 space-y-3 text-sm text-muted-foreground">
                        <p class="rounded-2xl bg-background/80 px-4 py-3">Drafts can be edited freely before submission.</p>
                        <p class="rounded-2xl bg-background/80 px-4 py-3">Pending services are waiting on admin review.</p>
                        <p class="rounded-2xl bg-background/80 px-4 py-3">Approved services can be published from your services list.</p>
                    </div>
                </div>

                <div class="rounded-[1.5rem] border border-white/70 bg-white/85 p-5 shadow-sm">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.24em] text-muted-foreground">What good listings include</h3>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary">1</span>
                            <p class="text-sm text-foreground">A specific title and category that matches the actual service.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary">2</span>
                            <p class="text-sm text-foreground">Clear pricing or an explicit note that pricing is quote-based.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary">3</span>
                            <p class="text-sm text-foreground">Operational details that explain collection, scheduling, and capacity.</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</form>
