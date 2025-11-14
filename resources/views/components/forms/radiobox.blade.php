@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'value' => '',
    'checked' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'autofocus' => false,
    'help' => '',
    'addClass' => '',
    'radioClass' => '',
    'labelClass' => '',
    'wrapperClass' => '',
])

@php
    $radioId = $id ?: $name . '_' . $value;
    $baseWrapperClass = 'kt-radio-inline';
    if ($wrapperClass) {
        $baseWrapperClass .= ' ' . $wrapperClass;
    }
    
    $baseLabelClass = 'kt-radio';
    if ($labelClass) {
        $baseLabelClass .= ' ' . $labelClass;
    }
@endphp

<div class="{{ $baseWrapperClass }}">
    <label class="{{ $baseLabelClass }}">
        <input 
            type="radio" 
            name="{{ $name }}" 
            id="{{ $radioId }}"
            value="{{ $value }}"
            {{ old($name, $checked) == $value ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $autofocus ? 'autofocus' : '' }}
            {{ $attributes->merge(['class' => $radioClass ?: '']) }}
        >
        {{ $label }}
        <span></span>
    </label>
    @if($help)
        <small class="form-text text-muted d-block">{{ $help }}</small>
    @endif
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
