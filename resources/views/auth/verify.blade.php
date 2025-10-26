<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email — Laravel Starter Kit</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="{{  asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <!-- Shared auth styles -->
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="login-container">
    <div class="card card-login">
        <div class="card-header-custom">
            <img src="{{ asset('assets/images/logo-white.png') }}" alt="Logo" class="brand-logo">
        </div>

        <div class="form-section">
            <h5 class="mb-3" style="font-weight: 600; color: var(--text-dark);">{{ __('Verify Your Email Address') }}</h5>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
            </p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        {{ __('Click Here to Request Another') }}
                    </button>
                </div>
            </form>

            <div class="text-center mt-4" style="color: var(--text-muted); font-size: 14px;">
                <a href="{{ route('login') }}">Kembali ke Login</a>
            </div>
        </div>
    </div>
</div>

<!-- jQuery + Bootstrap JS -->
<script src="{{ asset('assets/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
