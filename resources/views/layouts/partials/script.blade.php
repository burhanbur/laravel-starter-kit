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
	<!-- Select2 JS -->
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
		$('.number-format').keyup(function () {
			this.value = this.value.replace(/[^0-9\.]/g,'');
		});

		$('.select2-format').select2();
	</script>
	<script>
		@if(Session::has('notification'))
			@if(Session::get('notification.toast', false))
				// Toast Mode
				const Toast = swal.mixin({
					toast: true,
					position: '{{ Session::get('notification.position', 'top-end') }}',
					showConfirmButton: false,
					timer: {{ Session::get('notification.timer', '3000') }},
					timerProgressBar: true,
					didOpen: (toast) => {
						toast.addEventListener('mouseenter', swal.stopTimer)
						toast.addEventListener('mouseleave', swal.resumeTimer)
					}
				});

				Toast.fire({
					icon: '{{ Session::get('notification.level', 'info') }}',
					title: '{{ Session::get('notification.message') }}'
				});
			@else
				// Modal Mode
				swal.fire({
					title: '{{ Session::get('notification.message') }}',
					@if(Session::get('notification.longMessage'))
					text: '{{ Session::get('notification.longMessage') }}',
					@endif
					type: '{{ Session::get('notification.level', 'info') }}',
					showConfirmButton: {{ Session::get('notification.showConfirmButton', 'true') }},
					@if(Session::get('notification.timer'))
					timer: {{ Session::get('notification.timer', '1800') }}
					@endif
				});
			@endif
		@endif
	</script>