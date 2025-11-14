@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'autofocus' => false,
    'help' => '',
    'addClass' => '',
    'checkboxClass' => '',
    'labelClass' => '',
    'wrapperClass' => '',
])

@php
    $checkboxId = $id ?: $name;
    $baseWrapperClass = 'kt-checkbox-inline';
    if ($wrapperClass) {
        $baseWrapperClass .= ' ' . $wrapperClass;
    }
    
    $baseLabelClass = 'kt-checkbox';
    if ($labelClass) {
        $baseLabelClass .= ' ' . $labelClass;
    }
@endphp

<div class="{{ $baseWrapperClass }}">
    <label class="{{ $baseLabelClass }}">
        <input 
            type="checkbox" 
            name="{{ $name }}" 
            id="{{ $checkboxId }}"
            value="{{ $value }}"
            {{ old($name, $checked) ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $autofocus ? 'autofocus' : '' }}
            {{ $attributes->merge(['class' => $checkboxClass ?: '']) }}
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
