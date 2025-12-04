{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- 1. Judul Halaman (Browser) --}}
@section('title', 'Manajemen Tahapan')

{{-- 2. Judul Halaman (Konten Header) --}}
@section('page-title', 'Manajemen Tahapan')

{{-- 3. Breadcrumb --}}
@section('breadcrumb')
    <div class="header-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a> /
        <span>Manajemen Tahapan</span>
    </div>
@endsection

{{-- 4. Konten Utama --}}
@section('content')

{{-- Header: Tombol Tambah --}}
<div class="page-header">
    <a href="{{ route('tahapans.create') }}" class="btn btn-action btn-success btn-primary">
        <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Tahapan Baru
    </a>
</div>

{{-- Tabel Data --}}
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="table-container">
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th>Nama Tahapan</th>
                            <th>Tanggal Buka</th>
                            <th>Status</th>
                            <th>Total Permohonan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tahapans as $tahapan)
                            <tr>
                                <td class="font-semibold">
                                    <a href="{{ route('permohonans.index', $tahapan) }}" class="table-link">
                                        {{ $tahapan->nama_tahapan }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($tahapan->tanggal_buka)->isoFormat('D MMMM YYYY') }}</td>
                                <td>
                                    @if ($tahapan->status == 'Rekap')
                                        <span class="badge badge-success">{{ $tahapan->status }}</span>
                                    @elseif ($tahapan->status == 'Proses')
                                        <span class="badge badge-warning">{{ $tahapan->status }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $tahapan->status }}</span>
                                        @if($tahapan->tanggal_tutup)
                                            <div style="font-size: 0.75rem; margin-top: 4px; color: #666;">
                                                Cair: {{ \Carbon\Carbon::parse($tahapan->tanggal_tutup)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $tahapan->permohonans_count ?? 'N/A' }} Data</td>
                                <td>
                                    <div class="table-action">
                                        
                                        {{-- 1. Tombol Edit --}}
                                        <a href="{{ route('tahapans.edit', $tahapan) }}" class="btn-action btn-warning" title="Edit Tahapan">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="nav-icon-btn">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data tahapan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection