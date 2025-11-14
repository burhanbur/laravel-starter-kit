@props(['subtitle' => ''])

<div class="kt-subheader__main">
    <h3 {{ $attributes->merge(['class' => 'kt-subheader__title']) }}>
        {{ $slot }}
    </h3>
    @if($subtitle)
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <span class="kt-subheader__desc">{{ $subtitle }}</span>
    @endif
</div>
