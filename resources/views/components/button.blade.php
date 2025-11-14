@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'block' => false,
])

@php
    $sizeClass = match($size) {
        'lg' => 'btn-lg',
        'sm' => 'btn-sm',
        'xs' => 'btn-xs',
        default => '',
    };
    
    $blockClass = $block ? 'btn-block' : '';
    
    $classes = trim("btn btn-{$variant} {$sizeClass} {$blockClass}");
@endphp

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
