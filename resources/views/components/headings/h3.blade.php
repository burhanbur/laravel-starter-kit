@props(['class' => ''])

<h3 {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</h3>
