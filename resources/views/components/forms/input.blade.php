@props([
    'type' => 'text',
    'name' => '',
    'id' => '',
    'label' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'autocomplete' => '',
    'min' => '',
    'max' => '',
    'step' => '',
    'minlength' => '',
    'maxlength' => '',
    'pattern' => '',
    'help' => '',
    'addClass' => '',
    'inputClass' => '',
    'labelClass' => '',
    'wrapperClass' => '',
])

@php
    $inputId = $id ?: $name;
    $baseClass = 'form-control';
    if ($inputClass) {
        $baseClass .= ' ' . $inputClass;
    }
    if ($addClass) {
        $baseClass .= ' ' . $addClass;
    }
    if ($errors->has($name)) {
        $baseClass .= ' is-invalid';
    }
@endphp

@if($label)
<div class="form-group {{ $wrapperClass }}">
    <label for="{{ $inputId }}" class="{{ $labelClass }}">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $inputId }}"
        value="{{ old($name, $value) }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($min) min="{{ $min }}" @endif
        @if($max) max="{{ $max }}" @endif
        @if($step) step="{{ $step }}" @endif
        @if($minlength) minlength="{{ $minlength }}" @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        @if($pattern) pattern="{{ $pattern }}" @endif
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
        {{ $attributes->merge(['class' => $baseClass]) }}
    >
    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@else
<input 
    type="{{ $type }}" 
    name="{{ $name }}" 
    id="{{ $inputId }}"
    value="{{ old($name, $value) }}"
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
    @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
    @if($min) min="{{ $min }}" @endif
    @if($max) max="{{ $max }}" @endif
    @if($step) step="{{ $step }}" @endif
    @if($minlength) minlength="{{ $minlength }}" @endif
    @if($maxlength) maxlength="{{ $maxlength }}" @endif
    @if($pattern) pattern="{{ $pattern }}" @endif
    {{ $required ? 'required' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $autofocus ? 'autofocus' : '' }}
    {{ $attributes->merge(['class' => $baseClass]) }}
>
@if($help)
    <small class="form-text text-muted">{{ $help }}</small>
@endif
@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
@endif