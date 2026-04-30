@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-2xl border border-primary/20 bg-primary/10 px-4 py-3 text-start text-base font-semibold text-primary shadow-sm transition duration-200 ease-out focus:outline-none focus:ring-2 focus:ring-ring/30'
            : 'block w-full rounded-2xl border border-transparent px-4 py-3 text-start text-base font-medium text-muted-foreground transition duration-200 ease-out hover:border-border/70 hover:bg-card/80 hover:text-foreground focus:outline-none focus:ring-2 focus:ring-ring/30';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
