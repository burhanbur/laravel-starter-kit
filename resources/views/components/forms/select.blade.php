@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'options' => [],
    'selected' => '',
    'placeholder' => 'Pilih...',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'multiple' => false,
    'size' => '',
    'help' => '',
    'addClass' => '',
    'selectClass' => '',
    'labelClass' => '',
    'wrapperClass' => '',
])

@php
    $selectId = $id ?: $name;
    $baseClass = 'form-control';
    if ($selectClass) {
        $baseClass .= ' ' . $selectClass;
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
    <label for="{{ $selectId }}" class="{{ $labelClass }}">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select 
        name="{{ $name }}" 
        id="{{ $selectId }}"
        @if($size) size="{{ $size }}" @endif
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
        {{ $multiple ? 'multiple' : '' }}
        {{ $attributes->merge(['class' => $baseClass]) }}
    >
        @if($placeholder && !$multiple)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $value => $text)
            @if(is_array($selected))
                <option value="{{ $value }}" {{ in_array($value, old($name, $selected)) ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @else
                <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endif
        @endforeach
    </select>
    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@else
<select 
    name="{{ $name }}" 
    id="{{ $selectId }}"
    @if($size) size="{{ $size }}" @endif
    {{ $required ? 'required' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $autofocus ? 'autofocus' : '' }}
    {{ $multiple ? 'multiple' : '' }}
    {{ $attributes->merge(['class' => $baseClass]) }}
>
    @if($placeholder && !$multiple)
        <option value="">{{ $placeholder }}</option>
    @endif
    @foreach($options as $value => $text)
        @if(is_array($selected))
            <option value="{{ $value }}" {{ in_array($value, old($name, $selected)) ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @else
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endif
    @endforeach
</select>
@if($help)
    <small class="form-text text-muted">{{ $help }}</small>
@endif
@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
@endif
