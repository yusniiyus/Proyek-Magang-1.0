{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- 1. Judul Halaman (Browser) --}}
@section('title', 'Tambah Tahapan')

{{-- 2. Judul Halaman (Konten) --}}
@section('page-title', 'Tambah Tahapan Baru')

{{-- 3. Breadcrumb --}}
@section('breadcrumb')
    <div class="header-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a> > 
        <a href="{{ route('tahapans.index') }}">Santunan Kematian</a> > 
        Tambah Tahapan
    </div>
@endsection

{{-- 4. Konten Utama --}}
@section('content')

    {{-- Tombol Kembali --}}
    <div class="page-header-extra">
        <a href="{{ route('tahapans.index') }}" class="btn btn-secondary">
            <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Card untuk Form --}}
    <div class="card">
        <div class="card-header">
            <h3>Formulir Tahapan</h3>
            <p>Isi data di bawah ini untuk membuat *batch* permohonan baru.</p>
        </div>
        
        <form action="{{ route('tahapans.store') }}" method="POST">
            @csrf
            <div class="card-body">
                
                {{-- Baris 1: Nama Tahapan (WAJIB) --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        {{-- Tambahkan tanda bintang merah (*) untuk penanda visual wajib --}}
                        <label for="nama_tahapan">Nama Tahapan <span class="text-danger">*</span></label>
                        <input type="text" 
                               id="nama_tahapan" 
                               name="nama_tahapan" 
                               class="form-control @error('nama_tahapan') is-invalid @enderror" 
                               value="{{ old('nama_tahapan') }}" 
                               placeholder="Contoh: Tahap 1 - 2024"
                               required autofocus>
                        @error('nama_tahapan')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Baris 2: Tanggal Buka (WAJIB) --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="tanggal_buka">Tanggal Buka <span class="text-danger">*</span></label>
                        <input type="date" 
                               id="tanggal_buka" 
                               name="tanggal_buka" 
                               class="form-control @error('tanggal_buka') is-invalid @enderror" 
                               value="{{ old('tanggal_buka', date('Y-m-d')) }}" 
                               required>
                        @error('tanggal_buka')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Baris 3: Status (OTOMATIS REKAP - READONLY) --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="status_display">Status Awal</label>
                        
                        {{-- Input Tampilan (Disabled/Readonly) --}}
                        <input type="text" 
                               id="status_display" 
                               class="form-control" 
                               value="Rekap (Masa Input Data)" 
                               readonly 
                               style="background-color: #e9ecef; cursor: not-allowed; color: #495057;">
                        
                        {{-- Input Hidden untuk mengirim nilai "Rekap" ke database --}}
                        <input type="hidden" name="status" value="Rekap">

                        <small class="text-muted" style="margin-top: 5px; display: block;">
                            Status awal otomatis diatur ke <strong>Rekap</strong> agar Anda bisa langsung menginput data santunan.
                        </small>
                    </div>
                </div>

                {{-- Baris 4: Keterangan (OPSIONAL) --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="keterangan">Keterangan (Opsional)</label>
                        <textarea id="keterangan" 
                                  name="keterangan" 
                                  class="form-control @error('keterangan') is-invalid @enderror" 
                                  rows="3">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- Footer Card: Tombol Aksi --}}
            <div class="card-footer">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Simpan Tahapan</button>
            </div>
        </form>
    </div>

@endsection