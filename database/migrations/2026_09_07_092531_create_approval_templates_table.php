<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_templates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Contoh: TPL-001 / WI-SW-01
            $table->string('name'); // Contoh: Custom Checklist Line A
            $table->string('category')->nullable(); // SMT, Assembly, Quality, dll
            $table->text('description')->nullable();
            $table->string('icon')->default('fa-file-invoice'); // Class FontAwesome
            $table->string('color')->default('#0984e3'); // Warna tema badge/icon
            $table->json('schema')->nullable(); // Menampung struktur field/form checklist dinamis (opsional)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_templates');
    }
};