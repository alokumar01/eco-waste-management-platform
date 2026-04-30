@props(['status'])

@php
    $classes = match ($status) {
        \App\Models\CompostingService::STATUS_APPROVED, \App\Models\User::PROVIDER_APPROVED => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        \App\Models\CompostingService::STATUS_PENDING, \App\Models\User::PROVIDER_PENDING => 'border-amber-200 bg-amber-50 text-amber-700',
        \App\Models\CompostingService::STATUS_REJECTED, \App\Models\User::PROVIDER_REJECTED => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-slate-200 bg-slate-50 text-slate-700',
    };

    $label = ucfirst(str_replace('_', ' ', (string) $status));
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {$classes}"]) }}>
    {{ $label }}
</span>
