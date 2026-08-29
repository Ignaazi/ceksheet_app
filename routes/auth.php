<?php

use App\Http\Controllers\Admin\IpConfigController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\OtpForgotPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // KEMBALI NORMAL (Sync role diproses di AuthenticatedSessionController)
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // --- FITUR LUPA PASSWORD VIA OTP ---
    Route::get('forgot-password', [OtpForgotPasswordController::class, 'showForgotForm'])
        ->name('password.request');

    Route::post('forgot-password', [OtpForgotPasswordController::class, 'sendOtp'])
        ->name('password.email');

    Route::get('verify-otp', [OtpForgotPasswordController::class, 'showResetForm'])
        ->name('password.otp.reset.form');

    Route::post('verify-otp', [OtpForgotPasswordController::class, 'resetPassword'])
        ->name('password.otp.update');

    Route::post('resend-otp', [OtpForgotPasswordController::class, 'resendOtp'])
        ->name('password.otp.resend');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // --- FITUR CONFIGURE IP SYSTEM ---
    Route::prefix('ip-config')->name('ip-config.')->group(function () {
        Route::get('/', [IpConfigController::class, 'index'])
            ->middleware('can:view-ip_config') // Diproteksi permission
            ->name('index');
            
        Route::post('/update', [IpConfigController::class, 'update'])
            ->middleware('can:edit-ip_config') // Diproteksi permission
            ->name('update');
    });
});