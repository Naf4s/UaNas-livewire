<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\Absensi;
use App\Models\Grade;
use App\Models\CatatanWaliKelas;
use App\Models\UsulanKenaikanKelas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if sample data already exists
        if (Siswa::count() > 0) {
            $this->command->info('Sample data already exists, skipping...');
            return;
        }

        $this->createSampleSiswa();
        $this->createSampleRombel();
        $this->createSampleAbsensi();
        $this->createSampleGrades();
        $this->createSampleCatatanWaliKelas();
        $this->createSampleUsulanKenaikanKelas();
    }

    private function createSampleSiswa(): void
    {
        $namaSiswa = [
            'Ahmad Fadillah', 'Siti Nurhaliza', 'Muhammad Rizki', 'Dewi Sartika', 'Budi Santoso',
            'Nina Marlina', 'Raden Mas Suryo', 'Putri Indah', 'Joko Widodo', 'Sri Wahyuni',
            'Ahmad Dahlan', 'Fatimah Azzahra', 'Muhammad Hatta', 'Kartini', 'Soekarno',
            'Megawati', 'Susilo Bambang', 'Rini Mariani', 'Bambang Tri', 'Siti Aisyah',
            'Ahmad Yani', 'Cut Nyak Dien', 'Pattimura', 'Imam Bonjol', 'Teuku Umar',
            'Nyi Ageng Serang', 'Ki Hajar Dewantara', 'Raden Ajeng', 'Muhammad Syafii',
            'Nurul Huda', 'Ahmad Syafiq', 'Siti Rahma', 'Muhammad Fauzi', 'Dinda Safitri',
            'Rizki Pratama', 'Nabila Putri', 'Aditya Nugraha', 'Salsabila', 'Muhammad Rafi',
            'Aisyah Putri', 'Fadli Ramadhan', 'Nurul Hidayah', 'Muhammad Iqbal', 'Siti Fatimah',
            'Rizki Fadillah', 'Nabila Safira', 'Aditya Pratama', 'Salsabila Putri', 'Muhammad Rizki',
            'Aisyah Safira', 'Fadli Ramadhan', 'Nurul Hidayah', 'Muhammad Iqbal', 'Siti Fatimah'
        ];

        // Get existing users for siswa creation
        $users = User::where('role', '!=', 'admin')->get();
        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        for ($i = 0; $i < 50; $i++) {
            $user = $users->get($i % $users->count());
            
            Siswa::create([
                'user_id' => $user->id,
                'nis' => 'SIS' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nisn' => 'NISN' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'nama_lengkap' => $namaSiswa[$i],
                'nama_panggilan' => explode(' ', $namaSiswa[$i])[0],
                'jenis_kelamin' => $i % 2 == 0 ? 'L' : 'P',
                'tempat_lahir' => ['Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Yogyakarta'][rand(0, 4)],
                'tanggal_lahir' => Carbon::now()->subYears(rand(15, 18))->subDays(rand(1, 365)),
                'agama' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'][rand(0, 4)],
                'alamat' => 'Jl. ' . ['Merdeka', 'Sudirman', 'Thamrin', 'Gatot Subroto', 'Menteng'][rand(0, 4)] . ' No. ' . ($i + 1),
                'rt_rw' => rand(1, 20) . '/' . rand(1, 10),
                'desa_kelurahan' => ['Menteng', 'Gambir', 'Tanah Abang', 'Kemayoran', 'Senen'][rand(0, 4)],
                'kecamatan' => ['Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Barat', 'Jakarta Utara', 'Jakarta Timur'][rand(0, 4)],
                'kabupaten_kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => rand(10000, 99999),
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'email' => 'siswa' . ($i + 1) . '@example.com',
                'nama_ayah' => 'Ayah ' . $namaSiswa[$i],
                'pekerjaan_ayah' => ['PNS', 'Swasta', 'Wiraswasta', 'TNI/POLRI', 'Pensiunan'][rand(0, 4)],
                'no_hp_ayah' => '08' . rand(1000000000, 9999999999),
                'nama_ibu' => 'Ibu ' . $namaSiswa[$i],
                'pekerjaan_ibu' => ['Ibu Rumah Tangga', 'PNS', 'Swasta', 'Wiraswasta', 'Guru'][rand(0, 4)],
                'no_hp_ibu' => '08' . rand(1000000000, 9999999999),
                'alamat_ortu' => 'Jl. ' . ['Merdeka', 'Sudirman', 'Thamrin', 'Gatot Subroto', 'Menteng'][rand(0, 4)] . ' No. ' . ($i + 1),
                'nama_wali' => null,
                'pekerjaan_wali' => null,
                'no_hp_wali' => null,
                'alamat_wali' => null,
                'status_siswa' => 'aktif',
                'tanggal_masuk' => Carbon::now()->subYears(rand(1, 3)),
                'tanggal_keluar' => null,
                'keterangan' => 'Siswa aktif'
            ]);
        }
    }

    private function createSampleRombel(): void
    {
        $namaRombel = [
            'X IPA 1', 'X IPA 2', 'X IPS 1', 'X IPS 2', 'XI IPA 1',
            'XI IPA 2', 'XI IPS 1', 'XI IPS 2', 'XII IPA 1', 'XII IPA 2'
        ];

        // Get existing kelas and users
        $kelas = \App\Models\Kelas::orderBy('tingkat')->get();
        $waliKelas = User::where('role', 'guru')->get();

        if ($kelas->isEmpty()) {
            $this->command->error('No kelas found. Please run KelasSeeder first.');
            return;
        }

        if ($waliKelas->isEmpty()) {
            $this->command->error('No guru users found. Please run UserSeeder first.');
            return;
        }

        $this->command->info('Available kelas: ' . $kelas->pluck('nama_kelas', 'id')->implode(', '));
        $this->command->info('Available guru users: ' . $waliKelas->pluck('name', 'id')->implode(', '));

        // Group kelas by tingkat
        $kelasByTingkat = [];
        foreach ($kelas as $k) {
            $kelasByTingkat[$k->tingkat][] = $k;
        }

        $this->command->info('Kelas grouped by tingkat: ' . json_encode($kelasByTingkat, JSON_PRETTY_PRINT));

        for ($i = 0; $i < 10; $i++) {
            // Determine tingkat based on index
            if ($i < 4) {
                $tingkat = 'X';
            } elseif ($i < 8) {
                $tingkat = 'XI';
            } else {
                $tingkat = 'XII';
            }

            // Find a kelas with matching tingkat
            $kelasForTingkat = $kelasByTingkat[$tingkat] ?? null;
            if (!$kelasForTingkat) {
                $this->command->warn("No kelas found for tingkat $tingkat, skipping rombel $namaRombel[$i]");
                continue;
            }

            // Use the first available kelas for this tingkat
            $kelasId = $kelasForTingkat[0]->id;
            $waliKelasId = $waliKelas->get($i % $waliKelas->count())->id;
            
            $this->command->info("Creating rombel: $namaRombel[$i] with kelas_id: $kelasId, wali_kelas_id: $waliKelasId");
            
            try {
                // Verify the foreign keys exist before creating
                $kelasExists = \App\Models\Kelas::find($kelasId);
                $userExists = User::find($waliKelasId);
                
                if (!$kelasExists) {
                    throw new \Exception("Kelas with ID $kelasId does not exist");
                }
                
                if (!$userExists) {
                    throw new \Exception("User with ID $waliKelasId does not exist");
                }
                
                Rombel::create([
                    'nama_rombel' => $namaRombel[$i],
                    'kode_rombel' => 'ROM' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'kelas_id' => $kelasId,
                    'kapasitas' => rand(25, 35),
                    'jumlah_siswa' => 0,
                    'wali_kelas_id' => $waliKelasId,
                    'deskripsi' => 'Rombel ' . $namaRombel[$i] . ' untuk tahun ajaran 2024/2025',
                    'status' => 'aktif',
                ]);
                
                $this->command->info("✓ Successfully created rombel: $namaRombel[$i]");
                
            } catch (\Exception $e) {
                $this->command->error("✗ Failed to create rombel $namaRombel[$i]: " . $e->getMessage());
                $this->command->error("Data: kelas_id=$kelasId, wali_kelas_id=$waliKelasId");
            }
        }
    }

    private function createSampleAbsensi(): void
    {
        $statuses = ['hadir', 'sakit', 'izin', 'alpha'];
        $keterangan = [
            'Hadir tepat waktu', 'Sakit flu', 'Izin keluarga', 'Alpha tanpa keterangan',
            'Hadir terlambat', 'Sakit demam', 'Izin acara keluarga', 'Alpha sakit',
            'Hadir pagi', 'Sakit batuk', 'Izin keperluan penting', 'Alpha tidak ada kabar'
        ];

        // Create absensi for the last 30 days
        for ($day = 0; $day < 30; $day++) {
            $tanggal = Carbon::now()->subDays($day);
            
            // Create absensi for 20-30 students each day
            $jumlahSiswa = rand(20, 30);
            for ($i = 0; $i < $jumlahSiswa; $i++) {
                $status = $statuses[rand(0, 3)];
                $keteranganIndex = rand(0, count($keterangan) - 1);
                
                Absensi::create([
                    'siswa_id' => rand(1, 50),
                    'tanggal' => $tanggal,
                    'status' => $status,
                    'keterangan' => $keterangan[$keteranganIndex],
                ]);
            }
        }
    }

    private function createSampleGrades(): void
    {
        $nilaiRange = [
            'A' => [85, 100],
            'B' => [70, 84],
            'C' => [60, 69],
            'D' => [0, 59]
        ];

        // Get existing mata pelajaran and aspek penilaian
        $mataPelajaran = \App\Models\MataPelajaran::all();
        $aspekPenilaian = \App\Models\AspekPenilaian::all();

        if ($mataPelajaran->isEmpty() || $aspekPenilaian->isEmpty()) {
            $this->command->error('Mata pelajaran or aspek penilaian not found. Please run MataPelajaranSeeder and GradeSettingSeeder first.');
            return;
        }

        for ($i = 0; $i < 200; $i++) {
            $grade = array_rand($nilaiRange);
            $nilai = rand($nilaiRange[$grade][0], $nilaiRange[$grade][1]);
            
            Grade::create([
                'siswa_id' => rand(1, 50),
                'mata_pelajaran_id' => $mataPelajaran->random()->id,
                'aspek_penilaian_id' => $aspekPenilaian->random()->id,
                'nilai' => $nilai,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2024/2025',
            ]);
        }
    }

    private function createSampleCatatanWaliKelas(): void
    {
        $catatanAkademik = [
            'Siswa menunjukkan kemajuan yang baik dalam pembelajaran',
            'Perlu peningkatan dalam mata pelajaran matematika',
            'Siswa aktif dalam diskusi kelas',
            'Memiliki potensi yang baik dalam bidang sains',
            'Perlu latihan lebih dalam pemecahan masalah',
            'Siswa kreatif dalam mengerjakan tugas',
            'Memiliki kemampuan analisis yang baik',
            'Perlu peningkatan dalam bahasa Inggris',
            'Siswa rajin mengumpulkan tugas tepat waktu',
            'Memiliki minat yang tinggi dalam seni'
        ];

        $catatanNonAkademik = [
            'Siswa ramah dan mudah bergaul dengan teman',
            'Memiliki jiwa kepemimpinan yang baik',
            'Aktif dalam kegiatan ekstrakurikuler',
            'Memiliki sikap yang sopan dan santun',
            'Siswa disiplin dalam mengikuti aturan sekolah',
            'Memiliki kreativitas dalam berorganisasi',
            'Aktif dalam kegiatan sosial sekolah',
            'Memiliki semangat yang tinggi dalam belajar',
            'Siswa bertanggung jawab terhadap tugas piket',
            'Memiliki kemampuan komunikasi yang baik'
        ];

        // Get existing rombel
        $rombel = Rombel::all();
        if ($rombel->isEmpty()) {
            $this->command->error('No rombel found. Please run RombelSeeder first.');
            return;
        }

        for ($i = 0; $i < 30; $i++) {
            CatatanWaliKelas::create([
                'siswa_id' => rand(1, 50),
                'rombel_id' => $rombel->random()->id,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2024/2025',
                'catatan_akademik' => $catatanAkademik[rand(0, count($catatanAkademik) - 1)],
                'catatan_non_akademik' => $catatanNonAkademik[rand(0, count($catatanNonAkademik) - 1)],
                'tanggal_catatan' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }

    private function createSampleUsulanKenaikanKelas(): void
    {
        $statuses = ['pending', 'disetujui', 'ditolak'];
        $alasan = [
            'Siswa telah memenuhi kriteria kelulusan',
            'Nilai akademik memenuhi standar minimum',
            'Kehadiran siswa di atas 80%',
            'Siswa aktif dalam kegiatan sekolah',
            'Tidak ada pelanggaran serius',
            'Siswa menunjukkan perkembangan positif',
            'Memenuhi syarat administrasi',
            'Siswa berprestasi dalam bidang akademik',
            'Kehadiran dan kedisiplinan baik',
            'Siswa memiliki motivasi belajar tinggi'
        ];

        // Get existing rombel
        $rombel = Rombel::all();
        if ($rombel->isEmpty()) {
            $this->command->error('No rombel found. Please run RombelSeeder first.');
            return;
        }

        for ($i = 0; $i < 25; $i++) {
            UsulanKenaikanKelas::create([
                'siswa_id' => rand(1, 50),
                'rombel_id' => $rombel->random()->id,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2024/2025',
                'status_usulan' => $statuses[rand(0, 2)],
                'alasan' => $alasan[rand(0, count($alasan) - 1)],
                'tanggal_usulan' => Carbon::now()->subDays(rand(1, 60)),
            ]);
        }
    }
}
