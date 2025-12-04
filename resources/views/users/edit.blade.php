{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- 1. Judul Halaman (Browser) --}}
@section('title', 'Edit Pengguna')

{{-- 2. Judul Halaman (Konten Header) --}}
@section('page-title', 'Edit Pengguna')

{{-- 3. Breadcrumb --}}
@section('breadcrumb')
    <div class="header-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a> /
        <a href="{{ route('users.index') }}">Manajemen Pengguna</a> /
        <span>Edit Pengguna</span>
    </div>
@endsection

{{-- 4. Konten Utama --}}
@section('content')

{{-- Tombol Kembali --}}
<div class="page-header-extra">
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Daftar Pengguna
    </a>
</div>

<div class="page-content">
    <div class="card">
        {{-- Form ini akan mengirim data ke route 'users.update' dengan method PUT --}}
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT') {{-- PENTING: Method PUT untuk update --}}
            
            <div class="card-body">
                
                {{-- Baris 1: Nama Lengkap --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="name">Nama Lengkap</label>
                        {{-- Tampilkan nama pengguna yang sedang diedit --}}
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" 
                               value="{{ old('name', $user->name) }}" required>
                        
                        @error('name')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Baris 2: Email --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="email">Email</label>
                        {{-- Tampilkan email pengguna yang sedang diedit --}}
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" 
                               value="{{ old('email', $user->email) }}" required>
                        
                        @error('email')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- ================================================= --}}
                {{-- Baris 3: ROLE (DROPDOWN TAMBAHAN)                 --}}
                {{-- ================================================= --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="role">Peran / Hak Akses</label>
                        <select id="role" 
                                name="role" 
                                class="form-control @error('role') is-invalid @enderror" 
                                required>
                            <option value="">-- Pilih Peran --</option>
                            
                            {{-- Logic: old('role', $user->role) --}}
                            {{-- Artinya: Cek input lama dulu (jika error), kalau tidak ada pakai data dari database --}}
                            
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>
                                Staff (User Biasa)
                            </option>
                            
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                Administrator
                            </option>
                        </select>

                        @error('role')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- ================================================= --}}

                {{-- Baris 4 & 5: Password (Opsional) --}}
                <div class="form-section-header">
                    <h3>Ubah Password (Opsional)</h3>
                </div>
                <p class="form-instruction">Kosongkan kolom password jika Anda tidak ingin mengubahnya.</p>
                
                <div class="form-row">
                    {{-- Password Baru --}}
                    <div class="form-group-flex">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" 
                               autocomplete="new-password">
                        
                        @error('password')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Konfirmasi Password Baru --}}
                    <div class="form-group-flex">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection