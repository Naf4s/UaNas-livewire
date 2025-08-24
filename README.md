# UnAs-Laravel - Sistem Manajemen Sekolah Dasar

## 🎯 Visi & Misi

**UnAs-Laravel** adalah sistem manajemen sekolah dasar yang dibangun dengan filosofi **"Universal Assessment"** - sebuah pendekatan revolusioner untuk mengatasi kekakuan sistem penilaian tradisional dengan memberikan fleksibilitas maksimal kepada admin sekolah dalam mendefinisikan struktur penilaian sesuai kurikulum yang berlaku.

### 🚀 Filosofi Universal Assessment

Sistem ini mengatasi tiga masalah utama dalam manajemen sekolah:

1. **Kekakuan Sistem Lama**: Sistem penilaian yang ada terlalu kaku dan spesifik untuk satu jenis kurikulum
2. **Beban Kerja Saat Transisi**: Setiap perubahan kurikulum memerlukan adaptasi manual yang memakan waktu
3. **Inefisiensi Alur Kerja**: Proses rekapitulasi nilai, kenaikan kelas, dan pelaporan yang belum optimal

### 💡 Solusi yang Diterapkan

- **Agnostik Kurikulum**: Struktur penilaian bukan bagian dari kode, melainkan bagian dari data
- **Admin sebagai Arsitek**: Memberdayakan admin sekolah untuk "membangun" dan mendefinisikan sendiri struktur penilaian
- **Alur Kerja Efisien**: Mengotomatiskan tugas-tugas repetitif dan menyederhanakan proses kolaborasi

## 🏗️ Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Laravel Livewire + Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **State Management**: Livewire Reactive Properties
- **Authentication**: Laravel Breeze
- **Testing**: Pest PHP

## 📚 Fitur Utama

### 🎓 Manajemen Kurikulum
- **Template Kurikulum**: Mendukung K13, Kurikulum Merdeka, dan Kurikulum 2024
- **Struktur Hierarkis**: Domain → Aspek → Indikator dengan bobot fleksibel
- **Aktivasi Template**: Hanya satu template aktif pada satu waktu
- **Expandable Tree View**: Navigasi mudah untuk struktur kompleks

### 👥 Manajemen Siswa
- **Data Siswa**: Informasi lengkap siswa dengan foto
- **Import Excel**: Import data siswa secara massal
- **Kenaikan Kelas**: Sistem otomatis dengan validasi wali kelas
- **Rombel Management**: Pengelompokan siswa per kelas

### 👨‍🏫 Manajemen Guru & Staff
- **User Management**: Role-based access control
- **Wali Kelas**: Penugasan dan manajemen wali kelas
- **Permissions**: Sistem hak akses yang fleksibel

### 📊 Manajemen Nilai & Penilaian
- **Input Nilai**: Berdasarkan struktur kurikulum yang aktif
- **Perhitungan Otomatis**: Bobot dan rata-rata otomatis
- **Rekapitulasi**: Laporan nilai per siswa dan per kelas
- **Kenaikan Kelas**: Validasi otomatis berdasarkan kriteria

### 📝 Manajemen Kehadiran
- **Input Absensi**: Per mata pelajaran atau per hari
- **Rekap Kehadiran**: Laporan kehadiran per periode
- **Catatan Wali Kelas**: Input catatan khusus per siswa

### 🏫 Manajemen Kelas & Mata Pelajaran
- **Kelas**: Pengaturan kelas dan kapasitas
- **Mata Pelajaran**: Manajemen mata pelajaran dan guru pengampu
- **Rombel**: Pengelompokan siswa dalam rombongan belajar

## 🚀 Quick Start

### Prerequisites
- PHP 8.4+
- Composer
- Node.js 18+
- MySQL 8.0+ atau PostgreSQL 13+

### Installation

```bash
# Clone repository
git clone https://github.com/your-username/UnAs-Laravel.git
cd UnAs-Laravel

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unas_laravel
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Build assets
npm run build

# Start development server
php artisan serve
```

### Default Login
- **Email**: admin@example.com
- **Password**: password

## 📁 Struktur Proyek

```
UnAs-Laravel/
├── app/
│   ├── Http/Controllers/     # Controllers untuk fitur utama
│   ├── Livewire/            # Livewire components
│   │   ├── CurriculumManagement/    # Manajemen kurikulum
│   │   ├── SiswaManagement/         # Manajemen siswa
│   │   ├── UserManagement/          # Manajemen user
│   │   └── ...                     # Fitur lainnya
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/            # Database seeders
│   └── factories/          # Model factories
├── resources/
│   ├── views/              # Blade templates
│   │   └── livewire/       # Livewire view components
│   ├── css/                # Tailwind CSS
│   └── js/                 # JavaScript files
├── routes/                  # Route definitions
└── tests/                   # Test files
```

## 🔧 Konfigurasi

### Environment Variables
```env
APP_NAME="UnAs Laravel"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unas_laravel
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Database Configuration
Sistem mendukung multiple database drivers:
- **MySQL**: Rekomendasi untuk production
- **PostgreSQL**: Alternatif yang powerful
- **SQLite**: Untuk development dan testing

## 📊 Database Schema

### Core Tables
- `users` - User authentication dan profile
- `template_kurikulum` - Template kurikulum yang dapat diaktifkan
- `aspek_penilaian` - Struktur hierarkis aspek penilaian
- `siswa` - Data siswa
- `kelas` - Data kelas
- `rombel` - Rombongan belajar
- `mata_pelajaran` - Mata pelajaran
- `grades` - Nilai siswa
- `absensi` - Kehadiran siswa

### Relationships
- **Template Kurikulum** → **Aspek Penilaian** (One-to-Many)
- **Aspek Penilaian** → **Aspek Penilaian** (Self-referencing untuk hierarki)
- **Kelas** → **Rombel** → **Siswa** (Hierarchical)
- **User** → **Siswa** (Wali Kelas relationship)

## 🎨 UI/UX Features

### Design System
- **Tailwind CSS**: Utility-first CSS framework
- **Responsive Design**: Mobile-first approach
- **Dark Mode**: Support untuk tema gelap
- **Accessibility**: WCAG 2.1 compliant

### Components
- **Livewire**: Real-time interactions tanpa refresh
- **Modal Dialogs**: Form input yang user-friendly
- **Data Tables**: Pagination dan sorting
- **Tree Views**: Hierarchical data display
- **Form Validation**: Real-time validation feedback

## 🔒 Security Features

- **CSRF Protection**: Built-in Laravel protection
- **XSS Prevention**: Input sanitization
- **SQL Injection**: Eloquent ORM protection
- **Authentication**: Laravel Breeze dengan session management
- **Authorization**: Role-based access control
- **Input Validation**: Comprehensive form validation

## 🧪 Testing

### Test Suite
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/CurriculumManagementTest.php

# Run tests with coverage
php artisan test --coverage
```

### Test Categories
- **Feature Tests**: End-to-end functionality testing
- **Unit Tests**: Individual component testing
- **Browser Tests**: User interaction testing
- **Database Tests**: Data integrity testing

## 📈 Performance

### Optimization Strategies
- **Database Indexing**: Optimized queries dengan proper indexing
- **Eager Loading**: Mencegah N+1 query problems
- **Caching**: Redis/Memcached untuk data yang sering diakses
- **Asset Optimization**: Minified CSS/JS untuk production

### Monitoring
- **Query Logging**: Database query performance monitoring
- **Error Tracking**: Comprehensive error logging
- **Performance Metrics**: Response time monitoring

## 🚀 Deployment

### Production Checklist
- [ ] Environment variables configured
- [ ] Database optimized dan indexed
- [ ] Assets compiled dan optimized
- [ ] SSL certificate installed
- [ ] Backup strategy implemented
- [ ] Monitoring tools configured

### Deployment Commands
```bash
# Production build
npm run build

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Database optimization
php artisan migrate --force
```

## 📚 Dokumentasi Lengkap

- **[Manajemen Kurikulum](README-CURRICULUM.md)** - Panduan lengkap fitur kurikulum
- **[Import Data Siswa](README-IMPORT.md)** - Panduan import data siswa
- **[Manajemen Mata Pelajaran](README-MATAPELAJARAN.md)** - Panduan mata pelajaran
- **[Manajemen Rombel](README-ROMBEL.md)** - Panduan rombongan belajar

## 🤝 Contributing

Kami menyambut kontribusi dari komunitas! Silakan:

1. **Fork** repository
2. **Create** feature branch (`git checkout -b feature/AmazingFeature`)
3. **Commit** perubahan (`git commit -m 'Add some AmazingFeature'`)
4. **Push** ke branch (`git push origin feature/AmazingFeature`)
5. **Open** Pull Request

### Coding Standards
- PSR-12 coding standards
- Comprehensive testing coverage
- Clear documentation
- Performance considerations

## 📄 License

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 🙏 Acknowledgments

- **Laravel Team** - Framework yang powerful
- **Livewire Team** - Real-time components
- **Tailwind CSS** - Utility-first CSS framework
- **Komunitas Pendidikan Indonesia** - Inspirasi dan feedback

## 📞 Support

- **Issues**: [GitHub Issues](https://github.com/your-username/UnAs-Laravel/issues)
- **Discussions**: [GitHub Discussions](https://github.com/your-username/UnAs-Laravel/discussions)
- **Email**: support@unas-laravel.com

---

**Dibuat dengan ❤️ untuk kemajuan pendidikan Indonesia**

*UnAs-Laravel adalah sistem manajemen sekolah yang revolusioner, dirancang untuk memberikan fleksibilitas maksimal dalam mengelola berbagai jenis kurikulum tanpa perlu mengubah kode aplikasi.*
