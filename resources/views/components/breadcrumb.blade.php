@props([
    'items' => [],
    'separator' => '',
])

<div class="kt-subheader__breadcrumbs">
    @if($separator)
        <span class="kt-subheader__breadcrumbs-separator">{{ $separator }}</span>
    @else
        <span class="kt-subheader__breadcrumbs-separator"></span>
    @endif
    
    @if(!empty($items))
        @foreach($items as $index => $item)
            @if($index > 0)
                <span class="kt-subheader__breadcrumbs-separator"></span>
            @endif
            
            @if(isset($item['url']) && $index < count($items) - 1)
                <a href="{{ $item['url'] }}" class="kt-subheader__breadcrumbs-link">
                    {{ $item['label'] }}
                </a>
            @else
                <span class="kt-subheader__breadcrumbs-link">
                    {{ $item['label'] }}
                </span>
            @endif
        @endforeach
    @else
        {{ $slot }}
    @endif
</div>
