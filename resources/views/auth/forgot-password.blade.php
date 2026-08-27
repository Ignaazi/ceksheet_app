<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>

    <!-- Google Fonts -->
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

        .auth-card-3d {
            background: #ffffff;
            border-radius: 14px;
            width: 100%;
            max-width: 560px;
            padding: 2.5rem;
            border-left: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            border-top: 6px solid #4154f1;
            border-bottom: 6px solid #ff7b00;
            box-shadow: 0 12px 30px rgba(1, 41, 112, 0.08);
        }

        .brand-logo {
            max-width: 180px;
            height: auto;
            object-fit: contain;
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

        .copyright-text {
            color: #899bbd;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .label-icon {
            font-size: 1.05rem;
            color: #4154f1;
            margin-right: 0.35rem;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-4">

    <div class="auth-card-3d">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('image/logoSiix.png') }}" alt="PT SIIX Logo" class="brand-logo">
        </div>

        <!-- Header -->
        <div class="text-start mb-3">
            <h2 class="text-brand-dark fs-2 mb-1">Reset Password</h2>
        </div>

        <p class="text-muted small mb-4">
            Enter your registered NIK and target email address to receive your OTP verification code.
        </p>

        <!-- Status Alert -->
        @if (session('status'))
            <div class="alert alert-success mb-4 small rounded-2" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
            </div>
        @endif

        <!-- Form mengarah ke route('password.email') -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Field NIK -->
            <div class="mb-3">
                <label for="nik" class="form-label form-label-custom d-flex align-items-center">
                    <i class="bi bi-person-vcard label-icon"></i> Employee Identification Number (NIK)
                </label>
                <input id="nik" type="text" name="nik" class="form-control form-control-custom @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required autofocus autocomplete="off" placeholder="Enter your NIK">
                @error('nik')
                    <div class="text-danger small mt-1 fw-semibold"><i class="bi bi-exclamation-triangle me-1"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Field Email Target OTP -->
            <div class="mb-4">
                <label for="email" class="form-label form-label-custom d-flex align-items-center">
                    <i class="bi bi-envelope label-icon"></i> Recipient Email Address
                </label>
                <input id="email" type="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="Enter email to receive OTP">
                @error('email')
                    <div class="text-danger small mt-1 fw-semibold"><i class="bi bi-exclamation-triangle me-1"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button class="btn btn-blue-submit w-100 mt-2" type="submit">
                <i class="bi bi-send me-1"></i> Send OTP Code
            </button>

            <!-- Back to Login Link -->
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="link-blue d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Back to Login
                </a>
            </div>
        </form>

        <div class="text-center mt-4 pt-2">
            <p class="copyright-text mb-0">&copy; {{ date('Y') }} Engineering 1. All rights reserved.</p>
        </div>
    </div>

</body>
</html>