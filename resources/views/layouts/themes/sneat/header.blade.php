<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" id="sneatMenuToggler">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            @if(!empty($menus['topbar']))
                <div class="d-flex align-items-center">
                    @foreach ($menus['topbar'] as $menu)
                        @if (empty($menu->children) || count($menu->children) == 0)
                            <div class="nav-item me-3">
                                <a class="nav-link @if(!empty($menu->is_active)) active fw-bold text-primary @endif" href="{{ $menu->route_name ? route($menu->route_name) : 'javascript:void(0);' }}">
                                    {{ $menu->name }}
                                </a>
                            </div>
                        @else
                            <div class="nav-item dropdown me-3">
                                <a class="nav-link dropdown-toggle @if(!empty($menu->is_active) || !empty($menu->has_active_child)) active fw-bold text-primary @endif" href="javascript:void(0)" data-bs-toggle="dropdown">
                                    <i class="bx bx-cog me-1"></i>
                                    {{ $menu->name }}
                                </a>
                                <ul class="dropdown-menu shadow-sm">
                                    @foreach ($menu->children as $child)
                                        <li>
                                            <a class="dropdown-item @if(!empty($child->is_active)) active @endif" href="{{ $child->route_name ? route($child->route_name) : 'javascript:void(0);' }}">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            @if(session('impersonated_by'))
                <li class="nav-item me-3">
                    <a href="{{ route('leave-impersonate') }}" class="btn btn-sm btn-outline-warning">
                        <i class="bx bx-user-x me-1"></i> Leave Impersonation
                    </a>
                </li>
            @endif

            <!-- User Dropdown -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <span class="avatar-initial rounded-circle bg-label-primary fw-bold px-2 py-1">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </span>
                    </div>
                    <div class="d-none d-md-block ms-2 text-start">
                        <span class="fw-semibold d-block text-dark">{{ auth()->user()->name ?? 'User' }}</span>
                        <small class="text-muted">{{ auth()->user()->roles->first()->name ?? 'Member' }}</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <div class="dropdown-item py-2">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ auth()->user()->name ?? 'User' }}</span>
                                    <small class="text-muted">{{ auth()->user()->email ?? '' }}</small>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><div class="dropdown-divider"></div></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
