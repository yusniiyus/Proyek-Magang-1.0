{{-- Halaman ini "memakai" layout master di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- 1. Judul Halaman (Browser) --}}
@section('title', 'Tambah Data Santunan')

{{-- 2. Judul Halaman (Konten) --}}
@section('page-title', 'Tambah Data Santunan Baru')

{{-- 3. Breadcrumb --}}
@section('breadcrumb')
    <div class="header-breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a> > 
        <a href="{{ route('tahapans.index') }}">Santunan Kematian</a> > 
        <a href="{{ route('permohonans.index', $tahapan->id) }}">Data Santunan</a> > 
        Tambah Baru
    </div>
@endsection

{{-- 4. Konten Utama --}}
@section('content')
    
    {{-- Tombol Kembali --}}
    <div class="page-header-extra">
        <a href="{{ route('permohonans.index', $tahapan->id) }}" class="btn btn-secondary">
            <svg class="nav-icon-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Card untuk Form --}}
    <div class="card">
        <div class="card-header">
            <h3>Formulir Data Santunan</h3>
            <p>Isi data almarhum/ah dan ahli waris di bawah ini. Tanda <span class="text-danger">*</span> wajib diisi.</p>
        </div>
        
        <form action="{{ route('permohonans.store', $tahapan->id) }}" method="POST">
            @csrf
            <div class="card-body">
                
                {{-- Bagian 1: Data Almarhum/ah --}}
                <div class="form-section-header">
                    <h3>1. Data Almarhum/ah</h3>
                </div>

                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="nama_meninggal">Nama Lengkap (Sesuai KTP) <span class="text-danger">*</span></label>
                        <input type="text" id="nama_meninggal" name="nama_meninggal" class="form-control @error('nama_meninggal') is-invalid @enderror" value="{{ old('nama_meninggal') }}" required>
                        @error('nama_meninggal') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="nik_meninggal">NIK (16 Digit) <span class="text-danger">*</span></label>
                        <input type="text" id="nik_meninggal" name="nik_meninggal" class="form-control @error('nik_meninggal') is-invalid @enderror" value="{{ old('nik_meninggal') }}" required minlength="16" maxlength="16">
                        @error('nik_meninggal') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-flex">
                        <label for="kk_meninggal">No. Kartu Keluarga (16 Digit) <span class="text-danger">*</span></label>
                        <input type="text" id="kk_meninggal" name="kk_meninggal" class="form-control @error('kk_meninggal') is-invalid @enderror" value="{{ old('kk_meninggal') }}" required minlength="16" maxlength="16">
                        @error('kk_meninggal') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-flex">
                        <label for="jenis_kelamin_meninggal">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select id="jenis_kelamin_meninggal" name="jenis_kelamin_meninggal" class="form-control @error('jenis_kelamin_meninggal') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin_meninggal') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin_meninggal') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin_meninggal') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}" required>
                        @error('tempat_lahir') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-flex">
                        <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-flex">
                        <label for="tanggal_kematian">Tanggal Kematian <span class="text-danger">*</span></label>
                        <input type="date" id="tanggal_kematian" name="tanggal_kematian" class="form-control @error('tanggal_kematian') is-invalid @enderror" value="{{ old('tanggal_kematian', date('Y-m-d')) }}" required>
                        @error('tanggal_kematian') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="alamat">Alamat (Sesuai KTP) <span class="text-danger">*</span></label>
                        <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat') }}</textarea>
                        @error('alamat') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="rt">RT <span class="text-danger">*</span></label>
                        <input type="text" id="rt" name="rt" class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt') }}" placeholder="Contoh: 001" required>
                        @error('rt') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-flex">
                        <label for="rw">RW <span class="text-danger">*</span></label>
                        <input type="text" id="rw" name="rw" class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw') }}" placeholder="Contoh: 001" required>
                        @error('rw') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-flex">
                        <label for="kecamatan">Kecamatan <span class="text-danger">*</span></label>
                        <select id="kecamatan" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" required onchange="updateKelurahan()">
                            <option value="" disabled selected>-- Pilih Kecamatan --</option>
                            <option value="Banjarmasin Barat" {{ old('kecamatan') == 'Banjarmasin Barat' ? 'selected' : '' }}>Banjarmasin Barat</option>
                            <option value="Banjarmasin Selatan" {{ old('kecamatan') == 'Banjarmasin Selatan' ? 'selected' : '' }}>Banjarmasin Selatan</option>
                            <option value="Banjarmasin Tengah" {{ old('kecamatan') == 'Banjarmasin Tengah' ? 'selected' : '' }}>Banjarmasin Tengah</option>
                            <option value="Banjarmasin Timur" {{ old('kecamatan') == 'Banjarmasin Timur' ? 'selected' : '' }}>Banjarmasin Timur</option>
                            <option value="Banjarmasin Utara" {{ old('kecamatan') == 'Banjarmasin Utara' ? 'selected' : '' }}>Banjarmasin Utara</option>
                        </select>
                        @error('kecamatan') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group-flex">
                        <label for="kelurahan">Kelurahan <span class="text-danger">*</span></label>
                        <select id="kelurahan" name="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Kelurahan --</option>
                        </select>
                        @error('kelurahan') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>

                    <script>
                        const dataWilayah = {
                            "Banjarmasin Barat": ["Basirih", "Belitung Selatan", "Belitung Utara", "Kuin Cerucuk", "Kuin Selatan", "Pelambuan", "Telaga Biru", "Telawang", "Teluk Tiram"],
                            "Banjarmasin Selatan": ["Basirih Selatan", "Kelayan Barat", "Kelayan Dalam", "Kelayan Tengah", "Kelayan Timur", "Kelayan Selatan", "Mantuil", "Murung Raya", "Pekauman", "Pemurus Baru", "Pemurus Dalam", "Tanjung Pagar"],
                            "Banjarmasin Tengah": ["Antasan Besar", "Gadang", "Kertak Baru Ilir", "Kertak Baru Ulu", "Kelayan Luar", "Mawar", "Melayu", "Pasar Lama", "Pekapuran Laut", "Seberang Mesjid", "Sungai Baru", "Teluk Dalam"],
                            "Banjarmasin Timur": ["Benua Anyar", "Karang Mekar", "Kebun Bunga", "Kuripan", "Pekapuran Raya", "Pemurus Luar", "Pengambangan", "Sungai Bilu", "Sungai Lulut"],
                            "Banjarmasin Utara": ["Alalak Selatan", "Alalak Tengah", "Alalak Utara", "Antasan Kecil Timur", "Kuin Utara", "Pangeran", "Sungai Andai", "Sungai Jingah", "Sungai Miai", "Surgi Mufti"]
                        };

                        const kecamatanSelect = document.getElementById('kecamatan');
                        const kelurahanSelect = document.getElementById('kelurahan');
                        const oldKelurahan = "{{ old('kelurahan') }}"; 

                        function updateKelurahan() {
                            const selectedKecamatan = kecamatanSelect.value;
                            kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';

                            if (selectedKecamatan && dataWilayah[selectedKecamatan]) {
                                dataWilayah[selectedKecamatan].forEach(function(kelurahan) {
                                    const option = document.createElement('option');
                                    option.value = kelurahan;
                                    option.text = kelurahan;
                                    if (kelurahan === oldKelurahan) {
                                        option.selected = true;
                                    }
                                    kelurahanSelect.appendChild(option);
                                });
                            }
                        }

                        document.addEventListener('DOMContentLoaded', function() {
                            updateKelurahan();
                        });
                    </script>
                </div>

                {{-- Bagian 2: Data Ahli Waris --}}
                <div class="form-section-header">
                    <h3>2. Data Ahli Waris (Pemohon)</h3>
                </div>

                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="nama_ahli_waris">Nama Ahli Waris <span class="text-danger">*</span></label>
                        <input type="text" id="nama_ahli_waris" name="nama_ahli_waris" class="form-control @error('nama_ahli_waris') is-invalid @enderror" value="{{ old('nama_ahli_waris') }}" required>
                        @error('nama_ahli_waris') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-flex">
                        <label for="nomor_telepon">Nomor Telepon (WhatsApp) <span class="text-danger">*</span></label>
                        <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control @error('nomor_telepon') is-invalid @enderror" value="{{ old('nomor_telepon') }}" placeholder="Contoh: 0812..." required minlength="10" maxlength="13">
                        @error('nomor_telepon') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                {{-- Bagian 3: Data Bank --}}
                <div class="form-section-header">
                    <h3>3. Data Pencairan (Bank Kalsel)</h3>
                </div>

                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="jenis_bank">Jenis Bank <span class="text-danger">*</span></label>
                        <select id="jenis_bank" name="jenis_bank" class="form-control @error('jenis_bank') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Jenis Bank --</option>
                            <option value="KALSEL" {{ old('jenis_bank') == 'KALSEL' ? 'selected' : '' }}>Bank Kalsel (Konvensional)</option>
                            <option value="KALSEL SYARIAH" {{ old('jenis_bank') == 'KALSEL SYARIAH' ? 'selected' : '' }}>Bank Kalsel Syariah</option>
                        </select>
                        @error('jenis_bank') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-flex">
                        <label for="nomor_rekening">Nomor Rekening <span class="text-danger">*</span></label>
                        <input type="text" id="nomor_rekening" name="nomor_rekening" class="form-control @error('nomor_rekening') is-invalid @enderror" value="{{ old('nomor_rekening') }}" required>
                        @error('nomor_rekening') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-flex">
                        <label for="nama_pemilik_rekening">Atas Nama (Pemilik Rekening) <span class="text-danger">*</span></label>
                        <input type="text" id="nama_pemilik_rekening" name="nama_pemilik_rekening" class="form-control @error('nama_pemilik_rekening') is-invalid @enderror" value="{{ old('nama_pemilik_rekening') }}" required>
                        @error('nama_pemilik_rekening') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Bagian 4: Status & Catatan --}}
                <div class="form-section-header">
                    <h3>4. Catatan</h3>
                </div>

                <div class="form-row">
                    <div class="form-group-flex">
                        <label for="catatan">Catatan (Opsional)</label>
                        {{-- PERBAIKAN: Value textarea harus di antara tag, bukan attribute value --}}
                        <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3" placeholder="Contoh: Berkas kurang lengkap / Rekening salah">{{ old('catatan') }}</textarea>
                        @error('catatan') <div class="form-error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

            </div> <!-- End Card Body -->

            {{-- Footer Card: Tombol Aksi --}}
            <div class="card-footer">
                <a href="{{ route('permohonans.index', $tahapan->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Data Santunan</button>
            </div>
        </form>
    </div>

@endsection