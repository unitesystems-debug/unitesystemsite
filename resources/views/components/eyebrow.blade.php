@props(['align' => 'left'])
<div {{ $attributes->class(['flex items-center gap-2 mb-3', 'justify-center' => $align === 'center']) }}>
    <span class="h-px w-6 bg-brand-red-deep shrink-0"></span>
    <span class="text-xs font-semibold uppercase tracking-wide text-brand-red-deep">{{ $slot }}</span>
</div>
