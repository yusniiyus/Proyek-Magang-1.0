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
        // Membuat tabel 'permohonans' (Anak)
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap permohonan

            // --- KUNCI RELASI (PENTING) ---
            // Kolom ini menghubungkan setiap permohonan ke 'tahapan' induknya.
            $table->unsignedBigInteger('tahapan_id');
            // onDelete('cascade') berarti jika 'Tahapan' dihapus, semua data di dalamnya ikut terhapus.
            $table->foreign('tahapan_id')->references('id')->on('tahapans')->onDelete('cascade');

            // --- 1. Data Almarhum/ah ---
            $table->string('nama_meninggal');
            $table->string('nik_meninggal', 16)->unique(); // NIK kita buat unik
            $table->string('kk_meninggal', 16); // Nomor Kartu Keluarga
            $table->enum('jenis_kelamin_meninggal', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->date('tanggal_kematian');
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('kelurahan');
            $table->string('kecamatan');

            // --- 2. Data Pemohon (Ahli Waris) ---
            $table->string('nama_ahli_waris');
            $table->string('nomor_telepon', 15);

            // --- 3. Data Pencairan (Bank) ---
            $table->enum('jenis_bank', ['KALSEL', 'KALSEL SYARIAH']); // Pilihan Bank
            $table->string('nomor_rekening', 20);
            $table->string('nama_pemilik_rekening');

            $table->timestamps(); // Otomatis membuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};