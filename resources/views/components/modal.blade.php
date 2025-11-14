@props([
    'id' => 'modal',
    'title' => '',
    'size' => '', // '', 'sm', 'lg', 'xl'
    'centered' => false,
    'scrollable' => false,
    'static' => false,
])

@php
    $sizeClass = $size ? 'modal-' . $size : '';
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label" aria-hidden="true" {{ $static ? 'data-backdrop="static"' : '' }}>
    <div class="modal-dialog {{ $sizeClass }} {{ $centered ? 'modal-dialog-centered' : '' }} {{ $scrollable ? 'modal-dialog-scrollable' : '' }}" role="document">
        <div class="modal-content">
            @if($title)
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="modal-body">
                {{ $slot }}
            </div>
            @isset($footer)
            <div class="modal-footer">
                {{ $footer }}
            </div>
            @endisset
        </div>
    </div>
</div>
