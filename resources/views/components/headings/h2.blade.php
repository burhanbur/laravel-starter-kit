@props(['class' => ''])

<h2 {{ $attributes->merge(['class' => 'kt-portlet__head-title ' . $class]) }}>
    {{ $slot }}
</h2>
