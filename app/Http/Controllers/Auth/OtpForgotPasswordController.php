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
     * Tampilkan halaman request OTP (masukkan NIK & Email tujuan).
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password-otp');
    }

    /**
     * Step 1: Generate dan Kirim OTP ke Email Karyawan.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'numeric', 'exists:users,nik'],
            'email' => ['required', 'email'],
        ], [
            'nik.exists' => 'NIK tidak terdaftar dalam sistem.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'email.email' => 'Format email tidak valid.',
        ]);

        // Generate 6 digit OTP acak
        $otp = (string) rand(100000, 999999);

        // Simpan/Update OTP ke database (berlaku 10 menit)
        DB::table('password_otps')->updateOrInsert(
            ['nik' => $request->nik],
            [
                'otp_code' => Hash::make($otp),
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => Carbon::now()
            ]
        );

        // Kirim OTP via Email
        Mail::raw("Kode OTP Reset Password Anda adalah: {$otp}\n\nKode ini berlaku selama 10 menit. Jangan berikan kode ini kepada siapapun.", function ($message) use ($request) {
            $message->to($request->email)->subject('Kode OTP Reset Password Ceksheet Approval');
        });

        // Redirect ke halaman input OTP & Password Baru membawa data NIK
        return redirect()->route('password.otp.reset.form', ['nik' => $request->nik])
            ->with('status', 'Kode OTP telah dikirimkan ke email Anda!');
    }

    /**
     * Tampilkan halaman verifikasi OTP & form password baru.
     */
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password-otp', [
            'nik' => $request->query('nik')
        ]);
    }

    /**
     * Step 2: Verifikasi OTP & Update Password Baru (Hanya Angka).
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'numeric', 'exists:users,nik'],
            'otp_code' => ['required', 'numeric'],
            'password' => ['required', 'numeric', 'min:4', 'confirmed'], // Password baru berupa angka minimal 4 digit
        ], [
            'password.numeric' => 'Password baru wajib berupa angka.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password minimal terdiri dari 4 angka.',
        ]);

        $otpRecord = DB::table('password_otps')->where('nik', $request->nik)->first();

        // Validasi keberadaan OTP & batas kadaluarsa
        if (!$otpRecord || Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return back()->withInput()->withErrors(['otp_code' => 'Kode OTP sudah kadaluarsa atau tidak valid! Silakan minta ulang.']);
        }

        // Validasi kecocokan kode OTP
        if (!Hash::check((string) $request->otp_code, $otpRecord->otp_code)) {
            return back()->withInput()->withErrors(['otp_code' => 'Kode OTP yang Anda masukkan salah!']);
        }

        // Update password user di tabel users
        User::where('nik', $request->nik)->update([
            'password' => Hash::make((string) $request->password)
        ]);

        // Hapus data OTP setelah berhasil di-reset
        DB::table('password_otps')->where('nik', $request->nik)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil diubah, silakan login menggunakan password baru Anda.');
    }
}