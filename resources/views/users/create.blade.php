{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- 1. Judul Halaman (Browser) --}}
@section('title', 'Tambah Pengguna')

{{-- 2. Judul Halaman (Konten) --}}
@section('page-title', 'Tambah Pengguna Baru')

{{-- 3. Breadcrumb --}}
@section('breadcrumb')
    <div class="header-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a> > 
        <a href="{{ route('users.index') }}">Pengguna</a> > 
        Tambah Baru
    </div>
@endsection

{{-- 4. Konten Utama --}}
@section('content')

    {{-- Tombol Kembali diletakkan di luar card, di atas --}}
    <div class="page-header-extra">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Card untuk Form --}}
    <div class="card">
        <div class="card-header">
            <h3>Formulir Pengguna</h3>
            <p>Isi data di bawah ini untuk menambahkan administrator baru.</p>
        </div>
        
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-body">
                
                {{-- Baris 1: Nama Lengkap --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" 
                               required>
                        {{-- Tampilkan pesan error jika validasi gagal --}}
                        @error('name')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Baris 2: Email --}}
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="email">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" 
                               required>
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
                            
                            {{-- Pilihan Staff --}}
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>
                                Staff (User Biasa)
                            </option>
                            
                            {{-- Pilihan Admin --}}
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                Administrator
                            </option>
                        </select>

                        @error('role')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- ================================================= --}}


                {{-- Baris 4: Password & Konfirmasi Password --}}
                <div class="form-row">
                    {{-- Kolom Kiri: Password --}}
                    <div class="form-group-flex">
                        <label for="password">Password</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               required>
                        @error('password')
                            <div class="form-error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Kolom Kanan: Konfirmasi Password --}}
                    <div class="form-group-flex">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-control" 
                               required>
                    </div>
                </div>

            </div>

            {{-- Footer Card: Tombol Aksi --}}
            <div class="card-footer">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
            </div>
        </form>
    </div>

@endsection