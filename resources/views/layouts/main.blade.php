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

	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/circle-icon.png') }}">

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
	<style>
		@media (max-width: 1024px){
			.kt-header-mobile--fixed .kt-wrapper {
				padding-top: 75px;
			}
		}
		@media (min-width: 1025px){
			.kt-header {
				background-color: rgb(19, 92, 178);
				background: linear-gradient(90deg, rgb(19, 92, 178) 35%, rgb(8, 73, 153) 100%);
			}
			.kt-header-menu .kt-menu__nav>.kt-menu__item.kt-menu__item--active>.kt-menu__link,
			.kt-header-menu .kt-menu__nav>.kt-menu__item.kt-menu__item--here>.kt-menu__link,
			.kt-header-menu .kt-menu__nav>.kt-menu__item:hover>.kt-menu__link,
			.kt-header-menu .kt-menu__nav>.kt-menu__item.kt-menu__item--hover:not(.kt-menu__item--here):not(.kt-menu__item--active)>.kt-menu__link,
			.kt-header-menu .kt-menu__nav>.kt-menu__item:hover:not(.kt-menu__item--here):not(.kt-menu__item--active)>.kt-menu__link {
				background-color: #f5f6fc;
			}
			.kt-header-menu .kt-menu__nav>.kt-menu__item>.kt-menu__link .kt-menu__link-text,
			.kt-header-menu .kt-menu__nav>.kt-menu__item>.kt-menu__link>.kt-menu__link-icon{
				color: #F4F4F4;
			}
			.kt-header-menu .kt-menu__nav>.kt-menu__item.kt-menu__item--active>.kt-menu__link .kt-menu__link-text,
			.kt-header-menu .kt-menu__nav>.kt-menu__item:hover>.kt-menu__link .kt-menu__link-text,
			.kt-header-menu .kt-menu__nav>.kt-menu__item.kt-menu__item--hover:not(.kt-menu__item--here):not(.kt-menu__item--active)>.kt-menu__link .kt-menu__link-text, .kt-header-menu .kt-menu__nav>.kt-menu__item:hover:not(.kt-menu__item--here):not(.kt-menu__item--active)>.kt-menu__link .kt-menu__link-text
			{
				color: rgb(19, 92, 178);
			}



			.kt-header-menu .kt-menu__nav>.kt-menu__item.kt-menu__item--active>.kt-menu__link>.kt-menu__link-icon,
			.kt-header-menu .kt-menu__nav>.kt-menu__item.kt-menu__item--here>.kt-menu__link>.kt-menu__link-icon,
			.kt-header-menu .kt-menu__nav>.kt-menu__item.kt-menu__item--hover>.kt-menu__link>.kt-menu__link-icon,
			.kt-header-menu .kt-menu__nav>.kt-menu__item:hover>.kt-menu__link>.kt-menu__link-icon{
				color: rgb(8, 73, 153);
			}

			.kt-header__topbar .kt-header__topbar-item .kt-header__topbar-wrapper button > i,
			.kt-header__topbar .kt-header__topbar-item .kt-header__topbar-wrapper .btn.dropdown-toggle:after{
				color: #FFF;
			}
		}

		.text-center {
			text-align: center;
		}

		.text-left {
			text-align: left;
		}

	    .text-right {
	        text-align: right;
	    }

	    .content-center {
	    	justify-content: center; 
	    	align-items: center; 
	    	display: flex;
	    }

		.responsive-embed-container {
			width: 100%;
			height: 80vh; /* 80% dari tinggi viewport */
			max-height: 90vh;
			overflow: hidden;
		}

		.responsive-embed-container embed {
			width: 100%;
			height: 100%;
			border: none;
		}
	</style>
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

							{{-- <li class="kt-menu__item @if(\Request::segment(2) == 'pendaftaran') kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<i class="kt-menu__link-icon flaticon2-list-2"></i>
									<span class="kt-menu__link-text">Data Pendaftaran</span>
									<i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
									<ul class="kt-menu__subnav">
										<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
											<span class="kt-menu__link">
												<span class="kt-menu__link-text">Data Pendaftaran</span>
											</span>
										</li>

										@foreach(\App\Models\JalurMasuk::where('is_active', '1')->orderBy('id', 'desc')->get() as $item)
										<li class="kt-menu__item @if(\Request::segment(2) == 'pendaftaran' && \Request::segment(3) == $item->id) kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Jalur {{ $item->nama_pendek }}</span>
											</a>
										</li>
										@endforeach
									</ul>
								</div>
							</li> 
							
							<li class="kt-menu__item @if(\Request::segment(2) == 'pembayaran') kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<i class="kt-menu__link-icon flaticon2-list"></i>
									<span class="kt-menu__link-text">Data Pembayaran</span>
									<i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
									<ul class="kt-menu__subnav">
										<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
											<span class="kt-menu__link">
												<span class="kt-menu__link-text">Data Pembayaran</span>
											</span>
										</li>

										@foreach(\App\Models\JalurMasuk::where('is_active', '1')->orderBy('id', 'desc')->get() as $item)
										<li class="kt-menu__item @if(\Request::segment(2) == 'pembayaran' && \Request::segment(3) == $item->id) kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Jalur {{ $item->nama_pendek }}</span>
											</a>
										</li>
										@endforeach
									</ul>
								</div>
							</li>
							
							<li class="kt-menu__item @if(\Request::segment(2) == 'calon-mhs') kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<i class="kt-menu__link-icon flaticon2-group"></i>
									<span class="kt-menu__link-text">Kelengkapan Data</span>
									<i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
									<ul class="kt-menu__subnav">
										<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
											<span class="kt-menu__link">
												<span class="kt-menu__link-text">Calon Mahasiswa</span>
											</span>
										</li>

										@foreach(\App\Models\JalurMasuk::where('is_active', '1')->orderBy('id', 'desc')->get() as $item)
										<li class="kt-menu__item @if(\Request::segment(2) == 'calon-mhs' && \Request::segment(3) == $item->id) kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Jalur {{ $item->nama_pendek }}</span>
											</a>
										</li>
										@endforeach
									</ul>
								</div>
							</li>
							
							<li class="kt-menu__item @if(\Request::segment(2) == 'ujian-akademik') kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<i class="kt-menu__link-icon flaticon-file"></i>
									<span class="kt-menu__link-text">Ujian Akademik</span>
									<i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
									<ul class="kt-menu__subnav">
										<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
											<span class="kt-menu__link">
												<span class="kt-menu__link-text">Ujian Akademik</span>
											</span>
										</li>

										@foreach(\App\Models\JalurMasuk::where('is_ujian','1')->where('is_active', '1')->orderBy('id', 'desc')->get() as $item)
										<li class="kt-menu__item @if(\Request::segment(2) == 'ujian-akademik' && \Request::segment(3) == $item->id) kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Jalur {{ $item->nama_pendek }}</span>
											</a>
										</li>
										@endforeach
									</ul>
								</div>
							</li> --}}

							<li class="kt-menu__item @if(\Request::segment(2) == 'pendaftaran') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon-users"></i>
									</span>
									<span class="kt-menu__link-text">Data Pendaftaran</span>
								</a>
							</li>

							<li class="kt-menu__item @if(\Request::segment(2) == 'calon-mhs') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon-edit-1"></i>
									</span>
									<span class="kt-menu__link-text">Kelengkapan Data</span>
								</a>
							</li>

							@if (auth()->user()->role ?? null == 'admin')
							<li class="kt-menu__item @if(\Request::segment(2) == 'kelulusan') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon2-correct"></i>
									</span>
									<span class="kt-menu__link-text">Rekomendasi Kelulusan</span>
								</a>
							</li>
							@endif

							<li class="kt-menu__item @if(\Request::segment(2) == 'cicilan') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon-notepad"></i>
									</span>
									<span class="kt-menu__link-text">Pengajuan Cicilan</span>
								</a>
							</li>

							<li class="kt-menu__item @if(\Request::segment(2) == 'daftar-ulang') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon-rotate"></i>
									</span>
									<span class="kt-menu__link-text">Daftar Ulang</span>
								</a>
							</li>

							@if (auth()->user()->role ?? null == 'admin')
							<li class="kt-menu__item @if(\Request::segment(2) == 'pop-up') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon-notes"></i>
									</span>
									<span class="kt-menu__link-text">POP UP</span>
								</a>
							</li>

							<li class="kt-menu__item @if(\Request::segment(2) == 'verifikasi-mahasiswa') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon-profile"></i>
									</span>
									<span class="kt-menu__link-text">Verifikasi Mahasiswa</span>
								</a>
							</li>
							@endif

							<li class="kt-menu__item @if(\Request::segment(2) == 'pengunduran-diri') kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">								
								<a href="javascript::void(0);" class="kt-menu__link kt-menu__toggle">
									<i class="kt-menu__link-icon flaticon-delete"></i>
									<span class="kt-menu__link-text">Pengunduran Diri</span>
									<i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>

								<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
									<ul class="kt-menu__subnav">
										<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
											<span class="kt-menu__link">
												<span class="kt-menu__link-text">Pengunduran Diri</span>
											</span>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'pengunduran-diri' && \Request::segment(3) == 'pendaftaran') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Pendaftaran</span>
											</a>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'pengunduran-diri' && \Request::segment(3) == 'daftar-ulang') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Daftar Ulang</span>
											</a>
										</li>
									</ul>
								</div>
							</li>

							<!-- 
							<li class="kt-menu__item @if(\Request::segment(2) == 'cms-website') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon-users"></i>
									</span>
									<span class="kt-menu__link-text">Memperoleh NIM</span>
								</a>
							</li>

							<li class="kt-menu__item @if(\Request::segment(2) == 'cicilan') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="la la-credit-card"></i>
									</span>
									<span class="kt-menu__link-text">Cicilan</span>
								</a>
							</li> -->

							@if (auth()->user()->role ?? null == 'admin')
							<li class="kt-menu__item @if(\Request::segment(2) == 'laporan') kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">								
								<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<i class="kt-menu__link-icon flaticon2-document"></i>
									<span class="kt-menu__link-text">Laporan</span>
									<i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>

								<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
									<ul class="kt-menu__subnav">
										<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
											<span class="kt-menu__link">
												<span class="kt-menu__link-text">Laporan</span>
											</span>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'laporan' && \Request::segment(3) == 'camaba') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Calon Mahasiswa Baru</span>
											</a>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'laporan' && \Request::segment(3) == 'seleksi-beasiswa') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Seleksi Beasiswa</span>
											</a>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'laporan' && \Request::segment(3) == 'tagihan-spi-spp') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Tagihan SPI-SPP</span>
											</a>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'laporan' && \Request::segment(3) == 'referral') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Referral</span>
											</a>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'laporan' && \Request::segment(3) == 'marketing') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Marketing</span>
											</a>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'laporan' && \Request::segment(3) == 'student-international') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Student Internasional</span>
											</a>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'laporan' && \Request::segment(3) == 'open-house') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Open House</span>
											</a>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'laporan' && \Request::segment(3) == 'webinar') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Webinar</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							@endif

							<li class="kt-menu__item @if(\Request::segment(2) == 'tagihan') kt-menu__item--open kt-menu__item--here @endif kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">								
								<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<i class="kt-menu__link-icon flaticon-coins"></i>
									<span class="kt-menu__link-text">Tagihan</span>
									<i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>

								<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
									<ul class="kt-menu__subnav">
										<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
											<span class="kt-menu__link">
												<span class="kt-menu__link-text">Tagihan</span>
											</span>
										</li>

										<li class="kt-menu__item @if(\Request::segment(2) == 'tagihan' && \Request::segment(3) == 'camaba') kt-menu__item--active @endif" aria-haspopup="true">
											<a href="{{ null }}" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">BNI</span>
											</a>
										</li>
									</ul>
								</div>
							</li>

							@if (auth()->user()->role ?? null == 'admin')
							<li class="kt-menu__item @if(\Request::segment(2) == 'cms') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon2-website"></i>
									</span>
									<span class="kt-menu__link-text">CMS Website</span>
								</a>
							</li>

							{{-- <li class="kt-menu__item @if(\Request::segment(2) == 'media') kt-menu__item--active @endif" aria-haspopup="true">
								<a href="{{ null }}" class="kt-menu__link ">
									<span class="kt-menu__link-icon">
										<i class="flaticon-folder"></i>
									</span>
									<span class="kt-menu__link-text">File Manager</span>
								</a>
							</li> --}}
							@endif
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
								
								@if (auth()->user()->role ?? null == 'admin')
								<li class="kt-menu__item  @if(\Request::segment(2) == 'broadcasting') kt-menu__item--active  @endif" aria-haspopup="true">
									<a href="{{ null }}" class="kt-menu__link ">
										<span class="kt-menu__link-icon">
											<i class="fa fa-bullhorn"></i>
										</span>
										<span class="kt-menu__link-text">Broadcasting</span>
									</a>
								</li>
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
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Jalur Masuk</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Jurusan SMK</span></a></li>
											<!-- <li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Dokumen Cicilan</span></a></li> -->
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Referral</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Fakultas</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Program Studi</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">User</span></a></li>
											<!-- <li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Template Surat</span></a></li> -->
											<!-- <li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Eksternal Link</span></a></li> -->
											{{-- <!-- <li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Diskon</span></a></li> --> --}}
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Kuota Prodi</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Passing Grade</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Target Camaba</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">User Camaba</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="{{ null }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Kuesioner</span></a></li>
										</ul>
									</div>
								</li>
								@endif
							</ul>
						</div>
					</div>

					<!-- begin:: Header Topbar -->
					<div class="kt-header__topbar">

						<!--begin: User Bar -->
						<div class="kt-header__topbar-item align-items-center">
							<div class="kt-header__topbar-wrapper">
								<div class="dropdown dropdown-inline kt-margin-t-10 kt-margin-b-10">
									<button type="button" class="btn btn-icon-sm dropdown-toggle text-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="flaticon2-user"></i>
										{{ auth()->user()->name ?? '-' }}
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
	<script src="{{ asset('assets/plugins/popper.js/dist/umd/popper.min.js') }}" type="text/javascript"></script>
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