<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('line_name');
            $table->string('machine_type');
            $table->json('ai_result'); // Menyimpan respon JSON dari OpenAI
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_sheets');
    }
};