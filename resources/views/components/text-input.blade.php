@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full border border-border bg-input/80 text-foreground placeholder:text-muted-foreground/70 rounded-xl shadow-sm px-3 py-2.5 transition duration-200 focus:border-ring focus:ring-2 focus:ring-ring/30 focus:outline-none disabled:cursor-not-allowed disabled:opacity-60']) }}>