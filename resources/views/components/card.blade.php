@props([
    'title' => '',
    'flush' => false,
])

@php
    $portletClass = 'kt-portlet';
    if ($flush) {
        $portletClass .= ' kt-portlet--height-fluid';
    }
@endphp

<div {{ $attributes->merge(['class' => $portletClass]) }}>
    @if($title || isset($actions))
        <div class="kt-portlet__head">
            @if($title)
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ $title }}
                    </h3>
                </div>
            @endif
            
            @isset($actions)
                <div class="kt-portlet__head-toolbar">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif
    
    <div class="kt-portlet__body">
        {{ $slot }}
    </div>
    
    @isset($footer)
        <div class="kt-portlet__foot">
            {{ $footer }}
        </div>
    @endisset
</div>
