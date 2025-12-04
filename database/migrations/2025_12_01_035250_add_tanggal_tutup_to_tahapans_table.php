<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tahapans', function (Blueprint $table) {
            // Menambahkan kolom tanggal_tutup setelah tanggal_buka
            $table->date('tanggal_tutup')->nullable()->after('tanggal_buka');
        });
    }

    public function down(): void
    {
        Schema::table('tahapans', function (Blueprint $table) {
            $table->dropColumn('tanggal_tutup');
        });
    }
};