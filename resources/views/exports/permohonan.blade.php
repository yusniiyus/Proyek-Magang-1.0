<table>
    <thead>
        {{-- Judul Laporan --}}
        <tr>
            {{-- colspan 16 karena total kolom sekarang ada 16 --}}
            <td colspan="16" style="text-align: center;"><strong>REKAPITULASI PENERIMA BANTUAN SOSIAL SANTUNAN KEMATIAN</strong></td>
        </tr>
        <tr>
            <td colspan="16" style="text-align: center;"><strong>{{ strtoupper($tahapan->nama_tahapan) }}</strong></td>
        </tr>
        <tr>
            <td colspan="16"></td> {{-- Spasi kosong --}}
        </tr>
        
        {{-- HEADER TABEL BARIS 1 (Judul Utama) --}}
        <tr>
            {{-- Kolom-kolom yang menggabungkan 2 baris (rowspan=2) --}}
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">No</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Kecamatan</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Kelurahan</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Tempat Tanggal Lahir</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Nomor Telpon</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">NIK Yang Meninggal</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Kartu Keluarga</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Nama Yang Meninggal</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Tanggal Kematian</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Nama Ahli Waris</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Jenis Kelamin Yang Meninggal</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">Alamat</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">RT</th>
            <th rowspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">RW</th>
            
            {{-- Header Bank yang melebar (colspan=2) --}}
            <th colspan="2" style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle;">No Rekening Bank</th>
        </tr>

        {{-- HEADER TABEL BARIS 2 (Sub-kolom Bank) --}}
        <tr>
            <th style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle; width: 20px;">Nama Bank</th>
            <th style="border: 1px solid #000000; background-color: #cccccc; text-align: center; font-weight: bold; vertical-align: middle; width: 25px;">No. Rekening</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permohonans as $permohonan)
            {{-- Definisi variabel warna background di dalam loop --}}
            @php
                $bgStyle = ($permohonan->jenis_bank == 'KALSEL SYARIAH') ? 'background-color: #c6efce;' : '';
            @endphp

            <tr>
                <td style="border: 1px solid #000000; text-align: center; {{ $bgStyle }}">{{ $loop->iteration }}</td>
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ $permohonan->kecamatan }}</td>
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ $permohonan->kelurahan }}</td>
                
                {{-- Menggabungkan Tempat & Tgl Lahir --}}
                <td style="border: 1px solid #000000; {{ $bgStyle }}">
                    {{ $permohonan->tempat_lahir }}, {{ \Carbon\Carbon::parse($permohonan->tanggal_lahir)->format('d-m-Y') }}
                </td>
                
                {{-- Gunakan nomor_telepon (sesuai database standard) atau nomor_telpon (sesuai snippet kamu) --}}
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ $permohonan->nomor_telepon ?? $permohonan->nomor_telpon }}</td>
                
                {{-- Tanda kutip ' agar NIK & KK terbaca teks (tidak kena format scientific) --}}
                <td style="border: 1px solid #000000; {{ $bgStyle }}">'{{ $permohonan->nik_meninggal }}</td>
                <td style="border: 1px solid #000000; {{ $bgStyle }}">'{{ $permohonan->kk_meninggal }}</td>
                
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ $permohonan->nama_meninggal }}</td>
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ \Carbon\Carbon::parse($permohonan->tanggal_kematian)->format('d-m-Y') }}</td>
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ $permohonan->nama_ahli_waris }}</td>
                
                {{-- Gunakan jenis_kelamin_meninggal atau jk_meninggal --}}
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ $permohonan->jenis_kelamin_meninggal ?? $permohonan->jk_meninggal }}</td>
                
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ $permohonan->alamat }}</td>
                
                {{-- Gunakan rt_rw jika belum dipecah, atau rt & rw jika sudah dipecah --}}
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ $permohonan->rt }}</td>
                <td style="border: 1px solid #000000; {{ $bgStyle }}">{{ $permohonan->rw }}</td>
                
                <td style="border: 1px solid #000000; text-align: center; {{ $bgStyle }}">
                    @if($permohonan->jenis_bank == 'KALSEL SYARIAH')
                        KALSEL
                    @else
                        KALSEL
                    @endif
                </td>

                <td style="border: 1px solid #000000; text-align: left; {{ $bgStyle }}">'{{ $permohonan->nomor_rekening }}</td>
            </tr>
        @endforeach
    </tbody>
</table>