{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- 1. Judul Halaman (Browser) --}}
@section('title', 'Dashboard')

{{-- 2. Judul Halaman (Konten) --}}
@section('page-title', 'Selamat Datang, ' . Auth::user()->name)

{{-- 3. Breadcrumb --}}
@section('breadcrumb')
    <div class="header-breadcrumb">
        Dashboard
    </div>
@endsection

{{-- 4. Konten Utama --}}
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Halo, {{ Auth::user()->name }}!</h3>
            <p>Anda telah berhasil login ke sistem Santunan Kematian.</p>
        </div>
        <div class="card-body">
            <p>Gunakan menu di sebelah kiri untuk mengelola data:</p>
            <ul>
                <li><strong>Santunan Kematian:</strong> Untuk mengelola tahapan dan data permohonan santunan.</li>
                @if(Auth::user()->isAdmin())
                <li><strong>Pengguna:</strong> Untuk mengelola akun administrator yang dapat mengakses sistem ini.</li>
                @endif
            </ul>
        </div>
    </div>
@endsection