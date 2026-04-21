<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Eco Waste Management Platform</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen bg-[radial-gradient(circle_at_top_left,#d9f3d8,transparent_35%),radial-gradient(circle_at_bottom_right,#fde1c6,transparent_32%),linear-gradient(160deg,#f4faee,#ecf5e7)] text-emerald-950 antialiased">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-700">Eco Waste Management</p>
                <h1 class="mt-2 text-3xl font-black leading-tight sm:text-4xl">Composting education and services in one
                    simple platform</h1>
            </div>
            <span
                class="rounded-full border border-emerald-200 bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-[0.12em] text-emerald-700">
                Setup UI Only
            </span>
        </header>

        <section class="grid gap-5 lg:grid-cols-[1.35fr_1fr]">
            <article class="rounded-3xl border border-emerald-200 bg-white/85 p-6 shadow-sm backdrop-blur">
                <p
                    class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700">
                    Project introduction</p>
                <h2 class="mt-4 text-2xl font-extrabold leading-tight">A digital hub to promote cleaner neighborhoods
                </h2>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-800/90 sm:text-base">
                    This platform will help people discover composting guidance and waste-management services.
                    Administrators verify participants, service proposers publish offerings, and end-users explore
                    options based on location and composting needs.
                </p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="#flow"
                        class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">View
                        platform flow</a>
                    <a href="#filters"
                        class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">See
                        filter preview</a>
                </div>
            </article>

            <aside class="rounded-3xl border border-amber-200 bg-amber-50/90 p-6 shadow-sm">
                <h3 class="text-lg font-bold">Current scope</h3>
                <ul class="mt-3 space-y-2 text-sm leading-6 text-amber-900">
                    <li>Static informational UI only</li>
                    <li>No login or registration screens</li>
                    <li>No database actions or API calls</li>
                    <li>Structure prepared for later backend integration</li>
                </ul>
            </aside>
        </section>

        <section class="mt-6 grid gap-4 md:grid-cols-3">
            <article class="rounded-2xl border border-emerald-200 bg-white/85 p-5">
                <h3 class="text-base font-bold">Administrators</h3>
                <p class="mt-2 text-sm leading-6 text-emerald-800/90">Review and validate composting experts and service
                    providers before listings become trusted and visible.</p>
            </article>
            <article class="rounded-2xl border border-emerald-200 bg-white/85 p-5">
                <h3 class="text-base font-bold">Service Proposers</h3>
                <p class="mt-2 text-sm leading-6 text-emerald-800/90">List composting services, highlight coverage area,
                    and communicate whether support is pickup, on-site, or educational.</p>
            </article>
            <article class="rounded-2xl border border-emerald-200 bg-white/85 p-5">
                <h3 class="text-base font-bold">End Users</h3>
                <p class="mt-2 text-sm leading-6 text-emerald-800/90">Find suitable providers quickly by matching
                    location, service type, and composting requirements.</p>
            </article>
        </section>

        <section id="flow" class="mt-6 rounded-3xl border border-emerald-200 bg-white/85 p-6 shadow-sm">
            <h2 class="text-xl font-extrabold">Simple platform flow</h2>
            <div class="mt-4 grid gap-3">
                <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 p-4 text-sm text-emerald-900"><span
                        class="mr-2 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 font-bold text-white">1</span>Participants
                    submit profile details for composting expertise or service provisioning.</div>
                <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 p-4 text-sm text-emerald-900"><span
                        class="mr-2 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 font-bold text-white">2</span>Administrators
                    validate participants to maintain quality and trust.</div>
                <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 p-4 text-sm text-emerald-900"><span
                        class="mr-2 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 font-bold text-white">3</span>Approved
                    proposers publish composting and waste-management service listings.</div>
                <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 p-4 text-sm text-emerald-900"><span
                        class="mr-2 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 font-bold text-white">4</span>End-users
                    browse and filter services based on real-world needs and location.</div>
            </div>
        </section>

        <section id="filters" class="mt-6 rounded-3xl border border-emerald-200 bg-white/85 p-6 shadow-sm">
            <h2 class="text-xl font-extrabold">Service filter preview</h2>
            <p class="mt-2 text-sm text-emerald-800/90">Static UI only for planning. Search behavior will be added in
                future phases.</p>

            <div class="mt-4 grid gap-4 md:grid-cols-3">
                <label class="block text-sm font-semibold text-emerald-800">
                    Location
                    <input type="text" placeholder="e.g. Pune, Ward 7"
                        class="mt-2 w-full rounded-xl border border-emerald-200 bg-white px-3 py-2 text-sm outline-none ring-emerald-500 placeholder:text-emerald-400 focus:ring-2">
                </label>
                <label class="block text-sm font-semibold text-emerald-800">
                    Service Type
                    <select
                        class="mt-2 w-full rounded-xl border border-emerald-200 bg-white px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2">
                        <option>Waste Pickup</option>
                        <option>On-site Composting</option>
                        <option>Training Workshop</option>
                    </select>
                </label>
                <label class="block text-sm font-semibold text-emerald-800">
                    Composting Need
                    <select
                        class="mt-2 w-full rounded-xl border border-emerald-200 bg-white px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2">
                        <option>Home Organic Waste</option>
                        <option>Community Program</option>
                        <option>Commercial/Bulk Waste</option>
                    </select>
                </label>
            </div>

            <div
                class="mt-4 rounded-xl border border-dashed border-emerald-300 bg-emerald-50 p-3 text-sm text-emerald-800">
                Placeholder section: service cards and results will be connected after backend setup.
            </div>
        </section>

        <footer class="mt-8 text-center text-xs font-semibold uppercase tracking-[0.11em] text-emerald-700/80">
            Eco Waste Management Platform - setup stage UI
        </footer>
    </div>
</body>

</html>