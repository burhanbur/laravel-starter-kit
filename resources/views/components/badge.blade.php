@props([
    'type' => 'primary',
    'pill' => false,
])

@php
    $badgeClass = 'badge badge-' . $type;
    if ($pill) {
        $badgeClass .= ' badge-pill';
    }
@endphp

<span {{ $attributes->merge(['class' => $badgeClass]) }}>
    {{ $slot }}
</span>
