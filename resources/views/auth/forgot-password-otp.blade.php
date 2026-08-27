<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify OTP & Reset Password</title>

    <!-- Google Fonts & Bootstrap Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        /* 3D Container */
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
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        .form-control-custom {
            border: 1px solid #dce1e7;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            color: #334155;
            background-color: #ffffff;
        }

        .form-control-custom:focus {
            border-color: #4154f1;
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.12);
        }

        /* Input OTP Box 5-Digit */
        .otp-input-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 1rem 0 1.5rem 0;
        }

        .otp-input {
            width: 52px;
            height: 60px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #012970;
            border: 2px solid #dce1e7;
            border-radius: 10px;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .otp-input:focus {
            border-color: #4154f1;
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.15);
            outline: none;
        }

        /* 3D Submit Button */
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
            border: none;
            background: none;
            padding: 0;
        }

        .link-blue:hover:not(:disabled) {
            color: #2b3cd4;
            text-decoration: underline;
        }

        .link-blue:disabled {
            color: #aab7c4;
            cursor: not-allowed;
            text-decoration: none;
        }

        .copyright-text {
            color: #899bbd;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .label-icon {
            font-size: 1rem;
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
            <h2 class="text-brand-dark fs-2 mb-1">Verify OTP & Reset Password</h2>
        </div>

        <p class="text-muted small mb-3">
            Enter the 5-digit verification code sent to your email and set your new numeric password.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-3 small rounded-2" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
            </div>
        @endif

        <!-- Form Reset Password OTP -->
        <form method="POST" action="{{ route('password.otp.update') }}">
            @csrf

            <!-- Hidden Input NIK -->
            <input type="hidden" name="nik" value="{{ request('nik') ?? session('reset_nik') }}">

            <!-- Label OTP -->
            <label class="form-label form-label-custom d-flex align-items-center justify-content-center">
                <i class="bi bi-shield-lock label-icon"></i> Enter 5-Digit OTP Code
            </label>

            <!-- 5 OTP Inputs -->
            <div class="otp-input-container">
                <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required autofocus>
                <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
            </div>

            @error('otp')
                <div class="text-danger text-center small mb-3 fw-semibold">
                    <i class="bi bi-exclamation-triangle me-1"></i> {{ $message }}
                </div>
            @enderror

            @error('otp_code')
                <div class="text-danger text-center small mb-3 fw-semibold">
                    <i class="bi bi-exclamation-triangle me-1"></i> {{ $message }}
                </div>
            @enderror

            <!-- Input New Password (Numbers Only) -->
            <div class="mb-3">
                <label for="password" class="form-label form-label-custom d-flex align-items-center">
                    <i class="bi bi-key label-icon"></i> New Password (Numbers Only)
                </label>
                <input id="password" type="password" name="password" inputmode="numeric" pattern="[0-9]*" class="form-control form-control-custom @error('password') is-invalid @enderror" required placeholder="Enter new numeric password (min 4 digits)">
                @error('password')
                    <div class="text-danger small mt-1 fw-semibold"><i class="bi bi-exclamation-triangle me-1"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Input Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label form-label-custom d-flex align-items-center">
                    <i class="bi bi-key-fill label-icon"></i> Confirm New Password
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" inputmode="numeric" pattern="[0-9]*" class="form-control form-control-custom" required placeholder="Re-enter new numeric password">
            </div>

            <!-- Submit Button -->
            <button class="btn btn-blue-submit w-100 mt-2" type="submit">
                <i class="bi bi-check-circle me-1"></i> Reset Password
            </button>
        </form>

        <!-- Timer & Resend Option -->
        <div class="text-center mt-4">
            <p class="text-muted small mb-1">
                Didn't receive the code? 
                <span id="timerContainer">Resend in <strong id="timerText" class="text-brand-dark">01:00</strong></span>
            </p>

            <form method="POST" action="{{ route('password.otp.resend') }}" class="d-inline">
                @csrf
                <input type="hidden" name="nik" value="{{ request('nik') ?? session('reset_nik') }}">
                <button type="submit" id="resendBtn" class="link-blue" disabled>
                    <i class="bi bi-arrow-counterclockwise"></i> Resend OTP Code
                </button>
            </form>
        </div>

        <!-- Back to Login Link -->
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="link-blue d-inline-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to Login
            </a>
        </div>

        <!-- Copyright Footer -->
        <div class="text-center mt-4 pt-2">
            <p class="copyright-text mb-0">&copy; {{ date('Y') }} Engineering 1. All rights reserved.</p>
        </div>
    </div>

    <!-- Script Handling OTP & Countdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('.otp-input');
            const resendBtn = document.getElementById('resendBtn');
            const timerText = document.getElementById('timerText');
            const timerContainer = document.getElementById('timerContainer');

            // 1. Auto-Focus Next & Backspace Navigation for 5 OTP Inputs
            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;
                    if (value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // Support Paste 5 Digits Direct
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
                    if (/^\d{5}$/.test(pasteData)) {
                        pasteData.split('').forEach((char, i) => {
                            if (inputs[i]) inputs[i].value = char;
                        });
                        inputs[4].focus();
                    }
                });
            });

            // 2. Countdown Timer 60 Seconds (1 Minute)
            let timeLeft = 60;
            const timerInterval = setInterval(() => {
                timeLeft--;

                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerText.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    timerContainer.style.display = 'none';
                    resendBtn.removeAttribute('disabled');
                }
            }, 1000);
        });
    </script>
</body>
</html>