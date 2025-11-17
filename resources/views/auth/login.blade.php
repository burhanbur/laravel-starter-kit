<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.alias') }} | Login</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS (CDN) -->
    <link href="{{  asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">
</head>
<body>

<div class="login-container">
    <div class="card card-login">
        <div class="card-header-custom">
            <img src="{{ asset('assets/images/logo-white.png') }}" alt="Logo" class="brand-logo">
        </div>

        <div class="form-section">
            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text input-icon">
                            <i class="fa-regular fa-user" aria-hidden="true"></i>
                        </span>
                        <input 
                            type="text" 
                            class="form-control @error('identity') is-invalid @enderror" 
                            id="identity" 
                            name="identity" 
                            placeholder="Masukkan email atau username Anda" 
                            required 
                            value="{{ old('identity') ?? '' }}"
                            style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-right: 1px solid var(--border);"
                        >
                    </div>
                    @error('identity')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="invalid-feedback d-none" id="">
                        <i class="fa-solid fa-circle-exclamation me-1"></i>Masukkan alamat email atau username yang valid
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text input-icon">
                            <i class="fa-solid fa-lock" aria-hidden="true"></i>
                        </span>
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password Anda" 
                            required
                        >
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="fa-regular fa-eye" id="toggleIcon" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-size: 14px; color: var(--text-muted);">
                            Ingat saya
                        </label>
                    </div>
                    {{-- <a href="#" style="font-size: 14px;">Lupa password?</a> --}}
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                        <span id="submitSpinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                        <span id="submitText">Masuk Sekarang</span>
                    </button>
                </div>

                <div class="divider">
                    <span class="divider-text">atau masuk dengan</span>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-12">
                        <button type="button" class="btn social-btn w-100">
                            <i class="fa fa-key me-2" style="color: var(--primary);"></i>SSO
                        </button>
                    </div>
                </div>

                {{-- <div class="text-center" style="color: var(--text-muted); font-size: 14px;">
                    Belum punya akun? <a href="#">Daftar sekarang</a>
                </div> --}}
            </form>
        </div>
    </div>
</div>

<!-- jQuery + Bootstrap JS -->
<script src="{{ asset('assets/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script>
    (function($){
        'use strict';
        
        $(document).ready(function(){
            const $email = $('#email');
            const $password = $('#password');
            const $submit = $('#submitBtn');
            const $spinner = $('#submitSpinner');
            const $submitText = $('#submitText');
            const $emailClientError = $('#emailClientError');
            const $togglePassword = $('#togglePassword');
            const $toggleIcon = $('#toggleIcon');

            // Auto focus on email field with slight delay for better UX
            setTimeout(function(){ $email.trigger('focus'); }, 300);

            // Email validation regex
            function isValidEmail(email){
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }

            // Toggle password visibility with smooth animation
            $togglePassword.on('click', function(){
                const isPassword = $password.attr('type') === 'password';
                
                // Animate icon change
                $toggleIcon.css('transform', 'scale(0.8)');
                
                setTimeout(function(){
                    $password.attr('type', isPassword ? 'text' : 'password');
                    $toggleIcon
                        .removeClass('fa-eye fa-eye-slash')
                        .addClass(isPassword ? 'fa-eye-slash' : 'fa-eye')
                        .css('transform', 'scale(1)');
                }, 150);
            });

            // Real-time validation and button state
            function validateAndUpdateButton(){
                const emailVal = $.trim($email.val());
                const passVal = $.trim($password.val());
                const emailValid = isValidEmail(emailVal);
                
                // Email validation feedback
                if(emailVal.length > 0 && !emailValid){
                    $email.addClass('is-invalid');
                    $emailClientError.removeClass('d-none');
                } else {
                    $email.removeClass('is-invalid');
                    $emailClientError.addClass('d-none');
                }

                // Enable/disable submit button
                // const canSubmit = emailVal.length > 0 && passVal.length > 0 && emailValid;
                const canSubmit = true;
                $submit.prop('disabled', !canSubmit);
            }

            // Bind validation to input events
            $email.on('input blur', validateAndUpdateButton);
            $password.on('input', validateAndUpdateButton);
            
            // Initial validation check
            validateAndUpdateButton();

            // Form submission with loading state
            $('#loginForm').on('submit', function(e){
                $submit.prop('disabled', true);
                $spinner.removeClass('d-none');
                $submitText.text('Memproses...');
            });

            // Add ripple effect to buttons (optional enhancement)
            $('.btn').on('click', function(e){
                const $ripple = $('<span class="ripple"></span>');
                const btnOffset = $(this).offset();
                const x = e.pageX - btnOffset.left;
                const y = e.pageY - btnOffset.top;
                
                $ripple.css({
                    top: y + 'px',
                    left: x + 'px',
                    position: 'absolute',
                    width: '0',
                    height: '0',
                    borderRadius: '50%',
                    background: 'rgba(255,255,255,0.6)',
                    transform: 'translate(-50%, -50%)',
                    animation: 'ripple-animation 0.6s ease-out'
                });
                
                $(this).css('position', 'relative').css('overflow', 'hidden').append($ripple);
                
                setTimeout(function(){ $ripple.remove(); }, 600);
            });

            // Add CSS for ripple animation dynamically
            $('<style>')
                .text('@keyframes ripple-animation { to { width: 300px; height: 300px; opacity: 0; } }')
                .appendTo('head');
        });
    })(jQuery);
</script>

</body>
</html>