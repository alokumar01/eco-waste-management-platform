@props(['padding' => 'p-6'])

<div {{ $attributes->merge(['class' => "rounded-[1.75rem] border border-white/60 bg-card/90 {$padding} shadow-[0_24px_80px_-32px_rgba(17,24,39,0.35)] ring-1 ring-primary/5 backdrop-blur-sm"]) }}>
    {{ $slot }}
</div>
