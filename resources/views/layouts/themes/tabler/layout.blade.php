<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', '')">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tabler Core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">

    <!-- Legacy & Complementary Icons (Compatibility) -->
    <link href="{{ asset('assets/plugins/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/flaticon/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/flaticon2/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- External Plugins CSS -->
    <link href="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        :root {
            --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
        /* Metronic to Tabler CSS Bridge */
        .kt-portlet {
            background-color: var(--tblr-card-bg, #ffffff);
            border: 1px solid var(--tblr-card-border-color, rgba(4, 32, 69, 0.1));
            border-radius: var(--tblr-border-radius, 4px);
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .kt-portlet__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--tblr-card-border-color, rgba(4, 32, 69, 0.1));
            background: transparent;
        }
        .kt-portlet__head-label {
            display: flex;
            align-items: center;
        }
        .kt-portlet__head-title {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            color: var(--tblr-body-color, #1e293b);
        }
        .kt-portlet__head-toolbar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .kt-portlet__body {
            padding: 1.25rem;
        }
        .kt-portlet__foot {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--tblr-card-border-color, rgba(4, 32, 69, 0.1));
            background: var(--tblr-bg-surface-secondary, rgba(0, 0, 0, 0.02));
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            padding: 0;
        }
        .btn-icon-sm {
            width: 1.85rem;
            height: 1.85rem;
            padding: 0;
        }
        .kt-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        /* Tabler Compatibility Spacing & Badges */
        .mr-1 { margin-right: .25rem !important; }
        .mr-2 { margin-right: .5rem !important; }
        .mr-3 { margin-right: 1rem !important; }
        .mr-4 { margin-right: 1.5rem !important; }
        .mr-5 { margin-right: 3rem !important; }
        .ml-1 { margin-left: .25rem !important; }
        .ml-2 { margin-left: .5rem !important; }
        .ml-3 { margin-left: 1rem !important; }
        .ml-4 { margin-left: 1.5rem !important; }
        .ml-5 { margin-left: 3rem !important; }
        .btn-block { display: block; width: 100%; }

        .badge-primary { background-color: var(--tblr-primary, #206bc4) !important; color: #fff; }
        .badge-secondary { background-color: #6c757d !important; color: #fff; }
        .badge-success { background-color: #2fb344 !important; color: #fff; }
        .badge-danger { background-color: #d63939 !important; color: #fff; }
        .badge-warning { background-color: #f76707 !important; color: #fff; }
        .badge-info { background-color: #4299e1 !important; color: #fff; }
        .badge-dark { background-color: #1e293b !important; color: #fff; }
        .badge-pill { border-radius: 50rem !important; }

        /* Tabler Theme Toggle Buttons */
        [data-bs-theme="dark"] .hide-theme-dark {
            display: none !important;
        }
        [data-bs-theme="light"] .hide-theme-light,
        :not([data-bs-theme]) .hide-theme-light {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>
<body class="layout-fluid">
    <div class="page">
        @php 
            $menus = \App\Utilities\Menu::getMenuItems(); 
        @endphp

        <!-- Sidebar -->
        @include('layouts.themes.tabler.sidebar')

        <!-- Topbar Header -->
        @include('layouts.themes.tabler.header')

        <!-- Main Wrapper -->
        <div class="page-wrapper">
            <!-- Page Header / Breadcrumb -->
            <div class="page-header d-print-none py-3">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                @yield('title', config('app.name'))
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Body -->
            <div class="page-body mt-2">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            @include('layouts.themes.tabler.footer')
        </div>
    </div>

    <!-- Base Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <span>Loading...</span>
            </div>
        </div>
    </div>

    @stack('modal')

    <!-- Scripts: Mandatory jQuery, Tabler Bundle (BS5 included), Select2, SweetAlert2 -->
    <script src="{{ asset('assets/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Dark/Light mode persistence for Tabler
        function setTablerTheme(theme) {
            localStorage.setItem('tabler-theme', theme);
            document.body.setAttribute('data-bs-theme', theme);
        }

        (function () {
            var currentTheme = localStorage.getItem('tabler-theme') || 'light';
            document.body.setAttribute('data-bs-theme', currentTheme);
        })();

        // Compatibility currency & input formatters
        function formatCurrency(amount) {
            const number = parseInt(amount);
            return number.toLocaleString('id-ID');
        }

        $(document).ready(function() {
            $('.number-format').keyup(function () {
                this.value = this.value.replace(/[^0-9\.]/g,'');
            });
            $('.select2-format').select2();

            // Bootstrap 4 to Bootstrap 5 Modal Bridge
            $(document).on('click', '[data-toggle="modal"]', function(e) {
                var target = $(this).data('target');
                if (target && $(target).length) {
                    var modal = bootstrap.Modal.getOrCreateInstance($(target)[0]);
                    modal.show();
                }
            });
            $(document).on('click', '[data-dismiss="modal"]', function(e) {
                var modalEl = $(this).closest('.modal');
                if (modalEl.length) {
                    var modal = bootstrap.Modal.getOrCreateInstance(modalEl[0]);
                    modal.hide();
                }
            });

            // Modal Interval Handler
            $(document).on('click', '.modalInterval', function (e) {
                var target = $(this).data('bs-target') || $(this).data('target') || '#modalInterval';
                var url = $(this).attr('value') || $(this).data('url');
                var title = $(this).attr('title') || $(this).data('title');
                
                if (url && $('#modalIntervalContent').length) {
                    $('#modalIntervalContent').html('<div class="p-4 text-center text-muted">Memuat data...</div>').load(url);
                }
                if (title && $('#modalIntervalTitle').length) {
                    $('#modalIntervalTitle').html(title);
                }
                if ($(target).length) {
                    var modal = bootstrap.Modal.getOrCreateInstance($(target)[0], {backdrop: 'static', keyboard: false});
                    modal.show();
                }
            });
        });

        // SweetAlert notification handler
        @if(Session::has('notification'))
            @if(Session::get('notification.toast', false))
                const Toast = Swal.mixin({
                    toast: true,
                    position: '{{ Session::get('notification.position', 'top-end') }}',
                    showConfirmButton: false,
                    timer: {{ Session::get('notification.timer', '3000') }},
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: '{{ Session::get('notification.level', 'info') }}',
                    title: '{{ Session::get('notification.message') }}'
                });
            @else
                Swal.fire({
                    title: '{{ Session::get('notification.message') }}',
                    @if(Session::get('notification.longMessage'))
                    text: '{{ Session::get('notification.longMessage') }}',
                    @endif
                    icon: '{{ Session::get('notification.level', 'info') }}',
                    showConfirmButton: {{ Session::get('notification.showConfirmButton', 'true') }},
                    @if(Session::get('notification.timer'))
                    timer: {{ Session::get('notification.timer', '1800') }}
                    @endif
                });
            @endif
        @endif
    </script>

    @stack('scripts')
</body>
</html>
