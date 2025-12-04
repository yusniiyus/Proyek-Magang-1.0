{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- 1. Judul Halaman --}}
@section('title', 'Data Santunan: ' . $tahapan->nama_tahapan)

{{-- 2. Konten Header --}}
@section('page-title')
    Data Santunan
    <span class="header-breadcrumb-tahapan">Tahap: {{ $tahapan->nama_tahapan }}</span>
@endsection

{{-- 3. Breadcrumb --}}
@section('breadcrumb')
    <div class="header-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a> /
        <a href="{{ route('tahapans.index') }}">Santunan Kematian</a> /
        <span>Data Santunan</span>
    </div>
@endsection

{{-- 4. Konten Utama --}}
@section('content')

<div class="page-header-extra">
    <a href="{{ route('tahapans.index') }}" class="btn btn-secondary">
        <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
        Kembali ke Daftar Tahapan
    </a>
</div>

<div class="page-header">
    {{-- Tombol Export Excel (Selalu Muncul) --}}
    <a href="{{ route('tahapans.export', $tahapan) }}" class="btn btn-success" style="margin-right: 10px;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="nav-icon-btn">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        Export Excel
    </a>

    {{-- LOGIKA BARU: Hanya muncul jika status REKAP --}}
    @if($tahapan->status == 'Rekap')
        <a href="{{ route('permohonans.create', $tahapan) }}" class="btn btn-action btn-success btn-primary">
            <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Data Santunan
        </a>
    @elseif($tahapan->status == 'Proses')
        <span class="badge badge-warning" style="padding: 10px;">Status: Sedang Proses Pengajuan Pencairan</span>
    @else
        <span class="badge badge-success" style="padding: 10px;">Status: Dana Santunan Kematian Sudah Cair ({{ \Carbon\Carbon::parse($tahapan->tanggal_tutup)->format('d-m-Y') }})</span>
    @endif
</div>

<div class="page-content">
    <div class="card">
        <div class="card-header">
            <h3>Daftar Permohonan Santunan</h3>
            <p>Berikut adalah seluruh data permohonan yang terdaftar dalam <strong>{{ $tahapan->nama_tahapan }}</strong>.</p>
            {{-- Bagian Kanan: Form Pencarian --}}
            <div class="search-box">
                <form action="{{ route('permohonans.index', $tahapan) }}" method="GET" style="display: flex; gap: 5px;">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari Nama / Ahli Waris / Kelurahan..." 
                           value="{{ request('search') }}" 
                           style="min-width: 250px;">
                    
                    <button type="submit" class="btn btn-primary" title="Cari">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>

                    {{-- Tombol Reset (Muncul jika sedang mencari) --}}
                    @if(request('search'))
                        <a href="{{ route('permohonans.index', $tahapan) }}" class="btn btn-secondary" title="Reset Pencarian">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA ALMARHUM/AH</th>
                            <th>AHLI WARIS</th>
                            <th>KELURAHAN</th>
                            <th>NO. REKENING</th>
                            <th>BANK</th>
                            <th style="min-width: 120px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permohonans as $permohonan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-semibold">{{ $permohonan->nama_meninggal }}</td>
                                <td>{{ $permohonan->nama_ahli_waris }}</td>
                                <td>{{ $permohonan->kelurahan }}</td>
                                
                                @if($permohonan->jenis_bank == 'KALSEL SYARIAH')
                                    <td class="highlight-syariah">
                                        {{ $permohonan->nomor_rekening }}
                                        <span class="tooltip-syariah">Kalsel Syariah</span>
                                    </td>
                                    <td>Kalsel Syariah</td>
                                @else
                                    <td>{{ $permohonan->nomor_rekening }}</td>
                                    <td>Kalsel</td>
                                @endif

                                <td>
                                    <div class="table-action">
                                        {{-- Tombol Edit (Selalu Muncul - Untuk koreksi typo) --}}
                                        <a href="{{ route('permohonans.edit', [$tahapan, $permohonan]) }}" class="btn-action btn-warning" title="Edit Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                        </a>

                                        {{-- LOGIKA 2: Tombol Hapus HANYA Muncul Jika Status DIBUKA --}}
                                        @if($tahapan->status == 'Dibuka')
                                            <button type="button" 
                                                    class="btn-action btn-danger delete-button" 
                                                    title="Hapus Data"
                                                    data-action="{{ route('permohonans.destroy', [$tahapan->id, $permohonan->id]) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data permohonan untuk tahapan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL & SCRIPT HAPUS --}}
<form id="deleteForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');
        const deleteForm = document.getElementById('deleteForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const actionUrl = this.getAttribute('data-action');
                deleteForm.setAttribute('action', actionUrl);

                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        });
    });
</script>
@endsection