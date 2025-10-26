<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password — Laravel Starter Kit</title>
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
            <h5 class="mb-2" style="font-weight: 600; color: var(--text-dark);">{{ __('Reset Password') }}</h5>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 14px;">
                Buat password baru untuk akun Anda.
            </p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <div class="input-group">
                        <span class="input-group-text input-icon">
                            <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                        </span>
                        <input 
                            id="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" 
                            value="{{ $email ?? old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                            placeholder="nama@example.com"
                            style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-right: 1px solid var(--border);"
                        >
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text input-icon">
                            <i class="fa-solid fa-lock" aria-hidden="true"></i>
                        </span>
                        <input 
                            id="password" 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Password baru"
                            style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-right: 1px solid var(--border);"
                        >
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text input-icon">
                            <i class="fa-solid fa-lock" aria-hidden="true"></i>
                        </span>
                        <input 
                            id="password-confirm" 
                            type="password" 
                            class="form-control" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Ulangi password"
                            style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-right: 1px solid var(--border);"
                        >
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        {{ __('Reset Password') }}
                    </button>
                </div>

                <div class="text-center" style="color: var(--text-muted); font-size: 14px;">
                    Ingat password Anda? <a href="{{ route('login') }}">Masuk</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery + Bootstrap JS -->
<script src="{{ asset('assets/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
