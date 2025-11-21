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

	<!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
	
	{{-- <script src="{{ asset('assets/web-font.js') }}"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script> --}}

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
	<!-- Select2 CSS - Load default first, then custom -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet" type="text/css" />
	
	<link href="{{ asset('assets/css/custom-main.css') }}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ asset('assets/custom/config.css') }}">