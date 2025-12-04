<?php

namespace App\Exports;

use App\Models\Tahapan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PermohonanExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $tahapan;

    // Menerima data tahapan dari Controller
    public function __construct(Tahapan $tahapan)
    {
        $this->tahapan = $tahapan;
    }

    // Mengambil tampilan dari file Blade
    public function view(): View
    {
        return view('exports.permohonan', [
            'tahapan' => $this->tahapan,
            // Mengambil semua permohonan milik tahapan ini
            'permohonans' => $this->tahapan->permohonans,
        ]);
    }

    // Style tambahan (Menebalkan Header)
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 14]], // Judul Utama
            2    => ['font' => ['bold' => true, 'size' => 12]], // Sub Judul
            4    => ['font' => ['bold' => true]], // Header Tabel (Baris ke-4)
        ];
    }
}