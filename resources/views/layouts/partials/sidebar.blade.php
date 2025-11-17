        <!-- begin:: Aside -->
		<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
		<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

			<!-- begin:: Aside -->
			<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
				<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
					<ul class="kt-menu__nav ">
						<li class="kt-menu__item  @if(in_array(Request::segment(1), ['', 'dashboard'])) kt-menu__item--active @endif" aria-haspopup="true">
							<a href="{{ route('dashboard') }}" class="kt-menu__link ">
								<i class="kt-menu__link-icon flaticon2-dashboard"></i>
								<span class="kt-menu__link-text">Dashboard</span>
							</a>
						</li>
						
						@foreach($menus['sidebar'] as $key => $menu)
							@if (empty($menu->children) || count($menu->children) == 0)
								{{-- Standalone menu without children --}}
								<li class="kt-menu__item  @if(Request::route()->getName() == $menu->route_name) kt-menu__item--active @endif" aria-haspopup="true">
									<a href="{{ $menu->route_name ? route($menu->route_name) : 'javascript:void(0);' }}" class="kt-menu__link ">
										<i class="kt-menu__link-icon {{ $menu->icon ?? 'fa fa-dot-circle' }}"></i>
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
								<li class="kt-menu__item @if($hasActiveChild || Request::route()->getName() == $menu->route_name) kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">								
									<a href="javascript:void(0);" class="kt-menu__link kt-menu__toggle">
										<i class="kt-menu__link-icon {{ $menu->icon ?? 'flaticon2-menu' }}"></i>
										<span class="kt-menu__link-text">{{ $menu->name }}</span>
										<i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>

									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
												<span class="kt-menu__link">
													<span class="kt-menu__link-text">{{ $menu->name }}</span>
												</span>
											</li>

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
					</ul>
				</div>
			</div>

			<!-- end:: Aside Menu -->
		</div>
		<!-- end:: Aside -->