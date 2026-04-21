@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl border border-primary/25 bg-primary/10 px-4 py-3 text-sm font-medium text-primary']) }}>
        {{ $status }}
    </div>
@endif
