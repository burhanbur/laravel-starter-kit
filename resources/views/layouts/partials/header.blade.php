                <!-- begin:: Header -->
				<div id="kt_header" class="kt-header kt-grid kt-grid--ver  kt-header--fixed ">
					<!-- begin:: Aside -->
					<div class="kt-header__brand kt-grid__item  " id="kt_header_brand" style="background-color:#f8f8f8">
						<div class="kt-header__brand-logo">
							<a href="{{ url('/') }}">
								<img alt="{{ config('app.name') }}" src="{{ asset('assets/images/sidebar-logo.png') }}" width="120px" />
							</a>
						</div>
					</div>
					<!-- end:: Aside -->

					<!-- begin:: Title -->
					<h3 class="kt-header__title kt-grid__item" style="color: #FFF; font-weight: bold;">
						{{ config('app.name') }}
					</h3>
					<!-- end:: Title -->

					<!-- begin: Header Menu -->
					<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
					<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
						<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
							<ul class="kt-menu__nav ">
								<li class="kt-menu__item  @if(in_array(\Request::segment(1), ['', 'dashboard'])) kt-menu__item--active  @endif" aria-haspopup="true">
									<a href="{{ route('dashboard') }}" class="kt-menu__link ">
										<span class="kt-menu__link-icon">
											<i class="flaticon2-dashboard"></i>
										</span>
										<span class="kt-menu__link-text">Dashboard</span>
									</a>
								</li>

								@foreach ($menus['topbar'] as $key => $menu)
									@if (empty($menu->children) || count($menu->children) == 0)
										{{-- Standalone menu without children --}}
										<li class="kt-menu__item  @if(Request::route()->getName() == $menu->route_name) kt-menu__item--active  @endif" aria-haspopup="true">
											<a href="{{ $menu->route_name ? route($menu->route_name) : 'javascript:void(0);' }}" class="kt-menu__link ">
												<span class="kt-menu__link-icon">
													<i class="{{ $menu->icon ?? 'fa fa-dot-circle' }}"></i>
												</span>
												<span class="kt-menu__link-text">{{ $menu->name }}</span>
											</a>
										</li>
									@else
										{{-- Parent menu with children --}}
										@php
											$hasActiveChild = false;
											foreach ($menu->children as $child) {
												if (Request::route()->getName() == $child->route_name) {
													$hasActiveChild = true;
													break;
												}
											}
										@endphp
										<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel @if($hasActiveChild || Request::route()->getName() == $menu->route_name) kt-menu__item--active kt-menu__item--here @endif" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
											<a href="javascript:void(0);" class="kt-menu__link kt-menu__toggle">
												<span class="kt-menu__link-icon">
													<i class="{{ $menu->icon ?? 'flaticon2-menu' }}"></i>
												</span>
												<span class="kt-menu__link-text">{{ $menu->name }}</span>
												<i class="kt-menu__hor-arrow la la-angle-down"></i>
												<i class="kt-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
												<ul class="kt-menu__subnav">
													@foreach ($menu->children as $subMenu)
														<li class="kt-menu__item @if(Request::route()->getName() == $subMenu->route_name) kt-menu__item--active @endif" aria-haspopup="true">
															<a href="{{ $subMenu->route_name ? route($subMenu->route_name) : 'javascript:void(0);' }}" class="kt-menu__link ">
																<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																<span class="kt-menu__link-text">{{ $subMenu->name }}</span>
															</a>
														</li>
													@endforeach
												</ul>
											</div>
										</li>
									@endif
								@endforeach

								@if(session('impersonated_by'))
									<li class="kt-menu__item" aria-haspopup="true">
										<a href="{{ route('leave-impersonate') }}" class="kt-menu__link">
											<span class="kt-menu__link-icon">
												<i class="fa fa-user-slash"></i>
											</span>
											<span class="kt-menu__link-text">Leave Impersonation</span>
										</a>
									</li>
								@endif

								{{-- <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon">
											<i class="flaticon2-settings"></i>
										</span>
										<span class="kt-menu__link-text">Konfigurasi</span>
										<i class="kt-menu__hor-arrow la la-angle-down"></i>
										<i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
										<ul class="kt-menu__subnav">
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Konfigurasi 1</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Konfigurasi 2</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Konfigurasi 3</span></a></li>
										</ul>
									</div>
								</li> --}}
							</ul>
						</div>
					</div>

					<!-- begin:: Header Topbar -->
					<div class="kt-header__topbar">

						<!--begin: User Bar -->
						<div class="kt-header__topbar-item align-items-center">
							<div class="kt-header__topbar-wrapper">
								<div class="dropdown dropdown-inline kt-margin-t-10 kt-margin-b-10">
									<button type="button" class="btn btn-icon-sm dropdown-toggle text-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="flaticon2-user"></i>
										{{ auth()->user()->name ?? 'John Doe' }}
									</button>
									<div class="dropdown-menu dropdown-menu-left" style="padding: 0;">
										<ul class="kt-nav" style="width: 200px">
											{{-- <li class="kt-nav__item">
												<a href="{{ null }}" class="kt-nav__link">
													<i class="kt-nav__link-icon la la-user kt-font-dark"></i>
													<span class="kt-nav__link-text kt-font-dark">Profil</span>
												</a>
											</li> --}}

											<li class="kt-nav__item">
												<a href="{{ route('logout') }}" class="kt-nav__link">
													<i class="kt-nav__link-icon la la-sign-out kt-font-dark"></i>
													<span class="kt-nav__link-text kt-font-dark">Logout</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!--end: User Bar -->
					</div>
					<!-- end:: Header Topbar -->
				</div>
				<!-- end:: Header -->