@props([
    'type' => 'primary',
    'pill' => false,
])

@php
    $badgeClass = 'badge badge-' . $type . ' bg-' . $type;
    if ($pill) {
        $badgeClass .= ' badge-pill rounded-pill';
    }
@endphp

<span {{ $attributes->merge(['class' => $badgeClass]) }}>
    {{ $slot }}
</span>
