<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Google Fonts: Open Sans & Nunito -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        html, body {
            font-family: 'Open Sans', 'Nunito', sans-serif !important;
        }

        *, *::before, *::after, h1, h2, h3, h4, h5, h6, p, label, input, button, select, textarea, a, span {
            font-family: inherit !important;
        }

        body {
            background-color: #f6f9ff;
            color: #2c384e;
        }

        /* Container 3D Grid Card dengan Garis Biru (Atas) & Oranye (Bawah) */
        .auth-card-3d {
            background: #ffffff;
            border-radius: 14px;
            width: 100%;
            max-width: 560px;
            padding: 2.5rem;

            /* Border 3D Atas (Biru) & Bawah (Oranye) */
            border-left: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            border-top: 6px solid #4154f1;  /* Garis Biru Atas */
            border-bottom: 6px solid #ff7b00; /* Garis Oranye Bawah */

            box-shadow: 0 12px 30px rgba(1, 41, 112, 0.08);
        }

        .text-brand-dark {
            color: #012970;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .form-label-custom {
            font-weight: 700;
            color: #012970;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
        }

        .form-control-custom {
            border: 1px solid #dce1e7;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            color: #334155;
            background-color: #ffffff;
        }

        .form-control-custom::placeholder {
            color: #aab7c4;
        }

        .form-control-custom:focus {
            border-color: #4154f1;
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.12);
        }

        .input-group-text-custom {
            background: transparent;
            border: 1px solid #dce1e7;
            border-left: none;
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
            color: #899bbd;
            cursor: pointer;
            padding-right: 1rem;
            padding-left: 1rem;
        }

        .input-group .form-control-custom {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        /* Tombol Sign In Biru 3D */
        .btn-blue-submit {
            background-color: #4154f1;
            border: none;
            border-bottom: 3px solid #2839ca;
            border-radius: 8px;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            padding: 0.8rem;
            transition: all 0.15s ease;
        }

        .btn-blue-submit:hover {
            background-color: #3143e8;
            color: #ffffff;
        }

        .btn-blue-submit:active {
            transform: translateY(1px);
            border-bottom-width: 1px;
        }

        .form-check-input-custom {
            width: 1.2em;
            height: 1.2em;
            border-radius: 4px;
            border: 1px solid #dce1e7;
            margin-top: 0;
        }

        .form-check-input-custom:checked {
            background-color: #4154f1;
            border-color: #4154f1;
        }

        .link-blue {
            color: #4154f1;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .link-blue:hover {
            color: #2b3cd4;
            text-decoration: underline;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-4">

    <!-- Card Grid dengan Border 3D Atas (Biru) & Bawah (Oranye) -->
    <div class="auth-card-3d">
        <!-- Title Header -->
        <h2 class="text-brand-dark fs-2 mb-1">Welcome back</h2>
        <p class="text-muted mb-4">Sign in to continue to your NiceAdmin workspace.</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-info mb-4 small rounded-2" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- NIK Field -->
            <div class="mb-4">
                <label for="nik" class="form-label form-label-custom">NIK</label>
                <input id="nik" type="text" name="nik" class="form-control form-control-custom @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required autofocus autocomplete="off" placeholder="Masukkan NIK Anda">
                @error('nik')
                    <div class="text-danger small mt-1 fw-semibold">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label form-label-custom mb-0">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-blue">Forgot password?</a>
                    @endif
                </div>
                <div class="input-group">
                    <input id="password" type="password" name="password" class="form-control form-control-custom @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="Enter your password">
                    <span class="input-group-text input-group-text-custom" id="togglePassword">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </span>
                </div>
                @error('password')
                    <div class="text-danger small mt-1 fw-semibold">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me & Lock Screen -->
            <div class="d-flex align-items-center justify-content-between mb-4 pt-1">
                <div class="form-check d-flex align-items-center gap-2 mb-0">
                    <input class="form-check-input form-check-input-custom" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label text-muted small fw-medium" for="remember_me">
                        Remember me
                    </label>
                </div>
                <a href="#" class="link-blue">Use lock screen</a>
            </div>

            <!-- Submit Button -->
            <button class="btn btn-blue-submit w-100" type="submit">
                Sign In
            </button>
        </form>
    </div>

    <!-- Toggle Password Script -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        if (togglePassword && password && eyeIcon) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
            });
        }
    </script>
</body>
</html>