@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-sm font-semibold leading-5 text-primary shadow-sm shadow-primary/10 transition duration-200 ease-out focus:outline-none focus:ring-2 focus:ring-ring/30'
        : 'inline-flex items-center gap-2 rounded-full border border-transparent px-4 py-2 text-sm font-medium leading-5 text-muted-foreground transition duration-200 ease-out hover:border-border/80 hover:bg-card/80 hover:text-foreground hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-ring/30';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
