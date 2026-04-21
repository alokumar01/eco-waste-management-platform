<div class="relative h-full overflow-hidden rounded-[1.75rem]">
    <img src="{{ asset('auth-bg.jpg') }}" alt="Lush green leaves" class="absolute inset-0 h-full w-full object-cover" />
    <div class="absolute inset-0 bg-linear-to-br from-black/60 via-black/40 to-black/60"></div>

    <div class="relative z-10 flex h-full flex-col justify-between p-8 text-white lg:p-10">
        <div class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.22em] text-muted">
            <span class="h-px w-10 bg-secondary"></span>
            <span>A greener future, together</span>
        </div>


        <x-application-logo class="h-56" />

        <div class="space-y-6">
            <div>
                <h2 class="text-5xl font-semibold leading-[0.95] tracking-tight text-white">
                    Turn Waste
                    <span class="block text-primary">into Value</span>
                </h2>
                <p class="mt-4 max-w-md text-base text-muted">
                    Join a community that cares for the planet.
                    Let&apos;s create a cleaner, greener tomorrow.
                </p>
            </div>

            <div class="grid grid-cols-3 gap-4 border-t border-secondary pt-5 text-muted">
                <div class="space-y-2 border-r border-secondary pr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-leaf">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M3.055 14.328l-.018 -.168l-.004 -.043a11 11 0 0 1 -.047 -1.12c.018 -6.29 4.29 -9.997 13 -9.997h4.014a1 1 0 0 1 1 1l-.002 2.057c-.498 8.701 -4.74 12.943 -11.998 12.943h-2.631a16 16 0 0 0 -.375 2.11a1 1 0 1 1 -1.988 -.22q .174 -1.568 .58 -2.947l-.118 -.146l-.208 -.28l-.157 -.229l-.182 -.293l-.098 -.171l-.065 -.122a6 6 0 0 1 -.397 -.941l-.072 -.237l-.085 -.327l-.057 -.268l-.043 -.242zm8.539 -4.242c-2.845 1.265 -4.854 3.13 -6.108 5.583q .098 .2 .218 .4l.185 .281l.07 .097q .12 .164 .258 .329l.197 .224h.649c1.037 -2.271 2.777 -3.946 5.343 -5.086a1 1 0 0 0 -.812 -1.828" />
                    </svg>
                    <p class="text-sm">Reduce Waste</p>
                </div>

                <div class="space-y-2 border-r border-secondary px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-recycle">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 17l-2 2l2 2" />
                        <path d="M10 19h9a2 2 0 0 0 1.75 -2.75l-.55 -1" />
                        <path d="M8.536 11l-.732 -2.732l-2.732 .732" />
                        <path d="M7.804 8.268l-4.5 7.794a2 2 0 0 0 1.506 2.89l1.141 .024" />
                        <path d="M15.464 11l2.732 .732l.732 -2.732" />
                        <path d="M18.196 11.732l-4.5 -7.794a2 2 0 0 0 -3.256 -.14l-.591 .976" />
                    </svg>
                    <p class="text-sm">Compost Smart</p>
                </div>

                <div class="space-y-2 pl-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-friends">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M5 22v-5l-1 -1v-4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4l-1 1v5" />
                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M15 22v-4h-2l2 -6a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1l2 6h-2v4" />
                    </svg>
                    <p class="text-sm">Connect Locally</p>
                </div>
            </div>
        </div>
    </div>
</div>