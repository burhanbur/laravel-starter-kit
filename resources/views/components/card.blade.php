@props([
    'title' => '',
    'flush' => false,
])

@php
    $theme = config('theme.active', 'metronic');
    $isMetronic = ($theme === 'metronic');

    $cardClass = $isMetronic 
        ? ('kt-portlet' . ($flush ? ' kt-portlet--height-fluid' : ''))
        : ('card' . ($flush ? ' card-flush' : ''));
@endphp

<div {{ $attributes->merge(['class' => $cardClass]) }}>
    @if($title || isset($actions))
        <div class="{{ $isMetronic ? 'kt-portlet__head' : 'card-header d-flex align-items-center justify-content-between' }}">
            @if($title)
                <div class="{{ $isMetronic ? 'kt-portlet__head-label' : 'card-title m-0' }}">
                    <h3 class="{{ $isMetronic ? 'kt-portlet__head-title' : 'fs-4 fw-semibold m-0' }}">
                        {{ $title }}
                    </h3>
                </div>
            @endif
            
            @isset($actions)
                <div class="{{ $isMetronic ? 'kt-portlet__head-toolbar' : 'card-actions d-flex align-items-center' }}">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif
    
    <div class="{{ $isMetronic ? 'kt-portlet__body' : 'card-body' }}">
        {{ $slot }}
    </div>
    
    @isset($footer)
        <div class="{{ $isMetronic ? 'kt-portlet__foot' : 'card-footer' }}">
            {{ $footer }}
        </div>
    @endisset
</div>

