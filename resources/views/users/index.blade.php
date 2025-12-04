{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- 1. Judul Halaman (Browser) --}}
@section('title', 'Manajemen Pengguna')

{{-- 2. Judul Halaman (Konten Header) --}}
@section('page-title', 'Manajemen Pengguna')

{{-- 3. Breadcrumb --}}
@section('breadcrumb')
    <div class="header-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a> /
        <span>Manajemen Pengguna</span>
    </div>
@endsection

{{-- 4. Konten Utama --}}
@section('content')

{{-- Ini adalah header halaman dengan tombol di kanan --}}
<div class="page-header">
    <a href="{{ route('users.create') }}" class="btn btn-action btn-success btn-primary">
        <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Pengguna
    </a>
</div>

<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="table-container">
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>EMAIL</th>
                            <th>ROLE</th> {{-- Tambahan Kolom Role --}}
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                
                                {{-- Menampilkan Role dengan Badge --}}
                                <td>
                                    @if($user->role === 'admin')
                                        <span style="background-color: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">Admin</span>
                                    @else
                                        <span style="background-color: #f3f4f6; color: #374151; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">Staff</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="table-action">
                                        
                                        {{-- TOMBOL EDIT --}}
                                        <a href="{{ route('users.edit', $user) }}" class="btn-action btn-warning" title="Edit Pengguna">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>

                                        {{-- TOMBOL HAPUS (KONDISIONAL) --}}
                                        @if(Auth::id() === $user->id)
                                            {{-- Jika akun sendiri, tidak boleh hapus --}}
                                            <span style="font-size: 0.8rem; color: #6b7280; margin-left: 5px;">(Anda)</span>
                                        @else
                                            {{-- Jika akun orang lain, muncul tombol hapus --}}
                                            {{-- Perhatikan: data-action berisi URL delete --}}
                                            <button type="button" 
                                                    class="btn-action btn-danger delete-button" 
                                                    title="Hapus Pengguna"
                                                    data-action="{{ route('users.destroy', $user) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================== --}}
{{-- BAGIAN LOGIKA HAPUS (Sama dengan Permohonan) --}}
{{-- ========================================================== --}}

{{-- 1. Form Tersembunyi (Satu form untuk semua tombol) --}}
<form id="deleteForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

{{-- 2. Library SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- 3. Script Handling --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');
        const deleteForm = document.getElementById('deleteForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ambil URL dari tombol yang diklik
                const actionUrl = this.getAttribute('data-action');
                
                // Masukkan URL ke form tersembunyi
                deleteForm.setAttribute('action', actionUrl);

                // Tampilkan Popup Konfirmasi
                Swal.fire({
                    title: 'Hapus Pengguna?',
                    text: "Akses login pengguna ini akan hilang permanen!",
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