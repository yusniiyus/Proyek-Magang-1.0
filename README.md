<div align="center">

<link href="https://dinsos.banjarmasinkota.go.id/favicon.ico" rel="icon" type="image/x-icon">

Sistem Informasi Santunan Kematian

Dinas Sosial Pemerintah Kota Banjarmasin

<p>
Digitalisasi Rekapitulasi Data Penerima Santunan Kematian Berbasis Web




untuk Meningkatkan Efisiensi Pelaporan & Transparansi.
</p>

<!-- Badges -->

<p>
<a href="https://laravel.com"><img src="https://www.google.com/search?q=https://img.shields.io/badge/Laravel-12.x-FF2D20%3Fstyle%3Dfor-the-badge%26logo%3Dlaravel%26logoColor%3Dwhite" alt="Laravel 12"></a>
<a href="https://php.net"><img src="https://www.google.com/search?q=https://img.shields.io/badge/PHP-8.2%2B-777BB4%3Fstyle%3Dfor-the-badge%26logo%3Dphp%26logoColor%3Dwhite" alt="PHP 8.2"></a>
<a href="https://mysql.com"><img src="https://www.google.com/search?q=https://img.shields.io/badge/MySQL-Database-4479A1%3Fstyle%3Dfor-the-badge%26logo%3Dmysql%26logoColor%3Dwhite" alt="MySQL"></a>
<a href="#"><img src="https://www.google.com/search?q=https://img.shields.io/badge/Maintained-Yes-green%3Fstyle%3Dfor-the-badge" alt="Maintained"></a>
</p>

</div>

<br />

📖 Tentang Aplikasi

Sistem ini dirancang untuk mengatasi permasalahan pendataan manual santunan kematian di Dinas Sosial Kota Banjarmasin. Aplikasi ini mendigitalisasi seluruh alur kerja, mulai dari input data pemohon, validasi berkas, hingga pencairan dana per tahapan.

Fitur unggulan sistem ini adalah mekanisme Penguncian Tahapan (Locking Mechanism) dan Rekapitulasi Otomatis (Excel Export) yang memastikan integritas data keuangan negara agar tidak berubah setelah dana dicairkan.

✨ Fitur Unggulan

🔐 Manajemen Tahapan & Keamanan Data

Siklus Hidup Data Dinamis: Menggunakan status Rekap (Input Data), Proses (Verifikasi), dan Cair (Selesai).

Auto-Locking System: Ketika tahapan diubah menjadi Proses atau Cair, sistem otomatis mengunci tombol Tambah dan Hapus. Data aman dari manipulasi pasca-pencairan.

Validasi Tanggal Cair: Mewajibkan input tanggal pencairan dana saat status diubah menjadi Cair.

📂 Pengelolaan Data Santunan (CRUD)

Validasi NIK Unik: Mencegah duplikasi data penerima bantuan (Double Entry).

Dependent Dropdown: Pemilihan Wilayah (Kecamatan -> Kelurahan) secara otomatis dan akurat.

Pencarian Cerdas: Filter data berdasarkan Nama Almarhum, Ahli Waris, atau Kelurahan.

📊 Pelaporan & Output

One-Click Excel Export: Menghasilkan laporan rekapitulasi siap cetak (.xlsx) sesuai format resmi Dinas Sosial.

Styling Otomatis: Baris tabel otomatis di-highlight (warna hijau) untuk penerima dengan rekening Bank Kalsel Syariah.

Dashboard Statistik: Ringkasan jumlah permohonan per tahapan.

🛡️ Hak Akses (Role-Based)

Administrator: Akses penuh (Manajemen User, Buka/Tutup Tahapan, Hapus Data).

Staff/Operator: Akses terbatas (Input Data, Edit Data, Cetak Laporan).

🛠️ Teknologi yang Digunakan

Backend: Laravel 12 Framework.

Database: MySQL.

Frontend: Blade Templating Engine + Custom CSS (Modern UI).

Library Tambahan:

maatwebsite/excel: Untuk engine export laporan.

sweetalert2: Untuk notifikasi dan konfirmasi interaktif.

poppins-font: Tipografi modern.

🚀 Instalasi & Penggunaan

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal (Localhost):

Prasyarat

PHP >= 8.2

Composer

MySQL

Langkah Instalasi

Clone Repository

git clone [https://github.com/username-kamu/santunan-kematian.git](https://github.com/username-kamu/santunan-kematian.git)
cd santunan-kematian


Install Dependency

composer install
# Jika ada masalah versi, gunakan:
composer require maatwebsite/excel -W


Konfigurasi Environment
Salin file .env.example menjadi .env dan atur koneksi database.

cp .env.example .env
php artisan key:generate


Setup Database
Buat database baru di MySQL (misal: dinsos_santunan), lalu jalankan migrasi.

php artisan migrate


Buat Akun Admin (Seeder/Tinker)

php artisan tinker


// Di dalam console tinker:
\App\Models\User::create([
    'name' => 'Administrator',
    'email' => 'admin@dinsos.gov.id',
    'role' => 'admin',
    'password' => bcrypt('password123')
]);
exit


Jalankan Server

php artisan serve


Buka browser dan akses: http://localhost:8000

📸 Tangkapan Layar (Screenshots)

Dashboard Utama
<img src="public/screenshots/images/dashboard.png" alt="Dashboard" width="auto" height="auto" />

Manajemen Tahapan
<img src="public/screenshots/images/tahapan.png" alt="Dashboard" width="auto" height="auto" />





Form Input Data
<img src="public/screenshots/images/permohonan-tambah.png" alt="Dashboard" width="auto" height="auto" />
Export Excel (Highlight)






(Note: Ganti path gambar di atas dengan link gambar asli)

📄 Lisensi

Aplikasi ini bersifat Private/Internal untuk Dinas Sosial Kota Banjarmasin. Dikembangkan sebagai bagian dari Laporan Magang/Kerja Praktik Mahasiswa.

<div align="center">
Dibuat dengan ❤️ oleh <strong>[Nama Kamu]</strong>
</div>
