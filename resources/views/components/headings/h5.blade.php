@props(['class' => ''])

<h5 {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</h5>
