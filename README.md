# Book&Fix

**Book&Fix** adalah aplikasi web berbasis Laravel untuk reservasi fasilitas kampus dan pelaporan kerusakan. Pengguna dapat melihat fasilitas, mengajukan reservasi, dan membuat laporan. Petugas menindaklanjuti pengajuan, sedangkan admin mengelola data sistem.

## Akses Aplikasi

Aplikasi telah di-*deploy* menggunakan **Railway** dan dapat diakses melalui:

**[Buka Book&Fix](https://projekppk-production.up.railway.app/)**

Pengunjung dapat melihat informasi fasilitas tanpa login. Pengguna, petugas, dan admin perlu login untuk mengakses fitur sesuai hak akses masing-masing.

## Teknologi

| Teknologi | Kegunaan |
| --- | --- |
| Laravel 13 | *Backend* aplikasi |
| PHP 8.3+ | Bahasa pemrograman |
| Blade dan Tailwind CSS | Antarmuka pengguna |
| Node.js, NPM, dan Vite | Dependensi serta aset *frontend* |
| MySQL/MariaDB | Basis data pada contoh lingkungan lokal |
| Railway | *Deployment* aplikasi |

## Menjalankan Secara Lokal

### Prasyarat

Siapkan PHP 8.3+, Composer, Node.js dan NPM, Git, serta server basis data yang sesuai dengan konfigurasi proyek. MySQL/MariaDB dapat dijalankan melalui XAMPP.

### Instalasi

1. Unduh *source code* dan masuk ke direktori proyek:

   ```bash
   git clone https://github.com/eileenalbertt123-afk/projekppk.git
   cd projekppk
   ```

2. Pasang dependensi:

   ```bash
   composer install
   npm install
   ```

3. Siapkan file konfigurasi dan *application key* (Windows):

   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

   Sesuaikan pengaturan basis data di `.env`. Jangan mengunggah kredensial atau isi `.env` ke GitHub.

4. Siapkan tabel dan tautan penyimpanan, sesuai konfigurasi basis data proyek:

   ```bash
   php artisan migrate
   php artisan storage:link
   ```

5. Jalankan aplikasi dan Vite di dua terminal berbeda:

   ```bash
   php artisan serve
   ```

   ```bash
   npm run dev
   ```

Akses aplikasi lokal melalui **http://127.0.0.1:8000**.

> Jika tim menyiapkan basis data melalui impor SQL, ikuti prosedur tersebut sebagai pengganti langkah migrasi yang tidak diperlukan. Sesuaikan juga pengaturan basis data dengan konfigurasi final proyek.

## Struktur Folder

Struktur utama proyek Laravel (disederhanakan):

```text
projekppk/
├── app/
│   ├── Http/Controllers/       # Controller reservasi, laporan, dan fasilitas
│   └── Models/                 # Model Eloquent
├── database/
│   └── migrations/             # Struktur tabel basis data
├── public/                     # Aset yang dapat diakses publik
├── resources/
│   └── views/                  # Halaman Blade dan komponen UI
│       ├── components/
│       └── petugas/
│           ├── reservasi/
│           ├── laporan/
│           └── fasilitas/
├── routes/
│   └── web.php                 # Definisi route aplikasi
├── storage/                    # Penyimpanan file dan log
├── .env.example                # Contoh konfigurasi lingkungan
├── composer.json               # Dependensi PHP
└── package.json                # Dependensi frontend
```

## Tim

| Anggota | Tanggung Jawab Utama |
| --- | --- |
| Eileen Albert Tandrio | Autentikasi (Registrasi dan Login) |
| Anggita Kirana Puspa | Pengembangan Fitur Role Petugas |
| Nouvella Rahma Fitrah Legarsi | Pengembangan Fitur Role Pengguna |
| Nashwa Aldebaran | Pengembangan Fitur Role Admin |

## Role Sistem

- **Pengunjung:** melihat informasi dan ketersediaan fasilitas tanpa login.
- **Pengguna (mahasiswa, dosen, staf):** mengajukan reservasi dan laporan serta melihat statusnya.
- **Petugas:** mengelola reservasi, laporan kerusakan, dan status fasilitas.
- **Admin:** mengelola pengguna, petugas, fasilitas, dan rekap sistem.

## Dokumentasi

Ketentuan fitur dan *acceptance criteria* sistem mengacu pada dokumen SRS proyek. Detail instalasi dan konfigurasi produksi mengikuti pengaturan *deployment* tim.
