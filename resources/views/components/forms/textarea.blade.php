@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'value' => '',
    'placeholder' => '',
    'rows' => 3,
    'cols' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'minlength' => '',
    'maxlength' => '',
    'help' => '',
    'addClass' => '',
    'textareaClass' => '',
    'labelClass' => '',
    'wrapperClass' => '',
])

@php
    $textareaId = $id ?: $name;
    $baseClass = 'form-control';
    if ($textareaClass) {
        $baseClass .= ' ' . $textareaClass;
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
    <label for="{{ $textareaId }}" class="{{ $labelClass }}">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <textarea 
        name="{{ $name }}" 
        id="{{ $textareaId }}"
        rows="{{ $rows }}"
        @if($cols) cols="{{ $cols }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($minlength) minlength="{{ $minlength }}" @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
        {{ $attributes->merge(['class' => $baseClass]) }}
    >{{ old($name, $value) }}</textarea>
    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@else
<textarea 
    name="{{ $name }}" 
    id="{{ $textareaId }}"
    rows="{{ $rows }}"
    @if($cols) cols="{{ $cols }}" @endif
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
    @if($minlength) minlength="{{ $minlength }}" @endif
    @if($maxlength) maxlength="{{ $maxlength }}" @endif
    {{ $required ? 'required' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $autofocus ? 'autofocus' : '' }}
    {{ $attributes->merge(['class' => $baseClass]) }}
>{{ old($name, $value) }}</textarea>
@if($help)
    <small class="form-text text-muted">{{ $help }}</small>
@endif
@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
@endif
