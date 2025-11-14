@props(['class' => ''])

<h4 {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</h4>
