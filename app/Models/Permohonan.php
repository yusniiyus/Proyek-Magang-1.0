<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permohonan extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tahapan_id',
        'nama_meninggal',
        'nik_meninggal',
        'kk_meninggal',
        'jenis_kelamin_meninggal',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_kematian',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'nama_ahli_waris',
        'nomor_telepon',
        'jenis_bank',
        'nomor_rekening',
        'nama_pemilik_rekening',
    ];

    /**
     * Mendefinisikan relasi "milik-ke".
     * Satu 'Permohonan' hanya dimiliki oleh satu 'Tahapan'.
     */
    public function tahapan(): BelongsTo
    {
        return $this->belongsTo(Tahapan::class);
    }
}