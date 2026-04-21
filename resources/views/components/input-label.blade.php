@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-foreground/85']) }}>
    {{ $value ?? $slot }}
</label>
