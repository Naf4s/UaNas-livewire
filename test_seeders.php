<?php

/**
 * Simple test script to verify seeders work correctly
 * Run this with: php test_seeders.php
 */

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TemplateKurikulum;
use App\Models\AspekPenilaian;
use App\Models\GradeSetting;
use App\Models\Siswa;
use App\Models\Rombel;

echo "Testing Laravel Application...\n";
echo "==============================\n\n";

try {
    // Test database connection
    echo "1. Testing database connection...\n";
    DB::connection()->getPdo();
    echo "✓ Database connection successful\n\n";

    // Test UserSeeder
    echo "2. Testing UserSeeder...\n";
    $userCount = User::count();
    echo "Current users: $userCount\n";
    
    if ($userCount == 0) {
        echo "Running UserSeeder...\n";
        $seeder = new \Database\Seeders\UserSeeder();
        $seeder->run();
        $userCount = User::count();
        echo "✓ Users created: $userCount\n";
    } else {
        echo "✓ Users already exist\n";
    }
    echo "\n";

    // Test KelasSeeder
    echo "3. Testing KelasSeeder...\n";
    $kelasCount = Kelas::count();
    echo "Current kelas: $kelasCount\n";
    
    if ($kelasCount == 0) {
        echo "Running KelasSeeder...\n";
        $seeder = new \Database\Seeders\KelasSeeder();
        $seeder->run();
        $kelasCount = Kelas::count();
        echo "✓ Kelas created: $kelasCount\n";
    } else {
        echo "✓ Kelas already exist\n";
    }
    echo "\n";

    // Test MataPelajaranSeeder
    echo "4. Testing MataPelajaranSeeder...\n";
    $mapelCount = MataPelajaran::count();
    echo "Current mata pelajaran: $mapelCount\n";
    
    if ($mapelCount == 0) {
        echo "Running MataPelajaranSeeder...\n";
        $seeder = new \Database\Seeders\MataPelajaranSeeder();
        $seeder->run();
        $mapelCount = MataPelajaran::count();
        echo "✓ Mata pelajaran created: $mapelCount\n";
    } else {
        echo "✓ Mata pelajaran already exist\n";
    }
    echo "\n";

    // Test TemplateKurikulumSeeder
    echo "5. Testing TemplateKurikulumSeeder...\n";
    $templateCount = TemplateKurikulum::count();
    echo "Current templates: $templateCount\n";
    
    if ($templateCount == 0) {
        echo "Running TemplateKurikulumSeeder...\n";
        $seeder = new \Database\Seeders\TemplateKurikulumSeeder();
        $seeder->run();
        $templateCount = TemplateKurikulum::count();
        echo "✓ Templates created: $templateCount\n";
    } else {
        echo "✓ Templates already exist\n";
    }
    echo "\n";

    // Test GradeSettingSeeder
    echo "6. Testing GradeSettingSeeder...\n";
    $gradeSettingCount = GradeSetting::count();
    echo "Current grade settings: $gradeSettingCount\n";
    
    if ($gradeSettingCount == 0) {
        echo "Running GradeSettingSeeder...\n";
        $seeder = new \Database\Seeders\GradeSettingSeeder();
        $seeder->run();
        $gradeSettingCount = GradeSetting::count();
        echo "✓ Grade settings created: $gradeSettingCount\n";
    } else {
        echo "✓ Grade settings already exist\n";
    }
    echo "\n";

    // Test SampleDataSeeder
    echo "7. Testing SampleDataSeeder...\n";
    $siswaCount = Siswa::count();
    echo "Current siswa: $siswaCount\n";
    
    if ($siswaCount == 0) {
        echo "Running SampleDataSeeder...\n";
        $seeder = new \Database\Seeders\SampleDataSeeder();
        $seeder->run();
        $siswaCount = Siswa::count();
        echo "✓ Sample data created: $siswaCount siswa\n";
    } else {
        echo "✓ Sample data already exist\n";
    }
    echo "\n";

    // Test relationships
    echo "8. Testing relationships...\n";
    $siswa = Siswa::with(['rombel.kelas', 'grades.mataPelajaran'])->first();
    if ($siswa) {
        echo "✓ Siswa found: " . $siswa->nama_lengkap . "\n";
        
        if ($siswa->rombel->count() > 0) {
            echo "✓ Rombel relationship working\n";
            $rombel = $siswa->rombel->first();
            if ($rombel->kelas) {
                echo "✓ Kelas relationship working: " . $rombel->kelas->nama_kelas . "\n";
            } else {
                echo "✗ Kelas relationship failed\n";
            }
        } else {
            echo "✗ Rombel relationship failed\n";
        }
        
        if ($siswa->grades->count() > 0) {
            echo "✓ Grades relationship working\n";
        } else {
            echo "✗ Grades relationship failed\n";
        }
    } else {
        echo "✗ No siswa found to test relationships\n";
    }
    echo "\n";

    echo "==============================\n";
    echo "✓ All tests completed successfully!\n";

} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
