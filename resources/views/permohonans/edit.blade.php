{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Data Santunan')
@section('page-title', 'Edit Data Santunan')

@section('breadcrumb')
    <div class="header-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a> /
        <a href="{{ route('tahapans.index') }}">Santunan Kematian</a> /
        <a href="{{ route('permohonans.index', $tahapan->id) }}">Data Santunan</a> /
        Edit
    </div>
@endsection

@section('content')
    
    <div class="page-header-extra">
        <a href="{{ route('permohonans.index', $tahapan->id) }}" class="btn btn-secondary">
            <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Formulir Edit Data Santunan</h3>
            <p>Ubah data di bawah ini dan klik Simpan Perubahan.</p>
        </div>
        
        <form action="{{ route('permohonans.update', [$tahapan->id, $permohonan->id]) }}" method="POST">
            @csrf
            @method('PUT') 
            <div class="card-body">
                
                {{-- DATA ALMARHUM --}}
                <div class="form-section-header"><h3>1. Data Almarhum/ah</h3></div>
                <div class="form-row">
                    <div class="form-group-flex"><label>Nama Lengkap</label><input type="text" class="form-control" name="nama_meninggal" value="{{ old('nama_meninggal', $permohonan->nama_meninggal) }}" required></div>
                </div>
                <div class="form-row">
                    <div class="form-group-flex"><label>NIK (16 Digit)</label><input type="text" class="form-control" name="nik_meninggal" value="{{ old('nik_meninggal', $permohonan->nik_meninggal) }}" required maxlength="16"></div>
                    <div class="form-group-flex"><label>No. KK (16 Digit)</label><input type="text" class="form-control" name="kk_meninggal" value="{{ old('kk_meninggal', $permohonan->kk_meninggal) }}" required maxlength="16"></div>
                    <div class="form-group-flex">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin_meninggal" class="form-control" required>
                            <option value="Laki-laki" {{ old('jenis_kelamin_meninggal', $permohonan->jenis_kelamin_meninggal) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin_meninggal', $permohonan->jenis_kelamin_meninggal) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group-flex"><label>Tempat Lahir</label><input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $permohonan->tempat_lahir) }}" required></div>
                    <div class="form-group-flex"><label>Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $permohonan->tanggal_lahir->format('Y-m-d')) }}" required></div>
                    <div class="form-group-flex"><label>Tanggal Kematian</label><input type="date" class="form-control" name="tanggal_kematian" value="{{ old('tanggal_kematian', $permohonan->tanggal_kematian->format('Y-m-d')) }}" required></div>
                </div>
                <div class="form-row">
                    <div class="form-group-flex"><label>Alamat</label><textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $permohonan->alamat) }}</textarea></div>
                </div>
                <div class="form-row">
                    <div class="form-group-flex"><label>RT</label><input type="text" name="rt" class="form-control" value="{{ old('rt', $permohonan->rt) }}" required></div>
                    <div class="form-group-flex"><label>RW</label><input type="text" name="rw" class="form-control" value="{{ old('rw', $permohonan->rw) }}" required></div>
                    <div class="form-group-flex"><label>Kelurahan</label><input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan', $permohonan->kelurahan) }}" required></div>
                    <div class="form-group-flex"><label>Kecamatan</label><input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $permohonan->kecamatan) }}" required></div>
                </div>

                {{-- DATA AHLI WARIS --}}
                <div class="form-section-header"><h3>2. Data Ahli Waris</h3></div>
                <div class="form-row">
                    <div class="form-group-flex"><label>Nama Ahli Waris</label><input type="text" class="form-control" name="nama_ahli_waris" value="{{ old('nama_ahli_waris', $permohonan->nama_ahli_waris) }}" required></div>
                    <div class="form-group-flex"><label>No. Telepon</label><input type="text" class="form-control" name="nomor_telepon" value="{{ old('nomor_telepon', $permohonan->nomor_telepon) }}" required></div>
                </div>

                {{-- DATA BANK --}}
                <div class="form-section-header"><h3>3. Data Bank</h3></div>
                <div class="form-row">
                    <div class="form-group-flex">
                        <label>Jenis Bank</label>
                        <select name="jenis_bank" class="form-control" required>
                            <option value="KALSEL" {{ old('jenis_bank', $permohonan->jenis_bank) == 'KALSEL' ? 'selected' : '' }}>Bank Kalsel</option>
                            <option value="KALSEL SYARIAH" {{ old('jenis_bank', $permohonan->jenis_bank) == 'KALSEL SYARIAH' ? 'selected' : '' }}>Kalsel Syariah</option>
                        </select>
                    </div>
                    <div class="form-group-flex"><label>No. Rekening</label><input type="text" class="form-control" name="nomor_rekening" value="{{ old('nomor_rekening', $permohonan->nomor_rekening) }}" required></div>
                    <div class="form-group-flex"><label>Atas Nama</label><input type="text" class="form-control" name="nama_pemilik_rekening" value="{{ old('nama_pemilik_rekening', $permohonan->nama_pemilik_rekening) }}" required></div>
                </div>

                {{-- BAGIAN 4: CATATAN (TANPA STATUS) --}}
                <div class="form-section-header">
                    <h3>4. Catatan</h3>
                </div>
                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="catatan">Catatan (Opsional)</label>
                        <textarea id="catatan" name="catatan" class="form-control" rows="3">{{ old('catatan', $permohonan->catatan) }}</textarea>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('permohonans.index', $tahapan->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection