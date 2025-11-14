        <!-- begin:: Aside -->
		<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
		<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

			<!-- begin:: Aside -->
			<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
				<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
					<ul class="kt-menu__nav ">
						<li class="kt-menu__item  @if(Request::segment(2) == 'main') kt-menu__item--active @endif" aria-haspopup="true">
							<a href="{{ route('main') }}" class="kt-menu__link ">
								<i class="kt-menu__link-icon flaticon2-dashboard"></i>
								<span class="kt-menu__link-text">Dashboard</span>
							</a>
						</li>

						<li class="kt-menu__item  @if(Request::is('component*')) kt-menu__item--active @endif" aria-haspopup="true">
							<a href="{{ route('components.showcase') }}" class="kt-menu__link ">
								<i class="kt-menu__link-icon flaticon2-layers-1"></i>
								<span class="kt-menu__link-text">Komponen UI</span>
							</a>
						</li>

						<li class="kt-menu__item @if(\Request::segment(2) == 'sub-menu') kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">								
							<a href="javascript::void(0);" class="kt-menu__link kt-menu__toggle">
								<i class="kt-menu__link-icon flaticon2-menu"></i>
								<span class="kt-menu__link-text">Menu Contoh</span>
								<i class="kt-menu__ver-arrow la la-angle-right"></i>
							</a>

							<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
										<span class="kt-menu__link">
											<span class="kt-menu__link-text">Menu Contoh</span>
										</span>
									</li>

									<li class="kt-menu__item @if(\Request::segment(2) == 'pengunduran-diri' && \Request::segment(3) == 'pendaftaran') kt-menu__item--active @endif" aria-haspopup="true">
										<a href="{{ null }}" class="kt-menu__link ">
											<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
											<span class="kt-menu__link-text">Level 1</span>
										</a>
									</li>

									<li class="kt-menu__item @if(\Request::segment(2) == 'pengunduran-diri' && \Request::segment(3) == 'daftar-ulang') kt-menu__item--active @endif" aria-haspopup="true">
										<a href="{{ null }}" class="kt-menu__link ">
											<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
											<span class="kt-menu__link-text">Level 1</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>

			<!-- end:: Aside Menu -->
		</div>
		<!-- end:: Aside -->