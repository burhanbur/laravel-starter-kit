<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', '')">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts: Public Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

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
            --bs-font-sans-serif: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            --sneat-primary: #696cff;
            --sneat-primary-hover: #5f61e6;
            --sneat-bg: #f5f5f9;
        }
        body {
            font-family: var(--bs-font-sans-serif);
            background-color: var(--sneat-bg);
            color: #566a7f;
        }
        .btn-primary {
            background-color: var(--sneat-primary);
            border-color: var(--sneat-primary);
        }
        .btn-primary:hover {
            background-color: var(--sneat-primary-hover);
            border-color: var(--sneat-primary-hover);
        }
        .text-primary {
            color: var(--sneat-primary) !important;
        }
        .bg-label-primary {
            background-color: #e7e7ff !important;
            color: #696cff !important;
        }
        .bg-label-info {
            background-color: #d7f5fc !important;
            color: #03c3ec !important;
        }

        /* Layout Architecture */
        .layout-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }
        .layout-container {
            display: flex;
            flex: 1 1 auto;
            width: 100%;
            min-height: 100vh;
        }
        .layout-menu {
            width: 16.25rem;
            min-width: 16.25rem;
            background: #ffffff;
            border-right: 1px solid #e7e7e8;
            display: flex;
            flex-direction: column;
            transition: all 0.2s ease-in-out;
        }
        .layout-page {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-width: 0;
            padding: 0 1.5rem;
        }
        .layout-navbar {
            height: 3.875rem;
            margin: 0.75rem 0 1.25rem;
            border-radius: 0.375rem;
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(6px);
            padding: 0 1.5rem;
        }
        .content-wrapper {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
        }

        /* Menu Items */
        .menu-inner {
            margin: 0;
            padding: 0.5rem 0.75rem;
        }
        .menu-item {
            margin: 0.15rem 0;
        }
        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 1rem;
            border-radius: 0.375rem;
            color: #697a8d;
            text-decoration: none;
            font-size: 0.9375rem;
            transition: all 0.15s ease-in-out;
        }
        .menu-link:hover {
            background-color: #f5f5f9;
            color: #566a7f;
        }
        .menu-item.active > .menu-link {
            background-color: #e7e7ff;
            color: #696cff;
            font-weight: 600;
        }
        .menu-icon {
            font-size: 1.25rem;
            margin-right: 0.75rem;
        }
        .menu-chevron {
            transition: transform 0.2s ease;
        }
        .menu-item.open > .menu-link .menu-chevron {
            transform: rotate(90deg);
        }
        .menu-sub {
            display: none;
            margin-top: 0.25rem;
        }
        .menu-item.open > .menu-sub {
            display: block;
        }
        .menu-sub .menu-link {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        /* Sneat Portlet / Card Bridge */
        .kt-portlet {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
            border: none;
            margin-bottom: 1.5rem;
        }
        .kt-portlet__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f2f2f5;
        }
        .kt-portlet__head-title {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 600;
            color: #566a7f;
            display: flex;
            align-items: center;
        }
        .kt-portlet__head-toolbar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .kt-portlet__body {
            padding: 1.5rem;
        }
        .kt-portlet__foot {
            padding: 1rem 1.5rem;
            border-top: 1px solid #f2f2f5;
            background-color: #fafafc;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
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
            border-radius: 0.375rem;
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
            padding: 0.3rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Sneat Compatibility Spacing & Badges */
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

        .badge-primary { background-color: var(--sneat-primary, #696cff) !important; color: #fff; }
        .badge-secondary { background-color: #8592a3 !important; color: #fff; }
        .badge-success { background-color: #71dd37 !important; color: #fff; }
        .badge-danger { background-color: #ff3e1d !important; color: #fff; }
        .badge-warning { background-color: #ffab00 !important; color: #fff; }
        .badge-info { background-color: #03c3ec !important; color: #fff; }
        .badge-dark { background-color: #233446 !important; color: #fff; }
        .badge-pill { border-radius: 50rem !important; }

        @media (max-width: 1199.98px) {
            .layout-menu {
                position: fixed;
                left: -16.25rem;
                top: 0;
                bottom: 0;
                z-index: 1099;
            }
            .layout-menu.show {
                left: 0;
            }
            .layout-page {
                padding: 0 0.75rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @php 
                $menus = \App\Utilities\Menu::getMenuItems(); 
            @endphp

            <!-- Sidebar -->
            @include('layouts.themes.sneat.sidebar')

            <!-- Main Page Layout -->
            <div class="layout-page">
                <!-- Header / Navbar -->
                @include('layouts.themes.sneat.header')

                <!-- Content Wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 p-0">
                        @yield('content')
                    </div>

                    <!-- Footer -->
                    @include('layouts.themes.sneat.footer')
                </div>
            </div>
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

    <!-- Scripts: Mandatory jQuery, Bootstrap 5 Bundle, SweetAlert2, Select2 -->
    <script src="{{ asset('assets/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Sneat Submenu Accordion & Mobile Toggle
        $(document).ready(function() {
            $('.menu-item.has-sub > .menu-link').on('click', function(e) {
                e.preventDefault();
                $(this).parent().toggleClass('open');
            });

            $('#sneatMenuToggler').on('click', function(e) {
                e.preventDefault();
                $('#layout-menu').toggleClass('show');
            });

            // Formatters
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

        function formatCurrency(amount) {
            const number = parseInt(amount);
            return number.toLocaleString('id-ID');
        }

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
