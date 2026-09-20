<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none text-reset">
                <span class="fs-2 me-2">⚡</span>
                <span class="fw-bold fs-3">{{ config('app.alias', config('app.name')) }}</span>
            </a>
        </h1>

        <!-- Mobile user dropdown & theme switcher -->
        <div class="navbar-nav flex-row d-lg-none align-items-center">
            <div class="nav-item me-3">
                <a href="javascript:void(0);" class="nav-link px-0 hide-theme-dark text-reset" title="Mode Gelap" onclick="setTablerTheme('dark')">
                    <i class="ti ti-moon fs-2"></i>
                </a>
                <a href="javascript:void(0);" class="nav-link px-0 hide-theme-light text-reset" title="Mode Terang" onclick="setTablerTheme('light')">
                    <i class="ti ti-sun fs-2"></i>
                </a>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <div class="dropdown-item-text text-muted small">{{ auth()->user()->email ?? '' }}</div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item text-danger"><i class="ti ti-logout me-2"></i> Logout</a>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item @if(in_array(Request::segment(1), ['', 'dashboard'])) active @endif">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-dashboard fs-2"></i>
                        </span>
                        <span class="nav-link-title">Dashboard</span>
                    </a>
                </li>

                @foreach($menus['sidebar'] as $key => $menu)
                    @if (empty($menu->children) || count($menu->children) == 0)
                        <li class="nav-item @if(!empty($menu->is_active)) active @endif">
                            <a class="nav-link" href="{{ $menu->route_name ? route($menu->route_name) : 'javascript:void(0);' }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="{{ $menu->icon ?? 'ti ti-point' }} fs-2"></i>
                                </span>
                                <span class="nav-link-title">{{ $menu->name }}</span>
                            </a>
                        </li>
                    @else
                        @php
                            $hasActiveChild = !empty($menu->is_active);
                        @endphp
                        <li class="nav-item dropdown @if($hasActiveChild) active @endif">
                            <a class="nav-link dropdown-toggle @if($hasActiveChild) show @endif" href="#menu-{{ $key }}" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ $hasActiveChild ? 'true' : 'false' }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="{{ $menu->icon ?? 'ti ti-folder' }} fs-2"></i>
                                </span>
                                <span class="nav-link-title">{{ $menu->name }}</span>
                            </a>
                            <div class="dropdown-menu @if($hasActiveChild) show @endif">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        @foreach ($menu->children as $subMenu)
                                            <a class="dropdown-item @if(!empty($subMenu->is_active)) active @endif" href="{{ $subMenu->route_name ? route($subMenu->route_name) : 'javascript:void(0);' }}">
                                                {{ $subMenu->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</aside>
