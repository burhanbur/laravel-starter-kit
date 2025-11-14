@props([
    'href' => '#',
    'target' => '_self',
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
    
    $finalHref = $disabled ? 'javascript:void(0)' : $href;
    $disabledClass = $disabled ? 'disabled' : '';
@endphp

<a href="{{ $finalHref }}" target="{{ $target }}" {{ $attributes->merge(['class' => trim("{$classes} {$disabledClass}")]) }}>
    {{ $slot }}
</a>
