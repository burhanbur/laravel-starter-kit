<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo py-3 px-4 d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="app-brand-link d-flex align-items-center text-decoration-none">
            <span class="app-brand-logo demo me-2 fs-2 text-primary">
                <i class="bx bxs-layer"></i>
            </span>
            <span class="app-brand-text demo menu-text fw-bold fs-4 text-dark">{{ config('app.alias', config('app.name')) }}</span>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <ul class="menu-inner py-1 list-unstyled">
        <li class="menu-item @if(in_array(Request::segment(1), ['', 'dashboard'])) active @endif">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div class="menu-text">Dashboard</div>
            </a>
        </li>

        @foreach($menus['sidebar'] as $key => $menu)
            @if (empty($menu->children) || count($menu->children) == 0)
                <li class="menu-item @if(!empty($menu->is_active)) active @endif">
                    <a href="{{ $menu->route_name ? route($menu->route_name) : 'javascript:void(0);' }}" class="menu-link">
                        <i class="menu-icon tf-icons {{ $menu->icon ? (str_contains($menu->icon, 'bx') ? $menu->icon : 'bx bx-chevron-right') : 'bx bx-chevron-right' }}"></i>
                        <div class="menu-text">{{ $menu->name }}</div>
                    </a>
                </li>
            @else
                @php
                    $hasActiveChild = !empty($menu->is_active);
                @endphp
                <li class="menu-item has-sub @if($hasActiveChild) active open @endif">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons {{ $menu->icon ? (str_contains($menu->icon, 'bx') ? $menu->icon : 'bx bx-folder') : 'bx bx-folder' }}"></i>
                        <div class="menu-text">{{ $menu->name }}</div>
                        <i class="bx bx-chevron-right menu-chevron ms-auto"></i>
                    </a>
                    <ul class="menu-sub list-unstyled ps-4">
                        @foreach ($menu->children as $subMenu)
                            <li class="menu-item @if(!empty($subMenu->is_active)) active @endif">
                                <a href="{{ $subMenu->route_name ? route($subMenu->route_name) : 'javascript:void(0);' }}" class="menu-link">
                                    <div class="menu-text">{{ $subMenu->name }}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</aside>
