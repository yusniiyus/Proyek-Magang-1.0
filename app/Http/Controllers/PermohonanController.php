<?php

namespace App\Http\Controllers;

use App\Models\Tahapan;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PermohonanController extends Controller
{
    public function index(Request $request, Tahapan $tahapan)
    {
        $query = $tahapan->permohonans()->latest();

        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_meninggal', 'like', "%{$search}%")
                  ->orWhere('nama_ahli_waris', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%");
            });
        }

        $permohonans = $query->get();
        return view('permohonans.index', compact('tahapan', 'permohonans'));
    }

    public function create(Tahapan $tahapan)
    {
        if ($tahapan->status != 'Rekap') {
            return redirect()->route('permohonans.index', $tahapan->id)
                ->with('toast_error', 'Maaf, Tahapan ini sudah diproses/cair. Tidak bisa menambah data lagi.');
        }
        return view('permohonans.create', compact('tahapan'));
    }

    public function store(Request $request, Tahapan $tahapan)
    {
        if ($tahapan->status != 'Rekap') {
            return redirect()->route('permohonans.index', $tahapan->id)
                ->with('toast_error', 'Gagal! Tahapan sudah diproses.');
        }

        // 1. Validasi (TANPA STATUS)
        $validated = $request->validate([
            'nama_meninggal' => 'required|string|max:255',
            'nik_meninggal' => ['required', 'string', 'digits:16', Rule::unique('permohonans')],
            'kk_meninggal' => 'required|string|digits:16',
            'jenis_kelamin_meninggal' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tanggal_kematian' => 'required|date',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'kelurahan' => 'required|string',
            'kecamatan' => 'required|string',
            'nama_ahli_waris' => 'required|string',
            'nomor_telepon' => 'required|string',
            'jenis_bank' => 'required|in:KALSEL,KALSEL SYARIAH',
            'nomor_rekening' => 'required|string',
            'nama_pemilik_rekening' => 'required|string',
            'catatan' => 'nullable|string', // Hanya Catatan
        ]);

        // 2. Tambah ID Tahapan
        $validated['tahapan_id'] = $tahapan->id;

        // 3. Simpan
        Permohonan::create($validated);

        return redirect()->route('permohonans.index', $tahapan->id)
            ->with('toast_success', 'Data berhasil ditambahkan');
    }

    public function edit(Tahapan $tahapan, Permohonan $permohonan)
    {
        if($permohonan->tahapan_id !== $tahapan->id) abort(404);
        return view('permohonans.edit', compact('tahapan', 'permohonan'));
    }

    public function update(Request $request, Tahapan $tahapan, Permohonan $permohonan)
    {
        if($permohonan->tahapan_id !== $tahapan->id) abort(404);

        // 1. Validasi Update (TANPA STATUS)
        $validated = $request->validate([
            'nama_meninggal' => 'required|string|max:255',
            'nik_meninggal' => ['required', 'string', 'digits:16', Rule::unique('permohonans')->ignore($permohonan->id)],
            'kk_meninggal' => 'required|string|digits:16',
            'jenis_kelamin_meninggal' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tanggal_kematian' => 'required|date',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'kelurahan' => 'required|string',
            'kecamatan' => 'required|string',
            'nama_ahli_waris' => 'required|string',
            'nomor_telepon' => 'required|string',
            'jenis_bank' => 'required|in:KALSEL,KALSEL SYARIAH',
            'nomor_rekening' => 'required|string',
            'nama_pemilik_rekening' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        // 2. Update
        $permohonan->update($validated);

        return redirect()->route('permohonans.index', $tahapan->id)
            ->with('toast_success', 'Data berhasil diperbarui');
    }

    public function destroy(Tahapan $tahapan, Permohonan $permohonan)
    {
        try {
            if($permohonan->tahapan_id !== $tahapan->id) abort(404);

            if ($tahapan->status != 'Rekap') {
                return redirect()->back()
                    ->with('toast_error', 'Gagal! Tahapan ini sudah diproses. Data tidak bisa dihapus.');
            }

            $permohonan->delete();

            return redirect()->route('permohonans.index', $tahapan->id)
                ->with('toast_success', 'Data santunan berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Gagal hapus: ' . $e->getMessage());
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan sistem.');
        }
    }
}