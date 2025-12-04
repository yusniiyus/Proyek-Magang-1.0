<?php

namespace App\Http\Controllers;

use App\Models\Tahapan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermohonanExport;

class TahapanController extends Controller
{
    public function index()
    {
        $tahapans = Tahapan::withCount('permohonans')->oldest()->get();
        return view('tahapans.index', compact('tahapans'));
    }

    public function create()
    {
        return view('tahapans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tahapan' => ['required', 'string', 'max:255', Rule::unique('tahapans', 'nama_tahapan')],
            'tanggal_buka' => 'required|date',
            // Default status saat buat baru biasanya 'Rekap'
            'status' => 'required|in:Rekap,Proses,Cair', 
            'keterangan' => 'nullable|string',
        ]);

        Tahapan::create($validated);

        return redirect()->route('tahapans.index')->with('toast_success', 'Tahapan baru berhasil ditambahkan!');
    }

    public function edit(Tahapan $tahapan)
    {
        return view('tahapans.edit', compact('tahapan'));
    }

    public function update(Request $request, Tahapan $tahapan)
    {
        // 1. Validasi Dasar
        $rules = [
            'nama_tahapan' => ['required', 'string', 'max:255', Rule::unique('tahapans', 'nama_tahapan')->ignore($tahapan->id)],
            'tanggal_buka' => 'required|date',
            'status' => 'required|in:Rekap,Proses,Cair',
            'keterangan' => 'nullable|string',
        ];

        // 2. Validasi Tambahan: Jika status 'Cair', Tanggal Tutup (Cair) WAJIB diisi
        if ($request->status == 'Cair') {
            $rules['tanggal_tutup'] = 'required|date';
        }

        $validated = $request->validate($rules);

        // 3. Logika Tanggal Tutup
        // Jika status Rekap atau Proses, tanggal_tutup harus NULL (karena belum cair)
        if ($request->status == 'Rekap' || $request->status == 'Proses') {
            $tahapan->tanggal_tutup = null;
        } 
        // Jika status Cair, ambil dari inputan
        else if ($request->status == 'Cair') {
            $tahapan->tanggal_tutup = $request->tanggal_tutup;
        }

        // 4. Update data lainnya
        $tahapan->nama_tahapan = $request->nama_tahapan;
        $tahapan->tanggal_buka = $request->tanggal_buka;
        $tahapan->status = $request->status;
        $tahapan->keterangan = $request->keterangan;
        
        $tahapan->save();

        return redirect()->route('tahapans.index')->with('toast_success', 'Data tahapan berhasil diperbarui.');
    }

    // Fungsi Toggle Status (Gembok) di Index bisa kita hapus atau sesuaikan
    // Tapi karena ada 3 status, lebih aman pakai menu Edit saja biar jelas.
    // Jika masih mau pakai tombol simple, nanti kita bahas lagi.
    public function toggleStatus(Request $request, Tahapan $tahapan)
    {
        // ... (Opsional: logic ini jadi agak rumit kalau 3 status, 
        // lebih baik arahkan user ke menu Edit saja)
    }

    public function export(Tahapan $tahapan)
    {
        // ... (Kode export sama seperti sebelumnya) ...
    }
}