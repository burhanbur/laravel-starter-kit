@props([
    'type' => 'info',
    'dismissible' => false,
    'icon' => '',
    'title' => '',
])

@php
    $alertClass = 'alert alert-' . $type;
    if ($dismissible) {
        $alertClass .= ' alert-dismissible fade show';
    }
    
    $icons = [
        'success' => 'la la-check-circle',
        'danger' => 'la la-exclamation-circle',
        'warning' => 'la la-warning',
        'info' => 'la la-info-circle',
        'primary' => 'la la-info-circle',
        'secondary' => 'la la-info-circle',
    ];
    
    $defaultIcon = $icon ?: ($icons[$type] ?? 'la la-info-circle');
@endphp

<div {{ $attributes->merge(['class' => $alertClass]) }} role="alert">
    @if($dismissible)
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif
    
    @if($title || $icon !== false)
        <div class="alert-text">
            @if($icon !== false)
                <i class="{{ $defaultIcon }}"></i>
            @endif
            @if($title)
                <strong>{{ $title }}</strong>
            @endif
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</div>
