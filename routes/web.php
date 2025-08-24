<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\ReportGenerator;
use App\Livewire\KepsekRekapNilai;
use App\Livewire\AdminValidasiKenaikan;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('/cetak-rapor', ReportGenerator::class)->name('cetak-rapor');
    Route::get('/rekap-nilai', KepsekRekapNilai::class)->name('rekap-nilai');
    Route::get('/validasi-kenaikan', AdminValidasiKenaikan::class)->name('validasi-kenaikan');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('user-management')->name('user-management.')->group(function () {
        Route::get('/', App\Livewire\UserManagement\UserTable::class)->name('index');
        Route::get('/create', App\Livewire\UserManagement\UserForm::class)->name('create');
        Route::get('/{user}/edit', App\Livewire\UserManagement\UserForm::class)->name('edit');
        Route::delete('/{user}', App\Livewire\UserManagement\UserTable::class)->name('destroy');
    });

    // Kelas Management Routes
    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', App\Livewire\KelasManagement\KelasTable::class)->name('index');
        Route::get('/create', App\Livewire\KelasManagement\KelasForm::class)->name('create');
        Route::get('/{kelas}/edit', App\Livewire\KelasManagement\KelasForm::class)->name('edit');
        Route::delete('/{kelas}', App\Livewire\KelasManagement\KelasTable::class)->name('destroy');
    });

    // Rombel Management Routes
    Route::prefix('rombel')->name('rombel.')->group(function () {
        Route::get('/', function () {
            return view('rombel.index');
        })->name('index');
        Route::get('/create', function () {
            return view('rombel.create');
        })->name('create');
        Route::get('/{rombel}/edit', function ($rombel) {
            return view('rombel.edit', compact('rombel'));
        })->name('edit');
        Route::delete('/{rombel}', App\Livewire\RombelManagement\RombelTable::class)->name('destroy');
    });

    // Siswa Management Routes
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', App\Livewire\SiswaManagement\SiswaTable::class)->name('index');
        Route::get('/create', App\Livewire\SiswaManagement\SiswaForm::class)->name('create');
        Route::get('/{siswa}/edit', App\Livewire\SiswaManagement\SiswaForm::class)->name('edit');
        Route::get('/import', App\Livewire\SiswaManagement\SiswaImport::class)->name('import');
        Route::get('/kenaikan-kelas', App\Livewire\SiswaManagement\SiswaKenaikanKelas::class)->name('kenaikan-kelas');
    });

    // Mata Pelajaran Management Routes
    Route::prefix('mata-pelajaran')->name('mata-pelajaran.')->group(function () {
        Route::get('/', App\Livewire\MataPelajaranManagement\MataPelajaranTable::class)->name('index');
        Route::get('/create', App\Livewire\MataPelajaranManagement\MataPelajaranForm::class)->name('create');
        Route::get('/{mataPelajaran}/edit', App\Livewire\MataPelajaranManagement\MataPelajaranForm::class)->name('edit');
        Route::delete('/{mataPelajaran}', App\Livewire\MataPelajaranManagement\MataPelajaranTable::class)->name('destroy');
    });

    // Curriculum Management Routes
    Route::prefix('kurikulum')->name('kurikulum.')->group(function () {
        Route::get('/', App\Livewire\CurriculumManagement\ManageCurriculum::class)->name('index');
    });

    // Grade Management Routes
    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', App\Livewire\GradeManagement\GradeIndex::class)->name('index');
        Route::get('/input', App\Livewire\GradeManagement\GradeInput::class)->name('input');
        Route::get('/history', App\Livewire\GradeManagement\GradeHistory::class)->name('history');
        Route::get('/detail/{gradeId}', App\Livewire\GradeManagement\GradeDetail::class)->name('detail');
        Route::get('/edit/{gradeId}', App\Livewire\GradeManagement\GradeInput::class)->name('edit');
        Route::get('/report', App\Livewire\GradeManagement\GradeIndex::class)->name('report');
        Route::get('/import', App\Livewire\GradeManagement\GradeIndex::class)->name('import');
        Route::get('/export', App\Livewire\GradeManagement\GradeIndex::class)->name('export');
    });

    // Attendance Management Routes
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/input', App\Livewire\AttendanceManagement\InputAbsensi::class)->name('input');
    });

    // Wali Kelas Management Routes
    Route::prefix('wali-kelas')->name('wali-kelas.')->group(function () {
        Route::get('/catatan', App\Livewire\WaliKelasManagement\InputCatatanWaliKelas::class)->name('catatan');
        Route::get('/usulan-kenaikan', App\Livewire\WaliKelasManagement\ProposePromotion::class)->name('usulan-kenaikan');
    });
});

require __DIR__.'/auth.php';
