<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OtpForgotPasswordController extends Controller
{
    /**
     * Step 1: Tampilkan Halaman Input NIK & Email
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password'); 
    }

    /**
     * Step 1 Action: Generate & Kirim OTP ke Email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'nik'   => ['required', 'string', 'exists:users,nik'],
            'email' => ['required', 'email'],
        ], [
            'nik.required'   => 'The NIK field is required.',
            'nik.exists'     => 'This NIK is not registered in our system.',
            'email.required' => 'The recipient email address is required.',
            'email.email'    => 'Please provide a valid email address.',
        ]);

        $otp = (string) rand(10000, 99999);

        DB::table('password_otps')->updateOrInsert(
            ['nik' => $request->nik],
            [
                'otp_code'   => Hash::make($otp),
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => Carbon::now()
            ]
        );

        Mail::raw("Your Password Reset OTP Code is: {$otp}\n\nThis code will expire in 10 minutes.", function ($message) use ($request) {
            $message->to($request->email)->subject('Password Reset OTP Code - Ceksheet Application');
        });

        session(['reset_nik' => $request->nik, 'reset_email' => $request->email]);

        return redirect()->route('password.otp.reset.form', ['nik' => $request->nik])
            ->with('status', 'A 5-digit OTP code has been sent to your email!');
    }

    /**
     * Step 2: Tampilkan Halaman Form Input OTP & Password Baru
     */
    public function showResetForm(Request $request)
    {
        $nik = $request->query('nik', session('reset_nik'));

        if (!$nik) {
            return redirect()->route('password.request')->withErrors(['nik' => 'Session expired. Please enter your NIK again.']);
        }

        // Sudah disesuaikan memanggil forgot-password-otp.blade.php
        return view('auth.forgot-password-otp', [
            'nik' => $nik
        ]);
    }

    /**
     * Step 2 Action: Kirim Ulang Kode OTP
     */
    public function resendOtp(Request $request)
    {
        $nik = $request->input('nik', session('reset_nik'));
        $email = session('reset_email');

        if (!$nik || !$email) {
            return back()->withErrors(['otp' => 'Session expired. Please restart the process.']);
        }

        $otp = (string) rand(10000, 99999);

        DB::table('password_otps')->updateOrInsert(
            ['nik' => $nik],
            [
                'otp_code'   => Hash::make($otp),
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => Carbon::now()
            ]
        );

        Mail::raw("Your new Password Reset OTP Code is: {$otp}\n\nThis code will expire in 10 minutes.", function ($message) use ($email) {
            $message->to($email)->subject('Resent OTP Code - Ceksheet Application');
        });

        return back()->with('status', 'A new 5-digit OTP code has been resent to your email.');
    }

    /**
     * Step 3 Action: Verifikasi OTP & Simpan Password Baru
     */
    public function resetPassword(Request $request)
    {
        $otpArray = $request->input('otp');
        $otpInput = is_array($otpArray) ? implode('', $otpArray) : $request->input('otp_code');

        $request->merge(['otp_code' => $otpInput]);

        $request->validate([
            'nik'      => ['required', 'string', 'exists:users,nik'],
            'otp_code' => ['required', 'numeric', 'digits:5'],
            'password' => ['required', 'numeric', 'min:4', 'confirmed'],
        ], [
            'otp_code.required'  => 'Please enter the full 5-digit OTP code.',
            'otp_code.digits'    => 'The OTP code must be exactly 5 digits.',
            'password.required'  => 'The new password field is required.',
            'password.numeric'   => 'The new password must contain numbers only.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min'       => 'The password must be at least 4 digits long.',
        ]);

        $otpRecord = DB::table('password_otps')->where('nik', $request->nik)->first();

        if (!$otpRecord || Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return back()->withInput()->withErrors(['otp' => 'The OTP code has expired or is invalid!']);
        }

        if (!Hash::check((string) $request->otp_code, $otpRecord->otp_code)) {
            return back()->withInput()->withErrors(['otp' => 'The OTP code you entered is incorrect.']);
        }

        User::where('nik', $request->nik)->update([
            'password' => Hash::make((string) $request->password)
        ]);

        DB::table('password_otps')->where('nik', $request->nik)->delete();
        session()->forget(['reset_nik', 'reset_email']);

        return redirect()->route('login')->with('status', 'Your password has been reset successfully! You can now log in.');
    }
}