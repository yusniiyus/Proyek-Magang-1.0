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
        Schema::table('permohonans', function (Blueprint $table) {
            // Ubah agar boleh kosong (nullable)
            $table->text('keterangan')->nullable()->change();

            // Atau jika kamu ingin menyamakan istilah, bisa ubah nama kolomnya:
            $table->renameColumn('keterangan', 'catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            //
        });
    }
};
