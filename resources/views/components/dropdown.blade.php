@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'p-1'])

@php
    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        default => 'ltr:origin-top-right rtl:origin-top-left end-0',
    };

    $width = match ($width) {
        '48' => 'w-48',
        '56' => 'w-56',
        default => $width,
    };
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
        class="absolute z-50 mt-2 {{ $width }} rounded-2xl border border-border/50 bg-card/60 backdrop-blur-xl shadow-lg hover:shadow-xl shadow-black/5 dark:shadow-black/20 ring-1 ring-black/5 dark:ring-white/5 {{ $alignmentClasses }}"
        style="display: none;" @click="open = false">
        <div class="rounded-2xl bg-card {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>