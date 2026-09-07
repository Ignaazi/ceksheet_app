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
        Schema::table('approval_templates', function (Blueprint $table) {
            // Menambahkan kolom blade_view setelah kolom name
            $table->string('blade_view')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approval_templates', function (Blueprint $table) {
            // Menghapus kolom blade_view jika migration di-rollback
            $table->dropColumn('blade_view');
        });
    }
};