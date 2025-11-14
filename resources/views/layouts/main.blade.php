<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('layouts.partials.head')

	@yield('styles')
	@stack('styles')
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
			
			@include('layouts.partials.sidebar')

			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
				@include('layouts.partials.header')

				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
					@yield('content')
				</div>

				@include('layouts.partials.footer')

			</div>
		</div>
	</div>

	{{-- ----------
	# MODAL
	---------- --}}
	@yield('modal')

	@include('layouts.partials.script')

	@yield('script')
	@stack('scripts')
</body>
</html>