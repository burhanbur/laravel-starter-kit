<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav flex-row order-md-last ms-auto">
            <!-- Dark / Light Mode Switcher -->
            <div class="d-none d-md-flex me-3">
                <div class="nav-item">
                    <a href="javascript:void(0);" class="nav-link px-0 hide-theme-dark" title="Mode Gelap" data-bs-toggle="tooltip" data-bs-placement="bottom" onclick="setTablerTheme('dark')">
                        <i class="ti ti-moon fs-2"></i>
                    </a>
                    <a href="javascript:void(0);" class="nav-link px-0 hide-theme-light" title="Mode Terang" data-bs-toggle="tooltip" data-bs-placement="bottom" onclick="setTablerTheme('light')">
                        <i class="ti ti-sun fs-2"></i>
                    </a>
                </div>
            </div>

            @if(session('impersonated_by'))
                <div class="nav-item me-3">
                    <a href="{{ route('leave-impersonate') }}" class="btn btn-sm btn-outline-warning">
                        <i class="ti ti-user-x me-1"></i> Leave Impersonation
                    </a>
                </div>
            @endif

            <!-- User Menu -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm bg-primary text-white rounded">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->name ?? 'User' }}</div>
                        <div class="mt-1 small text-muted">{{ auth()->user()->roles->first()->name ?? 'Member' }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <div class="dropdown-item-text text-muted small">
                        Signed in as <strong>{{ auth()->user()->email ?? '' }}</strong>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item text-danger">
                        <i class="ti ti-logout me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbar-menu">
            @if(!empty($menus['topbar']))
                <ul class="navbar-nav">
                    @foreach ($menus['topbar'] as $menu)
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
                            <li class="nav-item dropdown @if(!empty($menu->is_active) || !empty($menu->has_active_child)) active @endif">
                                <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-settings fs-2"></i>
                                    </span>
                                    <span class="nav-link-title">{{ $menu->name }}</span>
                                </a>
                                <div class="dropdown-menu">
                                    @foreach ($menu->children as $child)
                                        <a class="dropdown-item @if(!empty($child->is_active)) active @endif" href="{{ $child->route_name ? route($child->route_name) : 'javascript:void(0);' }}">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</header>
