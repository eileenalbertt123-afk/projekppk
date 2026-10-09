# Book&Fix

Book&Fix adalah aplikasi web untuk reservasi dan pelaporan kerusakan fasilitas kampus. Sistem membantu pengguna dalam melihat ketersediaan fasilitas, melakukan reservasi, serta melaporkan kerusakan fasilitas. Petugas dapat memproses reservasi dan laporan yang masuk, sedangkan admin dapat mengelola pengguna, fasilitas, serta melihat rekap data sistem.

## Software Requirements Specification

Bagian ini merangkum kebutuhan utama sistem Book&Fix berdasarkan user story yang telah ditentukan.

| ID | Deskripsi | Acceptance Criteria |
| --- | --- | --- |
| **SRS-001** | Pengunjung dan pengguna dapat melihat daftar fasilitas beserta status ketersediaannya pada slot waktu tertentu tanpa menampilkan informasi pemohon atau tujuan reservasi. | 1. Sistem menampilkan daftar fasilitas.<br>2. Sistem menampilkan status tersedia atau tidak tersedia berdasarkan slot waktu.<br>3. Informasi pemohon dan tujuan reservasi tidak ditampilkan kepada pengunjung atau pengguna lain. |
| **SRS-002** | Pengunjung dan pengguna dapat mencari fasilitas berdasarkan tipe, lokasi, atau kapasitas. | 1. Sistem menyediakan fitur pencarian fasilitas.<br>2. Pencarian dapat menggunakan nama, tipe, lokasi, atau kapasitas fasilitas.<br>3. Sistem menampilkan fasilitas yang sesuai dengan parameter pencarian. |
| **SRS-003** | Pengguna dapat mengajukan reservasi fasilitas pada rentang waktu tertentu dengan mencantumkan tujuan penggunaan. | 1. Pengguna dapat memilih fasilitas.<br>2. Pengguna dapat memilih tanggal dan rentang waktu reservasi.<br>3. Pengguna wajib mengisi tujuan penggunaan.<br>4. Sistem menyimpan reservasi dengan status awal `menunggu`. |
| **SRS-004** | Pengguna dapat membatalkan reservasi miliknya sendiri sebelum batas waktu yang ditentukan. | 1. Pengguna hanya dapat membatalkan reservasi miliknya sendiri.<br>2. Pembatalan hanya dapat dilakukan apabila memenuhi batas waktu yang berlaku.<br>3. Status reservasi berubah menjadi `dibatalkan`. |
| **SRS-005** | Pengguna dapat melihat riwayat, status, dan detail lengkap reservasi miliknya. | 1. Sistem menampilkan daftar reservasi milik pengguna.<br>2. Sistem menampilkan status setiap reservasi.<br>3. Pengguna dapat membuka detail reservasi.<br>4. Pengguna tidak dapat melihat detail reservasi milik pengguna lain. |
| **SRS-006** | Pengguna dapat membuat laporan kerusakan fasilitas dengan memilih kategori, mengisi deskripsi, dan mengunggah foto. | 1. Pengguna dapat memilih fasilitas yang dilaporkan.<br>2. Pengguna wajib memilih kategori kerusakan.<br>3. Pengguna wajib mengisi deskripsi laporan.<br>4. Sistem mendukung unggahan foto laporan.<br>5. Laporan disimpan dengan status awal `baru`. |
| **SRS-007** | Pengguna dapat melihat status laporan kerusakan yang telah dibuat. | 1. Sistem menampilkan daftar laporan milik pengguna.<br>2. Sistem menampilkan status `baru`, `diproses`, `selesai`, atau `ditolak`.<br>3. Pengguna tidak dapat melihat detail laporan milik pengguna lain. |
| **SRS-008** | Petugas dapat melihat dashboard atau antrean reservasi dan laporan yang masih membutuhkan tindakan. | 1. Dashboard menampilkan reservasi yang masih menunggu.<br>2. Dashboard menampilkan laporan berstatus `baru` atau `diproses`.<br>3. Petugas dapat membuka detail reservasi atau laporan dari dashboard. |
| **SRS-009** | Petugas dapat menyetujui atau menolak reservasi, sementara sistem mencegah persetujuan reservasi yang memiliki konflik jadwal. | 1. Petugas dapat menyetujui reservasi berstatus `menunggu`.<br>2. Petugas dapat menolak reservasi berstatus `menunggu`.<br>3. Sistem memeriksa konflik pada fasilitas dan rentang waktu yang sama sebelum persetujuan.<br>4. Reservasi yang memiliki konflik tidak dapat disetujui. |
| **SRS-010** | Petugas dapat membatalkan reservasi yang telah disetujui dalam kondisi mendesak dengan mencantumkan alasan pembatalan. | 1. Pembatalan hanya dapat dilakukan terhadap reservasi berstatus `disetujui`.<br>2. Petugas wajib mengisi alasan pembatalan.<br>3. Status reservasi berubah menjadi `dibatalkan`.<br>4. Alasan pembatalan disimpan dalam riwayat status. |
| **SRS-011** | Petugas dapat mengelola status laporan kerusakan dan menambahkan catatan resolusi ketika laporan selesai. | 1. Petugas dapat mengubah laporan dari `baru` menjadi `diproses`.<br>2. Petugas dapat menolak laporan berstatus `baru`.<br>3. Petugas dapat menyelesaikan laporan berstatus `diproses`.<br>4. Catatan resolusi disimpan ketika laporan diselesaikan.<br>5. Riwayat perubahan status laporan tersimpan. |
| **SRS-012** | Petugas dapat mengubah status fasilitas menjadi `dalam_perbaikan` ketika laporan sedang ditangani dan mengembalikannya menjadi `tersedia` setelah selesai diperbaiki. | 1. Fasilitas dapat berubah menjadi `dalam_perbaikan` ketika laporan diproses.<br>2. Sistem menampilkan status fasilitas selama proses perbaikan.<br>3. Setelah laporan selesai, fasilitas dapat kembali berstatus `tersedia`. |
| **SRS-013** | Admin dapat mendaftarkan akun petugas secara langsung. | 1. Admin dapat membuat akun petugas.<br>2. Akun petugas tidak dibuat melalui registrasi mandiri.<br>3. Role akun yang dibuat ditetapkan sebagai petugas.<br>4. Akun petugas dapat digunakan sesuai hak akses petugas. |
| **SRS-014** | Admin dapat memverifikasi atau menolak akun pengguna yang melakukan registrasi mandiri. | 1. Akun hasil registrasi masuk ke status menunggu verifikasi.<br>2. Admin dapat menyetujui akun.<br>3. Admin dapat menolak akun.<br>4. Akun yang belum diverifikasi tidak memperoleh akses penuh ke sistem. |
| **SRS-015** | Admin dapat mengelola data fasilitas kampus. | 1. Admin dapat menambahkan fasilitas baru.<br>2. Admin dapat mengubah data fasilitas.<br>3. Admin dapat menonaktifkan fasilitas.<br>4. Perubahan data fasilitas tersimpan pada database. |
| **SRS-016** | Admin dapat melihat dan mengekspor rekap okupansi fasilitas serta frekuensi kerusakan. | 1. Sistem menampilkan rekap penggunaan fasilitas.<br>2. Sistem menampilkan rekap kerusakan berdasarkan fasilitas atau lokasi.<br>3. Admin dapat mengekspor data dalam format CSV.<br>4. Admin dapat mengekspor data dalam format XLSX.<br>5. Admin dapat mengekspor data dalam format PDF. |
## Tech Stack

| Teknologi | Kegunaan |
| --- | --- |
| Laravel 13 | Framework backend |
| PHP 8.3+ | Bahasa pemrograman backend |
| MySQL / MariaDB | Database |
| Blade | Template engine |
| Tailwind CSS | Styling antarmuka |
| Alpine.js | Interaksi frontend |
| Vite | Frontend build tool |
| DomPDF | Export data PDF |
| FastExcel | Export data XLSX |
| Git & GitHub | Version control dan kolaborasi |

## Prasyarat

Sebelum menjalankan project, pastikan perangkat telah memiliki:

- PHP 8.3 atau lebih baru
- Composer
- Node.js dan npm
- MySQL atau MariaDB
- Git
- Web browser

XAMPP dapat digunakan untuk menjalankan MySQL/MariaDB secara lokal.

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/eileenalbertt123-afk/projekppk.git
cd projekppk
```

### 2. Install Dependency PHP

Jalankan Composer untuk menginstall dependency Laravel:

```bash
composer install
```

### 3. Install Dependency Frontend

Install dependency frontend menggunakan npm:

```bash
npm install
```

### 4. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

Untuk Windows:

```bash
copy .env.example .env
```

Untuk Linux/macOS:

```bash
cp .env.example .env
```

Setelah itu, generate application key Laravel:

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Buka file `.env`, lalu sesuaikan konfigurasi database.

Contoh konfigurasi MySQL lokal:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookandfix
DB_USERNAME=root
DB_PASSWORD=
```

Jika menggunakan database cloud, sesuaikan nilai `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` dengan konfigurasi database yang digunakan.

> Jangan menyimpan username, password, atau kredensial database asli di README maupun repository GitHub.

### 6. Menyiapkan Database

Jika menggunakan migration Laravel, jalankan:

```bash
php artisan migrate
```

Jika tim menggunakan file SQL yang sudah tersedia, buat database terlebih dahulu lalu import file SQL tersebut melalui MySQL atau phpMyAdmin.

### 7. Konfigurasi Storage

Jalankan perintah berikut agar file dan gambar yang disimpan pada Laravel Storage dapat diakses dari aplikasi:

```bash
php artisan storage:link
```

### 8. Menjalankan Laravel

Jalankan development server Laravel:

```bash
php artisan serve
```

### 9. Menjalankan Vite

Buka terminal baru, lalu jalankan:

```bash
npm run dev
```

### 10. Akses Aplikasi

Buka aplikasi melalui browser:

```text
http://127.0.0.1:8000
```

## Role Sistem

Book&Fix memiliki empat role utama, yaitu **Pengunjung**, **Pengguna**, **Petugas**, dan **Admin**. Setiap role memiliki hak akses yang berbeda sesuai kebutuhan sistem.

### Pengunjung

Pengunjung merupakan pengguna yang belum login atau belum memiliki akun pada sistem.

Fitur yang dapat digunakan oleh pengunjung:

- Melihat daftar fasilitas kampus.
- Melihat status ketersediaan fasilitas pada slot waktu tertentu.
- Mencari fasilitas berdasarkan tipe, lokasi, atau kapasitas.
- Melihat informasi fasilitas yang bersifat umum.
- Tidak dapat melihat informasi pemohon reservasi.
- Tidak dapat melihat tujuan penggunaan fasilitas.
- Tidak dapat mengajukan reservasi atau laporan sebelum memiliki akun dan login.
  
### Pengguna

Pengguna merupakan mahasiswa, dosen, atau tenaga kependidikan yang telah memiliki akun dan telah diverifikasi.

Fitur yang dapat digunakan oleh pengguna:

- Melihat daftar fasilitas kampus.
- Melihat detail dan ketersediaan fasilitas.
- Mengajukan reservasi fasilitas.
- Melihat status dan riwayat reservasi.
- Mengunduh atau melihat dokumen reservasi jika tersedia.
- Mengajukan laporan kerusakan fasilitas.
- Mengunggah foto kerusakan fasilitas.
- Melihat status dan riwayat laporan kerusakan.

Pengguna hanya dapat mengakses reservasi dan laporan miliknya sendiri.

### Petugas

Petugas bertugas memproses reservasi dan laporan yang diajukan oleh pengguna.

Fitur yang dapat digunakan oleh petugas:

- Melihat dashboard reservasi.
- Melihat daftar reservasi.
- Mencari, memfilter, dan mengurutkan data reservasi.
- Melihat detail reservasi.
- Menyetujui atau menolak reservasi yang masih menunggu.
- Membatalkan reservasi yang telah disetujui sesuai kondisi tertentu.
- Menyelesaikan reservasi.
- Melihat jadwal reservasi fasilitas.
- Memeriksa konflik jadwal reservasi.
- Melihat dashboard laporan kerusakan.
- Melihat daftar dan detail laporan.
- Memproses, menolak, dan menyelesaikan laporan kerusakan.
- Melihat fasilitas yang sedang dalam perbaikan.
- Memantau reservasi yang berpotensi terdampak oleh kerusakan fasilitas.

### Admin

Admin bertugas mengelola data utama dan akun pada sistem.

Fitur yang dapat digunakan oleh admin:

- Melihat dashboard admin.
- Melihat dan mengelola data pengguna.
- Memverifikasi pendaftaran pengguna.
- Menolak pendaftaran pengguna.
- Mengaktifkan atau menonaktifkan akun pengguna.
- Menambahkan akun petugas.
- Melihat dan mengelola data fasilitas.
- Menambahkan fasilitas baru.
- Mengubah informasi fasilitas.
- Menonaktifkan fasilitas.
- Melihat rekap data sistem.
- Mengekspor data rekap dalam format CSV, XLSX, dan PDF.

Hak akses setiap halaman dibatasi menggunakan middleware berdasarkan autentikasi, status akun, dan role pengguna.


## Status Reservasi

Reservasi pada Book&Fix memiliki lima status utama.

| Status | Keterangan |
| --- | --- |
| `menunggu` | Reservasi telah diajukan oleh pengguna dan menunggu keputusan petugas. |
| `disetujui` | Reservasi telah disetujui oleh petugas dan fasilitas dijadwalkan untuk digunakan. |
| `ditolak` | Reservasi tidak disetujui oleh petugas. |
| `dibatalkan` | Reservasi yang sebelumnya diajukan atau disetujui dibatalkan karena alasan tertentu. |
| `selesai` | Waktu penggunaan fasilitas telah selesai atau reservasi telah dinyatakan selesai. |

### Alur Status Reservasi

Alur utama perubahan status reservasi adalah:

```text
Menunggu
├── Disetujui
│   ├── Selesai
│   └── Dibatalkan
│
└── Ditolak
```

Reservasi yang masih berstatus `menunggu` dapat disetujui atau ditolak oleh petugas.

Sebelum menyetujui reservasi, sistem melakukan pemeriksaan konflik jadwal. Reservasi dianggap memiliki konflik apabila terdapat reservasi lain yang telah berstatus `disetujui` pada fasilitas yang sama dengan rentang waktu yang saling bertumpang tindih.

Apabila reservasi disetujui, reservasi lain yang masih menunggu dan memiliki konflik pada fasilitas serta waktu yang sama dapat ditolak oleh sistem untuk mencegah dua penggunaan fasilitas pada waktu yang bersamaan.

Reservasi yang telah disetujui juga dapat dibatalkan apabila terdapat kondisi tertentu, seperti fasilitas mengalami kerusakan atau tidak dapat digunakan.

Setiap perubahan status reservasi dicatat pada riwayat status sehingga perubahan yang dilakukan dapat ditelusuri.


## Status Laporan

Laporan kerusakan fasilitas memiliki empat status utama.

| Status | Keterangan |
| --- | --- |
| `baru` | Laporan baru dibuat oleh pengguna dan belum diproses petugas. |
| `diproses` | Laporan telah diverifikasi dan sedang ditangani oleh petugas. |
| `ditolak` | Laporan tidak dapat diproses karena tidak memenuhi ketentuan atau alasan tertentu. |
| `selesai` | Kerusakan telah selesai ditangani dan laporan telah diselesaikan. |

### Alur Status Laporan

```text
Baru
├── Diproses
│   └── Selesai
│
└── Ditolak
```

Ketika laporan masih berstatus `baru`, petugas melakukan verifikasi terhadap informasi laporan, fasilitas, deskripsi, dan foto yang diberikan.

Petugas dapat memilih:

- **Proses Laporan**, jika laporan dinilai valid.
- **Tolak Laporan**, jika laporan tidak dapat diproses.

Ketika laporan mulai diproses, status laporan berubah menjadi `diproses`. Fasilitas yang berkaitan dengan laporan dapat berubah menjadi status `dalam_perbaikan`.

Apabila terdapat reservasi mendatang pada fasilitas tersebut, petugas dapat melihat reservasi yang berpotensi terdampak oleh proses perbaikan.

Setelah fasilitas selesai diperbaiki, petugas melakukan verifikasi kondisi fasilitas dan mengisi catatan penyelesaian. Setelah laporan dikonfirmasi selesai:

- status laporan berubah menjadi `selesai`;
- catatan penyelesaian disimpan;
- fasilitas dapat kembali menjadi `tersedia`.

Setiap perubahan status laporan juga dicatat dalam riwayat status laporan.


## Status Fasilitas

Fasilitas pada Book&Fix memiliki tiga status.

| Status | Keterangan |
| --- | --- |
| `tersedia` | Fasilitas dalam kondisi normal dan dapat digunakan untuk reservasi. |
| `dalam_perbaikan` | Fasilitas sedang mengalami kerusakan atau dalam proses perbaikan. |
| `nonaktif` | Fasilitas dinonaktifkan dan tidak dapat digunakan untuk reservasi. |

### Tersedia

Status `tersedia` menunjukkan bahwa fasilitas dapat digunakan dan dapat dipilih dalam proses reservasi selama jadwal yang dipilih masih tersedia.

### Dalam Perbaikan

Status `dalam_perbaikan` digunakan ketika terdapat laporan kerusakan yang sedang ditangani.

Saat fasilitas berada dalam kondisi ini, petugas dapat memantau laporan kerusakan serta reservasi mendatang yang mungkin terdampak.

Setelah perbaikan selesai dan laporan dinyatakan selesai, fasilitas dapat dikembalikan menjadi status `tersedia`.

### Nonaktif

Status `nonaktif` digunakan ketika fasilitas dinonaktifkan oleh admin.

Fasilitas dengan status ini tidak tersedia untuk proses reservasi sampai diaktifkan atau diperbarui kembali sesuai kebijakan pengelola.
