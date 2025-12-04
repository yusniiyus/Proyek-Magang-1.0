<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Perintah untuk MEMBUAT tabel 'tahapans'
        Schema::create('tahapans', function (Blueprint $table) {
            $table->id(); // Kolom ID (Primary Key)
            
            // Ini adalah kolom-kolom yang hilang di database Anda:
            $table->string('nama_tahapan')->unique(); // Nama unik, misal: "Tahap 1 - 2024"
            $table->date('tanggal_buka');
            $table->enum('status', ['Dibuka', 'Ditutup'])->default('Dibuka');
            $table->text('keterangan')->nullable(); // Opsional
            
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Perintah untuk MENGHAPUS tabel 'tahapans'
        Schema::dropIfExists('tahapans');
    }
};