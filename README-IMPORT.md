# Fitur Import Data Siswa - Sistem Sekolah Dasar

## Overview

Fitur import data siswa memungkinkan administrator untuk mengimpor data siswa secara massal dari file Excel (.xlsx, .xls) atau CSV. Fitur ini sangat berguna untuk:

- Pendaftaran siswa baru di awal tahun ajaran
- Migrasi data dari sistem lama
- Update data siswa secara massal
- Backup dan restore data siswa

## Fitur Utama

### ✅ File Upload
- Support format: XLSX, XLS, CSV
- Maksimal ukuran file: 2MB
- Drag & drop interface
- Validasi file type

### ✅ Progress Tracking
- Real-time progress bar
- Status update per baris
- Counter berhasil/gagal
- Estimasi waktu selesai

### ✅ Validasi Data
- Validasi header Excel
- Validasi field wajib
- Validasi format tanggal
- Validasi NIS unik
- Validasi jenis kelamin

### ✅ Error Handling
- Detail error per baris
- Rollback otomatis jika gagal
- Log error untuk debugging
- Clear errors button

### ✅ Template Download
- Template Excel siap pakai
- Contoh data yang benar
- Format yang sudah disesuaikan
- Header yang lengkap

## Cara Penggunaan

### 1. Akses Halaman Import
```
Menu: Manajemen Siswa > Import Excel
URL: /siswa/import
```

### 2. Download Template
- Klik tombol "Download Template Excel"
- Template akan otomatis terdownload
- Template berisi contoh data dan format yang benar

### 3. Siapkan Data Excel
- Buka template yang sudah didownload
- Isi data sesuai format yang ada
- Pastikan semua field wajib terisi
- Simpan file dengan format .xlsx

### 4. Upload dan Import
- Drag & drop file Excel ke area upload
- Atau klik "Upload file" untuk memilih file
- Klik tombol "Mulai Import"
- Monitor progress import
- Tunggu sampai selesai

### 5. Review Hasil
- Lihat jumlah data berhasil/gagal
- Review error detail jika ada
- Clear errors jika diperlukan
- Kembali ke daftar siswa

## Format Data Excel

### Kolom Wajib (Harus Diisi)
| Kolom | Deskripsi | Format | Contoh |
|-------|-----------|---------|---------|
| `nis` | Nomor Induk Siswa | Text | 2024001 |
| `nama_lengkap` | Nama lengkap siswa | Text | Ahmad Siswa |
| `jenis_kelamin` | Jenis kelamin | L/P | L |
| `tempat_lahir` | Tempat lahir | Text | Jakarta |
| `tanggal_lahir` | Tanggal lahir | YYYY-MM-DD | 2006-01-15 |
| `agama` | Agama | Text | Islam |
| `alamat` | Alamat lengkap | Text | Jl. Contoh No. 123 |
| `desa_kelurahan` | Desa/kelurahan | Text | Contoh |
| `kecamatan` | Kecamatan | Text | Contoh |
| `kabupaten_kota` | Kabupaten/kota | Text | Jakarta Selatan |
| `provinsi` | Provinsi | Text | DKI Jakarta |
| `tanggal_masuk` | Tanggal masuk sekolah | YYYY-MM-DD | 2024-07-01 |

### Kolom Opsional (Boleh Kosong)
| Kolom | Deskripsi | Format | Contoh |
|-------|-----------|---------|---------|
| `nisn` | NISN | Text | 1234567890 |
| `nama_panggilan` | Nama panggilan | Text | Ahmad |
| `no_hp` | Nomor HP | Text | 08123456789 |
| `nama_ayah` | Nama ayah | Text | Bapak Siswa |
| `pekerjaan_ayah` | Pekerjaan ayah | Text | Wiraswasta |
| `no_hp_ayah` | HP ayah | Text | 08123456788 |
| `nama_ibu` | Nama ibu | Text | Ibu Siswa |
| `pekerjaan_ibu` | Pekerjaan ibu | Text | Ibu Rumah Tangga |
| `no_hp_ibu` | HP ibu | Text | 08123456787 |
| `nama_wali` | Nama wali | Text | Wali Siswa |
| `pekerjaan_wali` | Pekerjaan wali | Text | Wiraswasta |
| `no_hp_wali` | HP wali | Text | 08123456786 |
| `keterangan` | Keterangan tambahan | Text | Siswa baru |

## Validasi Data

### 1. Validasi Header
- Sistem akan memvalidasi header Excel
- Header harus sesuai dengan template
- Case insensitive (nis = NIS = Nis)

### 2. Validasi Field Wajib
- Semua field wajib tidak boleh kosong
- Jika kosong, baris akan di-skip
- Error akan ditampilkan di log

### 3. Validasi Format
- Tanggal harus format YYYY-MM-DD
- Jenis kelamin harus L atau P
- NIS harus unik (tidak duplikat)

### 4. Validasi Duplikasi
- NIS tidak boleh sama dengan yang sudah ada
- Email akan di-generate otomatis
- Password default: password123

## Error Handling

### Jenis Error yang Ditangani
1. **File Error**: Format file tidak valid
2. **Header Error**: Header Excel tidak sesuai
3. **Data Error**: Data tidak valid per baris
4. **Database Error**: Gagal insert ke database
5. **Validation Error**: Validasi field gagal

### Cara Mengatasi Error
1. **Review Error Log**: Lihat detail error per baris
2. **Perbaiki Data Excel**: Sesuaikan dengan format yang benar
3. **Clear Errors**: Hapus log error yang sudah tidak diperlukan
4. **Re-import**: Upload ulang file yang sudah diperbaiki

## Best Practices

### 1. Persiapan Data
- Gunakan template yang disediakan
- Pastikan format tanggal benar (YYYY-MM-DD)
- Validasi data sebelum import
- Backup data lama jika diperlukan

### 2. Ukuran File
- Maksimal 1000 baris per import
- File tidak lebih dari 2MB
- Gunakan format XLSX untuk performa terbaik

### 3. Monitoring
- Monitor progress import
- Jangan tutup browser selama import
- Review hasil import setelah selesai
- Simpan log error untuk referensi

### 4. Keamanan
- Hanya admin yang bisa import
- Validasi file type dan size
- Sanitasi data sebelum insert
- Rollback otomatis jika gagal

## Troubleshooting

### Masalah Umum dan Solusi

#### 1. File Tidak Bisa Diupload
- **Penyebab**: Format file tidak didukung
- **Solusi**: Gunakan format .xlsx, .xls, atau .csv

#### 2. Import Gagal Semua
- **Penyebab**: Format header tidak sesuai
- **Solusi**: Download template dan sesuaikan format

#### 3. Progress Berhenti
- **Penyebab**: Data terlalu besar atau error
- **Solusi**: Cek log error, perbaiki data, re-import

#### 4. Data Tidak Masuk Database
- **Penyebab**: Validasi gagal atau database error
- **Solusi**: Cek error log, pastikan koneksi database

#### 5. Import Lambat
- **Penyebab**: File terlalu besar atau server lambat
- **Solusi**: Bagi file menjadi beberapa bagian kecil

## Technical Details

### Dependencies
- Laravel 12.x
- Livewire 3.x
- Maatwebsite Excel 1.1.x
- PHP 8.2+

### Database Transaction
- Setiap baris diproses dalam transaction
- Rollback otomatis jika gagal
- Commit hanya jika berhasil

### Memory Management
- Chunk processing untuk file besar
- Garbage collection otomatis
- Progress tracking real-time

### Error Logging
- Log error ke Laravel log
- Detail error per baris
- Stack trace untuk debugging

## Testing

### Unit Tests
- Test validasi file
- Test import data
- Test error handling
- Test progress tracking

### Integration Tests
- Test dengan database real
- Test dengan file Excel
- Test dengan berbagai format data

### Performance Tests
- Test dengan file besar
- Test memory usage
- Test processing time

## Support

### Dokumentasi
- README ini
- Code comments
- API documentation
- Video tutorial

### Contact
- Developer: [Nama Developer]
- Email: [email@domain.com]
- Issue Tracker: [GitHub Issues]

### Updates
- Fitur baru akan ditambahkan secara berkala
- Bug fixes akan di-release segera
- Feedback dan saran sangat dihargai

---

**Catatan**: Fitur import ini dirancang untuk memudahkan administrasi sekolah dasar. Pastikan data yang diimport sudah divalidasi dan sesuai dengan kebijakan sekolah.
