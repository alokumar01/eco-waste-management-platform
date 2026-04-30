<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-border bg-card backdrop-blur-2xl">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-19 items-center justify-between gap-4">
            <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                <div class="shrink-0">
                    <a href="{{ Auth::check() ? route('dashboard') : url('/') }}" class="flex items-center">
                        <span>
                            <x-application-logo-landscape class="block h-14 w-auto fill-current" />
                        </span>

                    </a>
                </div>

                <div class="hidden items-center gap-2 sm:flex">
                    <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M7 12h10M10 17h4" />
                        </svg>
                        <span>{{ __('Services') }}</span>
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 13h7V4H4v9Zm9 7h7v-5h-7v5Zm0-9h7V4h-7v7ZM4 20h7v-5H4v5Z" />
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </x-nav-link>
                        @if (Auth::user()->isProvider())
                            <x-nav-link :href="route('provider.dashboard')" :active="request()->routeIs('provider.dashboard')">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3l7 4v5c0 4.25-2.55 8.24-7 9-4.45-.76-7-4.75-7-9V7l7-4Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.5 12 1.7 1.7 3.8-4.2" />
                                </svg>
                                <span>{{ __('Provider Hub') }}</span>
                            </x-nav-link>
                            <x-nav-link :href="route('provider.services.index')"
                                :active="request()->routeIs('provider.services.*')">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h9l3 3v13H6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 4v4h4M9 12h6M9 16h6" />
                                </svg>
                                <span>{{ __('My Services') }}</span>
                            </x-nav-link>
                        @endif
                        @if (Auth::user()->isAdmin())
                            <x-nav-link :href="route('admin.services.review')" :active="request()->routeIs('admin.*')">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3l8 3v6c0 5-3.5 8.5-8 9-4.5-.5-8-4-8-9V6l8-3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M12 9v6" />
                                </svg>
                                <span>{{ __('Admin Review') }}</span>
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden items-center gap-3 sm:flex sm:ms-6">
                @auth
                    <span
                        class="inline-flex items-center rounded-full border border-primary/15 bg-primary/10 px-3 py-0.5 text-xs font-semibold uppercase tracking-[0.22em] text-primary">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>

                    <x-dropdown align="right" width="56" contentClasses="p-1.5 flex flex-col gap-1">
                        <x-slot name="trigger">
                            <button x-bind:aria-expanded="open.toString()"
                                class="group inline-flex items-center gap-3 rounded-full border border-border bg-card/85 px-2 py-1 text-left text-sm font-semibold leading-5 text-foreground shadow-sm backdrop-blur-md transition-all cursor-pointer hover:bg-card hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <span
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-sm font-bold text-primary">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden sm:block">
                                    <span
                                        class="block max-w-40 truncate text-sm text-foreground">{{ Auth::user()->name }}</span>
                                    <span
                                        class="block max-w-40 truncate text-xs font-medium text-muted-foreground">{{ Auth::user()->email }}</span>
                                </span>

                                <div
                                    class="text-muted-foreground transition-transform duration-200 group-hover:text-foreground group-aria-expanded:rotate-180">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- User Info Header -->
                            <div class="px-4 py-3 border-b border-border/40 mb-1">
                                <p class="text-sm font-medium leading-none text-foreground">{{ Auth::user()->name }}</p>
                                <p class="text-xs leading-none text-muted-foreground mt-1">{{ Auth::user()->email }}</p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <div class="h-px bg-border/40 my-1"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    class="flex items-center gap-2 text-destructive hover:bg-destructive/10 hover:text-destructive focus:bg-destructive/10 focus:text-destructive"
                                    onclick="event.preventDefault();
                                                                                                                                        this.closest('form').submit();">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a class="text-sm font-semibold text-muted-foreground transition hover:text-foreground"
                            href="{{ route('login') }}">Log in</a>
                        <a href="{{ route('register') }}">
                            <x-primary-button type="button">Join GreenLoop</x-primary-button>
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-2xl border border-white/70 bg-card/85 p-2.5 text-muted-foreground shadow-sm transition hover:bg-card hover:text-foreground focus:bg-card focus:text-foreground focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden pb-4 sm:hidden">
        <div
            class="mt-2 rounded-[1.75rem] border border-white/70 bg-card/90 p-3 shadow-[0_24px_80px_-32px_rgba(17,24,39,0.45)] backdrop-blur-xl">
            <div class="space-y-2">
                <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">
                    <span class="flex items-center gap-3">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M7 12h10M10 17h4" />
                        </svg>
                        <span>{{ __('Services') }}</span>
                    </span>
                </x-responsive-nav-link>
                @auth
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <span class="flex items-center gap-3">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 13h7V4H4v9Zm9 7h7v-5h-7v5Zm0-9h7V4h-7v7ZM4 20h7v-5H4v5Z" />
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </span>
                    </x-responsive-nav-link>
                    @if (Auth::user()->isProvider())
                        <x-responsive-nav-link :href="route('provider.dashboard')"
                            :active="request()->routeIs('provider.dashboard')">
                            <span class="flex items-center gap-3">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3l7 4v5c0 4.25-2.55 8.24-7 9-4.45-.76-7-4.75-7-9V7l7-4Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.5 12 1.7 1.7 3.8-4.2" />
                                </svg>
                                <span>{{ __('Provider Hub') }}</span>
                            </span>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('provider.services.index')"
                            :active="request()->routeIs('provider.services.*')">
                            <span class="flex items-center gap-3">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h9l3 3v13H6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 4v4h4M9 12h6M9 16h6" />
                                </svg>
                                <span>{{ __('My Services') }}</span>
                            </span>
                        </x-responsive-nav-link>
                    @endif
                    @if (Auth::user()->isAdmin())
                        <x-responsive-nav-link :href="route('admin.services.review')" :active="request()->routeIs('admin.*')">
                            <span class="flex items-center gap-3">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3l8 3v6c0 5-3.5 8.5-8 9-4.5-.5-8-4-8-9V6l8-3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M12 9v6" />
                                </svg>
                                <span>{{ __('Admin Review') }}</span>
                            </span>
                        </x-responsive-nav-link>
                    @endif
                @endauth
            </div>

            <div class="mt-4 border-t border-border/70">
                @auth
                    <div class="flex items-center gap-3 rounded-2xl bg-muted/60 px-4 py-3">
                        <span
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-primary/10 text-sm font-bold text-primary">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <div class="min-w-0">
                            <div class="truncate text-base font-semibold text-foreground">{{ Auth::user()->name }}</div>
                            <div class="truncate text-sm font-medium text-muted-foreground">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-responsive-nav-link :href="route('profile.edit')">
                            <span class="flex items-center gap-3">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                <span>{{ __('Profile') }}</span>
                            </span>
                        </x-responsive-nav-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                                                                                                this.closest('form').submit();">
                                <span class="flex items-center gap-3 text-destructive">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16 17 5-5-5-5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12H9" />
                                    </svg>
                                    <span>{{ __('Log Out') }}</span>
                                </span>
                            </x-responsive-nav-link>
                        </form>
                    </div>
                @else
                    <div class="space-y-2">
                        <x-responsive-nav-link :href="route('login')">
                            {{ __('Log in') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>