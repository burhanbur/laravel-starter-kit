@php
    $activeTheme = config('theme.active', 'metronic');
    $layoutView = config("theme.themes.{$activeTheme}.view", 'layouts.themes.metronic.layout');

    if (!view()->exists($layoutView)) {
        $layoutView = 'layouts.themes.metronic.layout';
    }
@endphp

@include($layoutView)
