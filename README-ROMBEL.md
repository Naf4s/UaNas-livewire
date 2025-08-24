# Sistem Manajemen Rombongan Belajar (Rombel)

## Deskripsi
Sistem manajemen rombongan belajar adalah modul yang memungkinkan administrator untuk mengelola data rombongan belajar siswa di sekolah. Sistem ini terintegrasi dengan modul kelas, guru, dan siswa.

## Fitur Utama

### 1. Tampilan Tabel Rombel
- **Daftar Rombel**: Menampilkan semua rombongan belajar dengan informasi lengkap
- **Pencarian**: Pencarian berdasarkan nama rombel, kode rombel, kelas, atau wali kelas
- **Filter**: Filter berdasarkan kelas dan status rombel
- **Pagination**: Navigasi halaman untuk data yang banyak
- **Visualisasi Kapasitas**: Progress bar untuk menunjukkan tingkat kepenuhan rombel

### 2. Manajemen Data Rombel
- **Tambah Rombel**: Form untuk menambah rombongan belajar baru
- **Edit Rombel**: Form untuk mengubah data rombongan belajar
- **Hapus Rombel**: Hapus rombel dengan validasi keamanan
- **Validasi**: Validasi input dengan pesan error yang informatif

### 3. Informasi yang Ditampilkan
- Nama dan kode rombel
- Kelas yang terkait
- Wali kelas yang bertanggung jawab
- Kapasitas dan jumlah siswa saat ini
- Status rombel (aktif/nonaktif)
- Deskripsi tambahan

## Struktur Database

### Tabel `rombel`
```sql
- id (Primary Key)
- kelas_id (Foreign Key ke tabel kelas)
- nama_rombel (Nama rombongan belajar)
- kode_rombel (Kode unik rombel)
- kapasitas (Jumlah maksimal siswa)
- jumlah_siswa (Jumlah siswa saat ini)
- wali_kelas_id (Foreign Key ke tabel users)
- deskripsi (Deskripsi tambahan)
- status (aktif/nonaktif)
- created_at, updated_at (Timestamps)
```

### Relasi
- `rombel` belongs to `kelas`
- `rombel` belongs to `waliKelas` (User)
- `rombel` belongs to many `siswa` (melalui pivot table `siswa_rombel`)

## Cara Penggunaan

### 1. Mengakses Halaman Rombel
```
URL: /rombel
Method: GET
Route Name: rombel.index
```

### 2. Menambah Rombel Baru
```
URL: /rombel/create
Method: GET
Route Name: rombel.create
```

**Langkah-langkah:**
1. Klik tombol "Tambah Rombel" di halaman utama
2. Isi form dengan data yang diperlukan:
   - Pilih kelas dari dropdown
   - Masukkan kode rombel (harus unik)
   - Masukkan nama rombel
   - Set kapasitas maksimal
   - Pilih wali kelas (opsional)
   - Set status rombel
   - Tambahkan deskripsi (opsional)
3. Klik tombol "Simpan"

### 3. Mengedit Rombel
```
URL: /rombel/{id}/edit
Method: GET
Route Name: rombel.edit
```

**Langkah-langkah:**
1. Klik ikon edit (pensil) pada baris rombel yang ingin diedit
2. Ubah data yang diperlukan
3. Klik tombol "Perbarui"

### 4. Menghapus Rombel
```
URL: /rombel/{id}
Method: DELETE
Route Name: rombel.destroy
```

**Langkah-langkah:**
1. Klik ikon hapus (tempat sampah) pada baris rombel yang ingin dihapus
2. Konfirmasi penghapusan
3. Rombel hanya bisa dihapus jika tidak memiliki siswa

### 5. Pencarian dan Filter
- **Pencarian**: Ketik di kolom pencarian untuk mencari berdasarkan nama, kode, kelas, atau wali kelas
- **Filter Kelas**: Pilih kelas tertentu untuk memfilter rombel
- **Filter Status**: Pilih status aktif/nonaktif untuk memfilter rombel

## Validasi dan Keamanan

### Validasi Input
- **Kelas**: Harus memilih kelas yang valid dan aktif
- **Kode Rombel**: Harus unik dan tidak boleh kosong
- **Nama Rombel**: Tidak boleh kosong, maksimal 255 karakter
- **Kapasitas**: Harus angka 1-100
- **Wali Kelas**: Harus user yang valid dengan role guru/kepala
- **Status**: Hanya boleh 'aktif' atau 'nonaktif'

### Keamanan
- **Hapus Rombel**: Rombel tidak bisa dihapus jika masih memiliki siswa
- **Validasi Role**: Hanya user dengan role yang sesuai yang bisa mengakses
- **CSRF Protection**: Semua form dilindungi dari CSRF attack

## Komponen Livewire

### 1. RombelTable Component
**File**: `app/Livewire/RombelManagement/RombelTable.php`

**Fitur:**
- Pagination data rombel
- Pencarian dan filter
- Delete rombel dengan validasi
- Relasi dengan kelas dan wali kelas

### 2. RombelForm Component
**File**: `app/Livewire/RombelManagement/RombelForm.php`

**Fitur:**
- Form create dan edit rombel
- Validasi input
- Handling error dan success message
- Integrasi dengan model Kelas dan User

## View Templates

### 1. Tabel Rombel
**File**: `resources/views/livewire/rombel-management/rombel-table.blade.php`

**Fitur:**
- Responsive table design
- Search dan filter interface
- Action buttons (edit/delete)
- Loading states
- Empty state handling

### 2. Form Rombel
**File**: `resources/views/livewire/rombel-management/rombel-form.blade.php`

**Fitur:**
- Responsive form layout
- Error message display
- Loading states pada submit
- Validation feedback

### 3. Layout Pages
- **Index**: `resources/views/rombel/index.blade.php`
- **Create**: `resources/views/rombel/create.blade.php`
- **Edit**: `resources/views/rombel/edit.blade.php`

## Integrasi dengan Modul Lain

### 1. Modul Kelas
- Rombel terkait dengan kelas tertentu
- Hanya kelas aktif yang bisa dipilih
- Relasi one-to-many (satu kelas bisa memiliki banyak rombel)

### 2. Modul User/Guru
- Wali kelas dipilih dari user dengan role guru/kepala
- Hanya user aktif yang bisa dipilih sebagai wali kelas

### 3. Modul Siswa
- Rombel memiliki relasi many-to-many dengan siswa
- Jumlah siswa dihitung otomatis
- Rombel tidak bisa dihapus jika masih memiliki siswa

## Troubleshooting

### 1. Rombel Tidak Bisa Dihapus
**Penyebab**: Rombel masih memiliki siswa
**Solusi**: Pindahkan semua siswa ke rombel lain terlebih dahulu

### 2. Kode Rombel Duplikat
**Penyebab**: Kode rombel sudah digunakan
**Solusi**: Gunakan kode rombel yang berbeda

### 3. Form Tidak Bisa Disubmit
**Penyebab**: Ada field yang tidak valid
**Solusi**: Periksa pesan error dan perbaiki input yang salah

### 4. Data Tidak Muncul
**Penyebab**: Filter terlalu ketat atau data kosong
**Solusi**: Reset filter atau tambah data rombel baru

## Pengembangan Selanjutnya

### Fitur yang Bisa Ditambahkan
1. **Import/Export**: Import data rombel dari Excel/CSV
2. **Batch Operations**: Operasi massal (aktifkan/nonaktifkan multiple rombel)
3. **History Tracking**: Log perubahan data rombel
4. **Advanced Filtering**: Filter berdasarkan tanggal, tahun ajaran, dll
5. **Dashboard Analytics**: Statistik penggunaan rombel
6. **Notification**: Notifikasi ketika rombel penuh atau ada perubahan

### Optimisasi
1. **Caching**: Cache data rombel yang sering diakses
2. **Lazy Loading**: Load data siswa hanya ketika diperlukan
3. **Search Index**: Optimasi pencarian dengan database index
4. **API Endpoints**: REST API untuk integrasi dengan sistem lain

## Kesimpulan

Sistem manajemen rombongan belajar ini menyediakan interface yang user-friendly untuk mengelola data rombel dengan fitur lengkap seperti CRUD, pencarian, filter, dan validasi. Sistem ini terintegrasi dengan baik dengan modul lain dan memiliki keamanan yang memadai untuk penggunaan di lingkungan sekolah.
