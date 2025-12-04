{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Tahapan')
@section('page-title', 'Edit Data Tahapan')

@section('breadcrumb')
    <div class="header-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a> /
        <a href="{{ route('tahapans.index') }}">Manajemen Tahapan</a> /
        <span>Edit Tahapan</span>
    </div>
@endsection

@section('content')

<div class="page-header-extra">
    <a href="{{ route('tahapans.index') }}" class="btn btn-secondary">
        <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Daftar Tahapan
    </a>
</div>

<div class="page-content">
    <div class="card">
        <div class="card-header">
            <h3>Formulir Edit Tahapan</h3>
            <p>Silakan ubah informasi tahapan di bawah ini.</p>
        </div>

        <form action="{{ route('tahapans.update', $tahapan) }}" method="POST">
            @csrf
            @method('PUT') 
            
            <div class="card-body">
                
                {{-- Nama Tahapan --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="nama_tahapan">Nama Tahapan</label>
                        <input type="text" class="form-control @error('nama_tahapan') is-invalid @enderror" 
                               id="nama_tahapan" name="nama_tahapan" 
                               value="{{ old('nama_tahapan', $tahapan->nama_tahapan) }}" required>
                        @error('nama_tahapan') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Tanggal Buka --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="tanggal_buka">Tanggal Dibuka</label>
                        <input type="date" class="form-control @error('tanggal_buka') is-invalid @enderror" 
                               id="tanggal_buka" name="tanggal_buka" 
                               value="{{ old('tanggal_buka', $tahapan->tanggal_buka) }}" required>
                        @error('tanggal_buka') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Status (3 Pilihan) --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="status">Status Tahapan</label>
                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required onchange="checkStatus()">
                            <option value="Rekap" {{ old('status', $tahapan->status) == 'Rekap' ? 'selected' : '' }}>
                                1. Rekap (Input Data Berjalan)
                            </option>
                            <option value="Proses" {{ old('status', $tahapan->status) == 'Proses' ? 'selected' : '' }}>
                                2. Proses (Pengajuan Pencairan)
                            </option>
                            <option value="Cair" {{ old('status', $tahapan->status) == 'Cair' ? 'selected' : '' }}>
                                3. Cair (Dana Tersalurkan/Tutup)
                            </option>
                        </select>
                        <small class="text-muted" id="statusHelpText"></small>
                        @error('status') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Tanggal Cair (Hanya muncul jika status 'Cair') --}}
                <div class="form-row" id="row_tanggal_tutup" style="display: none;">
                    <div class="form-group-flex">
                        <label for="tanggal_tutup" style="color: #198754; font-weight: bold;">Tanggal Pencairan Dana</label>
                        <input type="date" class="form-control @error('tanggal_tutup') is-invalid @enderror" 
                               id="tanggal_tutup" name="tanggal_tutup" 
                               value="{{ old('tanggal_tutup', $tahapan->tanggal_tutup ?? date('Y-m-d')) }}">
                        <small class="text-muted">Masukkan tanggal dana dicairkan.</small>
                        @error('tanggal_tutup') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- KETERANGAN (BARU DITAMBAHKAN) --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="keterangan">Keterangan (Opsional)</label>
                        <textarea id="keterangan" 
                                  name="keterangan" 
                                  class="form-control @error('keterangan') is-invalid @enderror" 
                                  rows="3">{{ old('keterangan', $tahapan->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('tahapans.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function checkStatus() {
        const status = document.getElementById('status').value;
        const rowTgl = document.getElementById('row_tanggal_tutup');
        const inputTgl = document.getElementById('tanggal_tutup');
        const helpText = document.getElementById('statusHelpText');

        // Logika Tampilan & Keterangan
        if (status === 'Rekap') {
            rowTgl.style.display = 'none';
            inputTgl.removeAttribute('required');
            helpText.innerText = "Tahapan dibuka. Bisa Tambah, Edit, dan Hapus data.";
        } 
        else if (status === 'Proses') {
            rowTgl.style.display = 'none';
            inputTgl.removeAttribute('required');
            helpText.innerText = "Tahapan dikunci sementara untuk pengajuan. Tidak bisa Tambah/Hapus data.";
        } 
        else if (status === 'Cair') {
            rowTgl.style.display = 'block';
            inputTgl.setAttribute('required', 'required'); // Wajib isi jika Cair
            helpText.innerText = "Tahapan selesai/ditutup. Dana sudah cair.";
        }
    }

    // Jalankan saat load halaman
    document.addEventListener('DOMContentLoaded', function() {
        checkStatus();
    });
</script>

@endsection