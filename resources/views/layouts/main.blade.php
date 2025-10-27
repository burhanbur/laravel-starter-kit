<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Primary Meta Tags -->
	<title>@yield('title', config('app.name'))</title>
	<meta name="title" content="@yield('title', config('app.name'))">
	<meta name="description" content="@yield('description', '')">

	<!-- Icon Link & Meta -->
	{{-- <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('icons/apple-icon-57x57.png') }}">
	<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('icons/apple-icon-60x60.png') }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('icons/apple-icon-72x72.png') }}">
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('icons/apple-icon-76x76.png') }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('icons/apple-icon-114x114.png') }}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('icons/apple-icon-120x120.png') }}">
	<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('icons/apple-icon-144x144.png') }}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/apple-icon-152x152.png') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-icon-180x180.png') }}">
	<link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('icons/android-icon-192x192.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('icons/favicon-96x96.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('icons/manifest.json') }}">
	<meta name="msapplication-TileImage" content="{{ asset('icons/ms-icon-144x144.png') }}"> --}}
	<meta name="msapplication-TileColor" content="#f4f4f4">
	<meta name="theme-color" content="#f4f4f4">

	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}">

	<!--begin::Fonts -->
	<script src="{{ asset('assets/web-font.js') }}"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<!--end::Fonts -->

	{{-- ------------------------------
	# CSS GLOBAL & EXTERNAL PLUGIN
	------------------------------ --}}
	<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" rel="stylesheet" type="text/css" />

	<link href="{{ asset('assets/plugins/animate.css/animate.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/flaticon/flaticon.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/flaticon2/flaticon.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />

	{{-- ---------------------
	# STYLE & CUSTOM CSS
	--------------------- --}}
	<link href="{{ asset('assets/css/demo1/style.bundle.min.css') }}" rel="stylesheet" type="text/css" />
	<!--begin::Layout Skins(used by all pages) -->
	<!-- <link href="{{ asset('assets/css/demo1/skins/header/base/dark.min.css') }}" rel="stylesheet" type="text/css" /> -->
	<link href="{{ asset('assets/css/demo1/skins/header/menu/light.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/demo1/skins/brand/light.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/demo1/skins/aside/light.min.css') }}" rel="stylesheet" type="text/css" />
	<!--begin::Page Custom Styles(used by this page) -->
	<link href="{{ asset('assets/css/custom-main.css') }}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ asset('assets/custom/config.css') }}">
	@yield('css')
</head>

<body class="@yield('class-body','kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading')">

	<!-- begin:: Header Mobile -->
	<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed " style="height:75px">
		<div class="kt-header-mobile__logo">
			<a href="{{ url('/') }}">
				<img alt="{{ config('app.name') }}" src="{{ asset('assets/images/sidebar-logo.png') }}" width="120px" />
			</a>
		</div>
		<div class="kt-header-mobile__toolbar">
			<div class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></div>
			<div class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></div>
			<div class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></div>
		</div>
	</div>
	<!-- end:: Header Mobile -->

	<div class="kt-grid kt-grid--hor kt-grid--root">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

			<!-- begin:: Aside -->
			<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
			<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

				<!-- begin:: Aside -->
				<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
					<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
						<ul class="kt-menu__nav ">
							<li class="kt-menu__item  @if(\Request::segment(2) == '') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<i class="kt-menu__link-icon flaticon2-dashboard"></i>
									<span class="kt-menu__link-text">Dashboard</span>
								</a>
							</li>

							<li class="kt-menu__item @if(\Request::segment(2) == 'menu') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon-users"></i>
									</span>
									<span class="kt-menu__link-text">Menu</span>
								</a>
							</li>

							<li class="kt-menu__item @if(\Request::segment(2) == 'sub-menu') kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">								
								<a href="javascript::void(0);" class="kt-menu__link kt-menu__toggle">
									<i class="kt-menu__link-icon flaticon-delete"></i>
									<span class="kt-menu__link-text">Sub Menu</span>
									<i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>

								<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
									<ul class="kt-menu__subnav">
										<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
											<span class="kt-menu__link">
												<span class="kt-menu__link-text">Sub Menu</span>
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
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
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
								<li class="kt-menu__item  @if(\Request::segment(2) == '') kt-menu__item--active  @endif" aria-haspopup="true">
									<a href="{{ null }}" class="kt-menu__link ">
										<span class="kt-menu__link-icon">
											<i class="flaticon2-dashboard"></i>
										</span>
										<span class="kt-menu__link-text">Dashboard</span>
									</a>
								</li>

								@if(session('impersonated_by'))
									<li class="kt-menu__item" aria-haspopup="true">
										<a href="{{ null }}" class="kt-menu__link">
											<span class="kt-menu__link-icon">
												<i class="fa fa-user-slash"></i>
											</span>
											<span class="kt-menu__link-text">Leave Impersonation</span>
										</a>
									</li>
								@endif

								<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
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
								</li>
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
												<a href="{{ null }}" class="kt-nav__link">
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

				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
					@yield('content')
				</div>

				<div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
					<div class="kt-footer__copyright">
						{{ date('Y') }}&nbsp;©&nbsp;<a href="javascript:;" class="kt-link">{{ config('app.name') }}</a>
					</div>
				</div>

			</div>
		</div>
	</div>

	{{-- ----------
	# MODAL
	---------- --}}
	@yield('modal')

	<script>
		var KTAppOptions = {
			"colors": {
				"state": {
					"brand": "#5d78ff",
					"dark": "#282a3c",
					"light": "#ffffff",
					"primary": "#2a1e6f",
					"success": "#34bfa3",
					"info": "#36a3f7",
					"warning": "#ffb822",
					"danger": "#fd3995"
				},
				"base": {
					"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
					"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
				}
			}
		};

		function formatCurrency(amount) {
		    // return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
			const number = parseInt(amount);
			return number.toLocaleString('id-ID');
		}
	</script>
	{{-- ------------------------------
	# JS GLOBAL & EXTERNAL PLUGIN
	------------------------------ --}}
	<!--begin:: Global Mandatory Vendors -->
	<script src="{{ asset('assets/plugins/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
	<!-- Popper v2 for Bootstrap 5 (required) -->
	<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js" integrity="" crossorigin="anonymous"></script>
	<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/moment/min/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/tooltip.js/dist/umd/tooltip.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/wnumb/wNumb.js') }}" type="text/javascript"></script>
	<!--end:: Global Mandatory Vendors -->

	<!--begin:: Global Optional Vendors -->
	<script src="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>

	{{-- ---------------------
	# SCRIPT & CUSTOM JS
	--------------------- --}}
	<script src="{{ asset('assets/js/demo1/scripts.bundle.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/custom/config.js') }}" type="text/javascript"></script>
	<script>
		@if(Session::has('notification'))
		swal.fire({
			title: '{{ Session::get('notification.message') }}',
			@if(Session::get('notification.longMessage'))
			text: '{{ Session::get('notification.longMessage') }}',
			@endif
			type: '{{ Session::get('notification.level', 'info') }}',
			showConfirmButton: '{{ Session::get('notification.showConfirmButton', 'true') }}',
			@if(Session::get('notification.timer'))
			timer: '{{ Session::get('notification.timer', '1800') }}'
			@endif
		});
		@endif
	</script>

	@yield('script')
</body>
</html>