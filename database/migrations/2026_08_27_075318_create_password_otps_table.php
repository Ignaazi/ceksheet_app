<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('password_otps', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->index(); // NIK karyawan penyerah request OTP
            $table->string('otp_code');    // Kode OTP 6 digit (hashed)
            $table->timestamp('expires_at'); // Batas waktu kadaluarsa OTP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_otps');
    }
};