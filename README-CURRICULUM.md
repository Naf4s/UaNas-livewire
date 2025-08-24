# Fitur Manajemen Kurikulum - Sistem Sekolah Dasar

## 🎯 Filosofi Universal Assessment

Fitur manajemen kurikulum ini dibangun berdasarkan filosofi **"Universal Assessment"** yang bertujuan untuk mengatasi kekakuan sistem penilaian tradisional dengan memberikan fleksibilitas maksimal kepada admin sekolah dalam mendefinisikan struktur penilaian sesuai kurikulum yang berlaku.

### Masalah yang Dipecahkan:
- **Kekakuan Sistem Lama**: Sistem penilaian yang ada terlalu kaku dan spesifik untuk satu jenis kurikulum
- **Beban Kerja Saat Transisi**: Setiap perubahan kurikulum memerlukan adaptasi manual yang memakan waktu
- **Inefisiensi Alur Kerja**: Proses rekapitulasi nilai dan pelaporan yang belum optimal

### Solusi yang Diterapkan:
- **Agnostik Kurikulum**: Struktur penilaian bukan bagian dari kode, melainkan bagian dari data
- **Admin sebagai Arsitek**: Memberdayakan admin untuk "membangun" struktur penilaian sendiri
- **Alur Kerja Efisien**: Mengotomatiskan tugas repetitif dan menyederhanakan kolaborasi

## 🏗️ Arsitektur Sistem

### Tech Stack:
- **Backend**: Laravel 11
- **Frontend**: Laravel Livewire + Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **State Management**: Livewire Reactive Properties

### Struktur Database:
```
template_kurikulum (Template Kurikulum)
├── id
├── nama_template
├── deskripsi
├── jenis_kurikulum (K13, Kurikulum Merdeka, Kurikulum 2024)
├── tahun_berlaku
├── status (aktif/nonaktif)
└── catatan

aspek_penilaian (Struktur Aspek Penilaian)
├── id
├── template_kurikulum_id (FK)
├── parent_id (FK untuk hierarki)
├── nama_aspek
├── tipe (domain/aspek/indikator)
├── urutan
├── bobot (%)
├── status (aktif/nonaktif)
└── level (otomatis berdasarkan hierarki)
```

## 🚀 Fitur Utama

### 1. Manajemen Template Kurikulum

#### Membuat Template Baru
- **Nama Template**: Identifikasi unik untuk template
- **Jenis Kurikulum**: Pilihan antara K13, Kurikulum Merdeka, atau Kurikulum 2024
- **Tahun Berlaku**: Tahun akademik dimana template berlaku
- **Deskripsi**: Penjelasan detail tentang template
- **Catatan**: Informasi tambahan untuk admin

#### Mengelola Template
- **Edit Template**: Modifikasi informasi template yang sudah ada
- **Aktivasi Template**: Hanya satu template yang dapat aktif pada satu waktu
- **Hapus Template**: Dengan validasi keamanan (tidak bisa hapus jika masih digunakan)
- **Pencarian & Filter**: Berdasarkan nama, jenis kurikulum, dan status

### 2. Struktur Aspek Penilaian Hierarkis

#### Tipe Aspek Penilaian
1. **Domain**: Level tertinggi (contoh: Sikap, Pengetahuan, Keterampilan)
2. **Aspek**: Level menengah (contoh: Religius, Jujur, Disiplin)
3. **Indikator**: Level terendah (contoh: Berdoa sebelum makan, Tidak menyontek)

#### Fitur Hierarki
- **Parent-Child Relationship**: Mendukung struktur nested yang fleksibel
- **Expand/Collapse**: Navigasi yang mudah untuk struktur kompleks
- **Urutan**: Pengaturan urutan tampilan dan perhitungan
- **Bobot**: Persentase kontribusi dalam penilaian akhir

#### Manajemen Aspek
- **Tambah Aspek**: Root level atau sebagai sub-aspek
- **Edit Aspek**: Modifikasi properti aspek yang ada
- **Hapus Aspek**: Dengan validasi (tidak bisa hapus jika memiliki sub-aspek)
- **Toggle Status**: Aktivasi/deaktivasi aspek tanpa menghapus

### 3. Interface yang Intuitif

#### Layout Responsif
- **Grid Layout**: 1:2 ratio untuk template list dan aspek tree
- **Mobile Friendly**: Responsif untuk berbagai ukuran layar
- **Real-time Updates**: Livewire untuk interaksi tanpa refresh

#### Visual Indicators
- **Status Badges**: Warna berbeda untuk status aktif/nonaktif
- **Type Badges**: Identifikasi visual untuk domain/aspek/indikator
- **Bobot Display**: Persentase bobot dengan format yang jelas
- **Selection State**: Highlight template yang sedang dipilih

## 📱 User Experience

### Workflow Admin:
1. **Login** ke sistem dengan role admin
2. **Buat Template** kurikulum baru atau pilih yang sudah ada
3. **Definisikan Struktur** aspek penilaian secara hierarkis
4. **Atur Bobot** dan urutan untuk setiap aspek
5. **Aktivasi Template** untuk digunakan dalam penilaian

### Workflow Guru/Wali Kelas:
1. **Pilih Template** kurikulum yang aktif
2. **Lihat Struktur** aspek penilaian yang telah didefinisikan
3. **Input Nilai** berdasarkan struktur yang ada
4. **Generate Laporan** otomatis berdasarkan bobot

## 🔧 Implementasi Teknis

### Livewire Component: `ManageCurriculum`

#### Properties:
```php
// Template Management
public $searchTemplate, $jenisKurikulumFilter, $statusFilter;
public $showTemplateModal, $editingTemplate, $isEditingTemplate;

// Aspek Management
public $selectedTemplateId, $selectedTemplate, $aspekPenilaianTree;
public $expandedAspeks, $showAspekModal, $editingAspek;

// Form Data
public $nama_template, $deskripsi, $jenis_kurikulum, $tahun_berlaku;
public $nama_aspek, $tipe, $parent_id, $urutan, $bobot, $status;
```

#### Key Methods:
- `saveTemplate()`: CRUD untuk template kurikulum
- `saveAspect()`: CRUD untuk aspek penilaian
- `loadAspekPenilaianTree()`: Load struktur hierarkis
- `toggleAspekExpansion()`: Expand/collapse tree nodes
- `activateTemplate()`: Aktivasi template dengan validasi

### Database Relationships:
```php
// TemplateKurikulum Model
public function aspekPenilaian()
{
    return $this->hasMany(AspekPenilaian::class, 'template_kurikulum_id');
}

// AspekPenilaian Model
public function parent()
{
    return $this->belongsTo(AspekPenilaian::class, 'parent_id');
}

public function children()
{
    return $this->hasMany(AspekPenilaian::class, 'parent_id');
}
```

## 🎨 UI/UX Design Principles

### Design System:
- **Color Palette**: Tailwind CSS dengan semantic colors
- **Typography**: Hierarki yang jelas untuk readability
- **Spacing**: Consistent spacing menggunakan Tailwind spacing scale
- **Components**: Reusable components dengan consistent styling

### Accessibility:
- **Keyboard Navigation**: Support untuk keyboard-only users
- **Screen Reader**: Proper ARIA labels dan semantic HTML
- **Color Contrast**: Memenuhi standar WCAG 2.1
- **Focus Management**: Clear focus indicators

## 📊 Validasi & Keamanan

### Form Validation:
- **Required Fields**: Validasi untuk field wajib
- **Data Types**: Validasi tipe data (string, numeric, etc.)
- **Business Rules**: Validasi logika bisnis (bobot 0-100%, urutan positif)
- **Unique Constraints**: Mencegah duplikasi data

### Security Measures:
- **CSRF Protection**: Built-in Laravel CSRF protection
- **Input Sanitization**: Mencegah XSS attacks
- **SQL Injection**: Eloquent ORM protection
- **Authorization**: Role-based access control

## 🚀 Deployment & Maintenance

### Requirements:
- PHP 8.1+
- Laravel 11+
- MySQL 8.0+ atau PostgreSQL 13+
- Node.js 18+ (untuk asset compilation)

### Installation:
```bash
# Clone repository
git clone [repository-url]

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database migration
php artisan migrate

# Seed data (optional)
php artisan db:seed --class=CurriculumSeeder

# Asset compilation
npm run build
```

### Maintenance:
- **Regular Backups**: Database dan file uploads
- **Performance Monitoring**: Query optimization dan caching
- **Security Updates**: Regular Laravel dan dependency updates
- **User Training**: Dokumentasi dan training untuk admin

## 🔮 Roadmap & Enhancement

### Short Term (1-3 months):
- **Import/Export**: Excel import untuk template dan aspek
- **Template Cloning**: Duplikasi template untuk modifikasi
- **Version Control**: Tracking perubahan struktur kurikulum
- **Bulk Operations**: Operasi massal untuk aspek penilaian

### Medium Term (3-6 months):
- **Advanced Analytics**: Dashboard untuk analisis penggunaan
- **API Integration**: REST API untuk integrasi sistem lain
- **Multi-language**: Support untuk bahasa daerah
- **Audit Trail**: Log lengkap untuk perubahan data

### Long Term (6+ months):
- **AI Recommendations**: Saran struktur kurikulum optimal
- **Predictive Analytics**: Prediksi performa berdasarkan struktur
- **Mobile App**: Native mobile application
- **Cloud Integration**: Multi-tenant cloud solution

## 📚 Dokumentasi Tambahan

### API Documentation:
- Endpoint documentation untuk integrasi
- Authentication dan authorization
- Rate limiting dan throttling
- Error handling dan response codes

### User Manual:
- Step-by-step guide untuk admin
- Video tutorial dan screenshots
- FAQ dan troubleshooting
- Best practices dan tips

### Developer Guide:
- Architecture overview
- Code standards dan conventions
- Testing strategy dan examples
- Contribution guidelines

## 🤝 Kontribusi

Kami menyambut kontribusi dari komunitas untuk meningkatkan fitur ini. Silakan:

1. **Fork** repository
2. **Create** feature branch
3. **Commit** perubahan dengan pesan yang jelas
4. **Push** ke branch
5. **Create** Pull Request

### Coding Standards:
- PSR-12 coding standards
- Comprehensive testing coverage
- Clear documentation
- Performance considerations

---

**Dibuat dengan ❤️ untuk kemajuan pendidikan Indonesia**

*Fitur ini merupakan bagian dari sistem manajemen sekolah yang lebih besar, dirancang untuk memberikan fleksibilitas maksimal dalam mengelola berbagai jenis kurikulum tanpa perlu mengubah kode aplikasi.*
