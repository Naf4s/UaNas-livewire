# Manajemen Mata Pelajaran

## Deskripsi
Sistem manajemen mata pelajaran untuk aplikasi sekolah yang memungkinkan administrator untuk mengelola data mata pelajaran dengan fitur CRUD lengkap.

## Fitur Utama

### 1. CRUD Mata Pelajaran
- **Create**: Tambah mata pelajaran baru
- **Read**: Lihat daftar mata pelajaran dengan pagination
- **Update**: Edit data mata pelajaran yang ada
- **Delete**: Hapus mata pelajaran (dengan validasi relasi)

### 2. Fitur Pencarian dan Filter
- Pencarian berdasarkan nama, kode, atau deskripsi
- Filter berdasarkan jenis mata pelajaran
- Filter berdasarkan kelompok (A, B, C)
- Filter berdasarkan status (aktif/nonaktif)
- Reset filter untuk kembali ke tampilan awal

### 3. Validasi Data
- Kode mata pelajaran unik (maksimal 10 karakter)
- Nama mata pelajaran wajib diisi
- Jenis mata pelajaran sesuai kurikulum nasional
- Jumlah jam per minggu (1-10 jam)
- Auto-set kelompok berdasarkan jenis mata pelajaran

### 4. Manajemen Status
- Toggle status aktif/nonaktif
- Validasi sebelum penghapusan
- Pengecekan relasi dengan tabel lain

## Struktur Database

### Tabel: `mata_pelajaran`
```sql
- id (primary key)
- kode_mapel (unique, max 10 char)
- nama_mapel (required, max 255 char)
- deskripsi (nullable, max 500 char)
- jenis (enum: Wajib, Peminatan, Lintas Minat, Muatan Lokal)
- jumlah_jam (integer, 1-10)
- kelompok (enum: A, B, C)
- status (enum: aktif, nonaktif)
- catatan (nullable, max 1000 char)
- created_at, updated_at
```

## Jenis Mata Pelajaran

### 1. Mata Pelajaran Wajib
- **Kelompok A**: PAI, PPKN, Bahasa Indonesia, Matematika, Sejarah Indonesia, Bahasa Inggris
- **Kelompok B**: Seni Budaya, PJOK, Prakarya dan Kewirausahaan

### 2. Mata Pelajaran Peminatan
- **IPA**: Fisika, Kimia, Biologi
- **IPS**: Geografi, Ekonomi, Sosiologi

### 3. Mata Pelajaran Lintas Minat
- Bahasa dan Sastra Indonesia
- Bahasa dan Sastra Inggris

### 4. Mata Pelajaran Muatan Lokal
- Bahasa Sunda
- Kewirausahaan

## Relasi dengan Model Lain

### 1. TemplateKurikulum
- Satu mata pelajaran dapat digunakan dalam banyak template kurikulum
- Relasi: `hasMany`

### 2. AspekPenilaian
- Satu mata pelajaran dapat memiliki banyak aspek penilaian
- Relasi: `hasMany`

### 3. Grade
- Satu mata pelajaran dapat memiliki banyak nilai
- Relasi: `hasMany`

## Cara Penggunaan

### 1. Menambah Mata Pelajaran Baru
1. Akses menu "Manajemen Mata Pelajaran"
2. Klik tombol "Tambah Mata Pelajaran"
3. Isi form dengan data yang diperlukan
4. Klik "Simpan"

### 2. Mengedit Mata Pelajaran
1. Dari tabel, klik ikon edit (pensil)
2. Ubah data yang diperlukan
3. Klik "Update"

### 3. Mengubah Status
1. Dari tabel, klik ikon toggle status
2. Status akan berubah dari aktif ke nonaktif atau sebaliknya

### 4. Menghapus Mata Pelajaran
1. Dari tabel, klik ikon hapus (tempat sampah)
2. Konfirmasi penghapusan
3. Mata pelajaran akan dihapus jika tidak ada relasi

### 5. Mencari dan Memfilter
1. Gunakan kolom pencarian untuk mencari berdasarkan nama/kode/deskripsi
2. Gunakan dropdown filter untuk memfilter berdasarkan jenis, kelompok, atau status
3. Klik "Reset Filter" untuk menghapus semua filter

## Validasi dan Keamanan

### 1. Validasi Input
- Semua field wajib diisi sesuai aturan
- Kode mata pelajaran harus unik
- Jumlah jam harus dalam rentang 1-10
- Jenis dan kelompok harus sesuai enum yang ditentukan

### 2. Keamanan Data
- Validasi relasi sebelum penghapusan
- Pengecekan penggunaan mata pelajaran di sistem lain
- Flash message untuk feedback user

### 3. Auto-set Kelompok
- Jenis "Wajib" → Kelompok A atau B
- Jenis "Peminatan" → Kelompok C
- Jenis "Lintas Minat" → Kelompok C
- Jenis "Muatan Lokal" → Kelompok B

## File yang Terlibat

### 1. Controller (Livewire)
- `app/Livewire/MataPelajaranManagement/MataPelajaranForm.php`
- `app/Livewire/MataPelajaranManagement/MataPelajaranTable.php`

### 2. Model
- `app/Models/MataPelajaran.php`

### 3. View
- `resources/views/livewire/mata-pelajaran-management/mata-pelajaran-form.blade.php`
- `resources/views/livewire/mata-pelajaran-management/mata-pelajaran-table.blade.php`

### 4. Routes
- `routes/web.php` (prefix: `mata-pelajaran`)

### 5. Seeder
- `database/seeders/MataPelajaranSeeder.php`

## Testing

### 1. Unit Test
- Test model MataPelajaran
- Test relasi dan scope
- Test validasi dan accessor

### 2. Feature Test
- Test CRUD operations
- Test search dan filter
- Test validasi form
- Test permission dan authorization

## Deployment

### 1. Database Migration
```bash
php artisan migrate
```

### 2. Seeding Data
```bash
php artisan db:seed --class=MataPelajaranSeeder
```

### 3. Clear Cache
```bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## Troubleshooting

### 1. Error "Mata pelajaran tidak dapat dihapus"
- Mata pelajaran masih digunakan di template kurikulum, aspek penilaian, atau nilai
- Nonaktifkan mata pelajaran terlebih dahulu

### 2. Error "Kode mata pelajaran sudah ada"
- Gunakan kode yang berbeda
- Kode mata pelajaran harus unik

### 3. Filter tidak berfungsi
- Pastikan JavaScript Livewire berfungsi
- Clear cache browser dan Laravel

## Kontribusi

Untuk berkontribusi pada pengembangan fitur ini:
1. Fork repository
2. Buat branch fitur baru
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## Lisensi

Fitur ini dikembangkan untuk aplikasi sekolah dan tunduk pada lisensi yang sama dengan aplikasi utama.
