# Dashboard Admin - Sistem Manajemen Akademik

## Deskripsi
Dashboard admin adalah halaman utama yang menampilkan informasi lengkap tentang sistem manajemen akademik sekolah. Dashboard ini dirancang untuk memberikan gambaran cepat tentang status dan aktivitas sekolah.

## Fitur Dashboard

### 1. Header Dashboard
- Judul dashboard dengan nama "Dashboard Admin"
- Deskripsi sistem "Sistem Manajemen Akademik"
- Informasi tanggal dan waktu real-time

### 2. Statistik Utama (4 Kartu)
- **Total Siswa**: Menampilkan jumlah total siswa aktif
- **Total Kelas**: Menampilkan jumlah kelas yang tersedia
- **Mata Pelajaran**: Menampilkan jumlah mata pelajaran aktif
- **Total Rombel**: Menampilkan jumlah rombel aktif

### 3. Grafik dan Statistik Detail
- **Statistik Absensi Hari Ini**:
  - Persentase kehadiran siswa
  - Jumlah siswa hadir, sakit, izin, dan alpha
  - Progress bar visual untuk kehadiran

- **Statistik Penilaian**:
  - Total nilai yang telah diinput
  - Distribusi nilai berdasarkan kategori (≥85, 70-84, <70)

### 4. Tabel Aktivitas Terbaru
- Menampilkan aktivitas terbaru dalam sistem
- Informasi absensi dan penilaian siswa
- Timestamp relatif (contoh: "2 jam yang lalu")

### 5. Aksi Cepat
- Tombol akses cepat ke fitur utama:
  - Kelola Siswa
  - Kelola Kelas
  - Mata Pelajaran
  - Input Nilai

## Data yang Ditampilkan

### Data Real-time
- Jumlah siswa, kelas, mata pelajaran, dan rombel
- Statistik absensi hari ini
- Total dan distribusi nilai
- Aktivitas terbaru dalam sistem

### Data dari Seeder
Dashboard menggunakan data dari seeder yang telah dibuat:
- **UserSeeder**: User admin, kepala sekolah, guru, dan wali kelas
- **SampleDataSeeder**: Data sample siswa, rombel, absensi, nilai, dll
- **MataPelajaranSeeder**: Mata pelajaran kurikulum
- **KelasSeeder**: Data kelas sekolah
- **GradeSettingSeeder**: Pengaturan penilaian
- **TemplateKurikulumSeeder**: Template kurikulum

## Cara Mengakses

### 1. Login sebagai Admin
```
Email: admin@admin.com
Password: password
```

### 2. Akses Dashboard
Setelah login, dashboard akan otomatis terbuka di halaman utama.

### 3. Navigasi
Dashboard dapat diakses melalui:
- Menu utama setelah login
- Route: `/dashboard`

## Struktur File

### Views
- `resources/views/dashboard.blade.php` - Halaman dashboard utama

### Seeders
- `database/seeders/UserSeeder.php` - Seeder untuk user
- `database/seeders/SampleDataSeeder.php` - Seeder untuk data sample
- `database/seeders/DatabaseSeeder.php` - Seeder utama

### Models
Dashboard menggunakan model-model berikut:
- `User` - Data user sistem
- `Siswa` - Data siswa
- `Kelas` - Data kelas
- `Rombel` - Data rombel
- `MataPelajaran` - Data mata pelajaran
- `Absensi` - Data absensi
- `Grade` - Data nilai
- `CatatanWaliKelas` - Data catatan wali kelas
- `UsulanKenaikanKelas` - Data usulan kenaikan kelas

## Fitur Responsif

Dashboard dirancang responsif dengan:
- Grid layout yang menyesuaikan ukuran layar
- Kartu statistik yang responsive
- Tabel yang dapat di-scroll pada layar kecil
- Tombol aksi yang mudah diakses di mobile

## Keamanan

- Dashboard hanya dapat diakses oleh user yang sudah login
- Middleware auth diterapkan pada route dashboard
- Data yang ditampilkan sesuai dengan role user

## Customization

Dashboard dapat dikustomisasi dengan:
- Menambah kartu statistik baru
- Mengubah warna dan tema
- Menambah grafik dan chart
- Menyesuaikan data yang ditampilkan

## Troubleshooting

### Jika Dashboard Kosong
1. Pastikan seeder telah dijalankan: `php artisan db:seed`
2. Periksa apakah ada data di database
3. Pastikan model relationships sudah benar

### Jika Ada Error
1. Periksa log Laravel: `storage/logs/laravel.log`
2. Pastikan semua model dan relationship sudah benar
3. Periksa apakah ada error pada query database

## Dependencies

- Laravel 10+
- Tailwind CSS
- Alpine.js (untuk interaktivitas)
- Heroicons (untuk icon)

## Support

Untuk bantuan teknis atau pertanyaan tentang dashboard, silakan hubungi tim development.
