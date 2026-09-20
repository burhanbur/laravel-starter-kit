<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Active Application Theme
    |--------------------------------------------------------------------------
    |
    | Defines which UI template theme is used for the application layout.
    | Supported options:
    | - "metronic": Classic corporate enterprise Metronic UI
    | - "tabler": Clean modern SaaS UI with native Dark/Light mode
    | - "sneat": Fresh vibrant pastel UI with soft curves
    |
    */
    'active' => env('APP_THEME', 'metronic'),

    /*
    |--------------------------------------------------------------------------
    | Available Themes
    |--------------------------------------------------------------------------
    |
    | Registered themes and their primary layout views.
    |
    */
    'themes' => [
        'metronic' => [
            'name' => 'Metronic',
            'description' => 'Corporate Enterprise Dashboard',
            'view' => 'layouts.themes.metronic.layout',
        ],
        'tabler' => [
            'name' => 'Tabler',
            'description' => 'Modern Minimalist SaaS Dashboard',
            'view' => 'layouts.themes.tabler.layout',
        ],
        'sneat' => [
            'name' => 'Sneat',
            'description' => 'Fresh Vibrant Pastel Dashboard',
            'view' => 'layouts.themes.sneat.layout',
        ],
    ],

];
