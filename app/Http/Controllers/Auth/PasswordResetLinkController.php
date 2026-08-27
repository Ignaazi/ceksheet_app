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
     * Show the forgot password request form (NIK & Email).
     */
    public function showForgotForm()
    {
        // 1. Tampilkan halaman Form Input NIK & Email
        return view('auth.forgot-password');
    }

    /**
     * Step 1: Generate and Send 5-digit OTP to Email.
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

        // Generate 5-digit random OTP
        $otp = (string) rand(10000, 99999);

        // Store or Update OTP in database (Valid for 10 minutes)
        DB::table('password_otps')->updateOrInsert(
            ['nik' => $request->nik],
            [
                'otp_code'   => Hash::make($otp),
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => Carbon::now()
            ]
        );

        // Send OTP via Email
        Mail::raw("Your Password Reset OTP Code is: {$otp}\n\nThis code will expire in 10 minutes. Do not share this code with anyone.", function ($message) use ($request) {
            $message->to($request->email)->subject('Password Reset OTP Code - Ceksheet Application');
        });

        // Store NIK & Email in session for verification process
        session(['reset_nik' => $request->nik, 'reset_email' => $request->email]);

        // Redirect ke Halaman Input OTP
        return redirect()->route('password.otp.reset.form', ['nik' => $request->nik])
            ->with('status', 'A 5-digit OTP code has been sent to your email!');
    }

    /**
     * Show OTP Verification & New Password Form.
     */
    public function showResetForm(Request $request)
    {
        $nik = $request->query('nik', session('reset_nik'));

        if (!$nik) {
            return redirect()->route('password.request')->withErrors(['nik' => 'Session expired. Please enter your NIK again.']);
        }

        // 2. Tampilkan halaman Form Input 5-Digit OTP & Password Baru
        return view('auth.reset-password-otp', [
            'nik' => $nik
        ]);
    }

    /**
     * Step 2: Resend 5-digit OTP Code.
     */
    public function resendOtp(Request $request)
    {
        $nik = $request->input('nik', session('reset_nik'));
        $email = session('reset_email');

        if (!$nik || !$email) {
            return back()->withErrors(['otp' => 'Session expired. Please restart the forgot password process.']);
        }

        // Generate new 5-digit OTP
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
     * Step 3: Verify OTP & Reset Password.
     */
    public function resetPassword(Request $request)
    {
        // Handle OTP input from separate 5 input boxes array or single field
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

        // Check if OTP exists & expiration
        if (!$otpRecord || Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return back()->withInput()->withErrors(['otp' => 'The OTP code has expired or is invalid! Please request a new one.']);
        }

        // Verify OTP Hash
        if (!Hash::check((string) $request->otp_code, $otpRecord->otp_code)) {
            return back()->withInput()->withErrors(['otp' => 'The OTP code you entered is incorrect.']);
        }

        // Update User Password
        User::where('nik', $request->nik)->update([
            'password' => Hash::make((string) $request->password)
        ]);

        // Delete used OTP
        DB::table('password_otps')->where('nik', $request->nik)->delete();
        session()->forget(['reset_nik', 'reset_email']);

        return redirect()->route('login')->with('status', 'Your password has been reset successfully! You can now log in.');
    }
}