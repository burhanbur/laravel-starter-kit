@props([
    'type' => 'border',
    'size' => '',
    'color' => 'primary',
    'centered' => false,
])

@php
    $spinnerClass = 'spinner-' . $type;
    if ($size) {
        $spinnerClass .= ' spinner-' . $type . '-' . $size;
    }
    $spinnerClass .= ' text-' . $color;
@endphp

@if($centered)
<div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
    <div {{ $attributes->merge(['class' => $spinnerClass]) }} role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
@else
<div {{ $attributes->merge(['class' => $spinnerClass]) }} role="status">
    <span class="sr-only">Loading...</span>
</div>
@endif
