<?php

namespace App\Http\Controllers;

use App\Models\Tahapan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// Import Library Excel
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermohonanExport;

class TahapanController extends Controller
{
    /**
     * Menampilkan daftar tahapan.
     */
    public function index()
    {
        $tahapans = Tahapan::withCount('permohonans')->oldest()->get();
        return view('tahapans.index', compact('tahapans'));
    }

    /**
     * Form tambah tahapan.
     */
    public function create()
    {
        return view('tahapans.create');
    }

    /**
     * Simpan tahapan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tahapan' => ['required', 'string', 'max:255', Rule::unique('tahapans', 'nama_tahapan')],
            'tanggal_buka' => 'required|date',
            'status' => 'required|in:Rekap,Proses,Cair', 
            'keterangan' => 'nullable|string',
        ]);

        Tahapan::create($validated);

        return redirect()->route('tahapans.index')->with('toast_success', 'Tahapan baru berhasil ditambahkan!');
    }

    /**
     * Form edit tahapan.
     */
    public function edit(Tahapan $tahapan)
    {
        return view('tahapans.edit', compact('tahapan'));
    }

    /**
     * Update data tahapan.
     */
    public function update(Request $request, Tahapan $tahapan)
    {
        // 1. Validasi
        $rules = [
            'nama_tahapan' => ['required', 'string', 'max:255', Rule::unique('tahapans', 'nama_tahapan')->ignore($tahapan->id)],
            'tanggal_buka' => 'required|date',
            'status' => 'required|in:Rekap,Proses,Cair',
            'keterangan' => 'nullable|string',
        ];

        // Jika status diubah jadi Cair, tanggal tutup wajib diisi
        if ($request->status == 'Cair') {
            $rules['tanggal_tutup'] = 'required|date';
        }

        $validated = $request->validate($rules);

        // 2. Logika Tanggal Tutup
        if ($request->status == 'Rekap' || $request->status == 'Proses') {
            $tahapan->tanggal_tutup = null; // Reset jika belum cair
        } 
        else if ($request->status == 'Cair') {
            $tahapan->tanggal_tutup = $request->tanggal_tutup;
        }

        // 3. Update Data
        $tahapan->nama_tahapan = $request->nama_tahapan;
        $tahapan->tanggal_buka = $request->tanggal_buka;
        $tahapan->status = $request->status;
        $tahapan->keterangan = $request->keterangan;
        
        $tahapan->save();

        return redirect()->route('tahapans.index')->with('toast_success', 'Data tahapan berhasil diperbarui.');
    }

    /**
     * Fungsi untuk Tombol Gembok (Buka/Tutup Cepat).
     * Close = Cair, Open = Kembali ke Rekap.
     */
    public function toggleStatus(Request $request, Tahapan $tahapan)
    {
        $action = $request->input('action');

        if ($action == 'close') {
            // Tutup Tahapan (Cair)
            $request->validate(['tanggal_tutup' => 'required|date']);

            $tahapan->status = 'Cair'; 
            $tahapan->tanggal_tutup = $request->tanggal_tutup;
            $message = 'Tahapan ditutup dan dana dicairkan. Data dikunci.';
        
        } else {
            // Buka Kembali (Kembali ke Rekap agar bisa edit data)
            $tahapan->status = 'Rekap'; 
            $tahapan->tanggal_tutup = null;
            $message = 'Tahapan dibuka kembali (Status: Rekap). Silakan kelola data.';
        }

        $tahapan->save();

        return redirect()->route('tahapans.index')->with('toast_success', $message);
    }

    public function export(Tahapan $tahapan)
    {
        // Nama file output
        $fileName = 'Rekapitulasi Santunan Kematian ' . str_replace(' ', '-', $tahapan->nama_tahapan) . '.xlsx';
        
        // Download menggunakan Maatwebsite Excel
        return Excel::download(new PermohonanExport($tahapan), $fileName);
    }
}