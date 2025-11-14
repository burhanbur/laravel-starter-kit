@props([
    'striped' => false,
    'bordered' => false,
    'hover' => true,
    'responsive' => true,
])

@php
    $tableClass = 'table';
    if ($striped) {
        $tableClass .= ' table-striped';
    }
    if ($bordered) {
        $tableClass .= ' table-bordered';
    }
    if ($hover) {
        $tableClass .= ' table-hover';
    }
@endphp

@if($responsive)
<div class="table-responsive">
    <table {{ $attributes->merge(['class' => $tableClass]) }}>
        @isset($thead)
            <thead>
                {{ $thead }}
            </thead>
        @endisset
        
        <tbody>
            {{ $slot }}
        </tbody>
        
        @isset($tfoot)
            <tfoot>
                {{ $tfoot }}
            </tfoot>
        @endisset
    </table>
</div>
@else
<table {{ $attributes->merge(['class' => $tableClass]) }}>
    @isset($thead)
        <thead>
            {{ $thead }}
        </thead>
    @endisset
    
    <tbody>
        {{ $slot }}
    </tbody>
    
    @isset($tfoot)
        <tfoot>
            {{ $tfoot }}
        </tfoot>
    @endisset
</table>
@endif
