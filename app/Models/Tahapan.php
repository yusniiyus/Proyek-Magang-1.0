<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tahapan extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_tahapan',
        'tanggal_buka',
        'status',
        'keterangan',
    ];

    /**
     * Mendefinisikan relasi "satu-ke-banyak".
     * Satu 'Tahapan' bisa memiliki banyak 'Permohonan'.
     * * Relasi ini memungkinkan pemanggilan:
     * 1. $tahapan->permohonans (Mengambil seluruh data)
     * 2. Tahapan::withCount('permohonans') (Menghitung jumlah data)
     */
    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class);
    }
}