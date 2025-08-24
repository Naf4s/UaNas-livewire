<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if data already exists
        if (Kelas::count() > 0) {
            $this->command->info('Kelas data already exists, skipping...');
            return;
        }

        $kelasData = [
            // Kelas X (SMA)
            [
                'nama_kelas' => 'X IPA 1',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X IPA 1 dengan fokus pada pengembangan dasar sains dan matematika',
                'status' => 'aktif'
            ],
            [
                'nama_kelas' => 'X IPA 2',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X IPA 2 dengan program unggulan pengembangan karakter',
                'status' => 'aktif'
            ],
            [
                'nama_kelas' => 'X IPS 1',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X IPS 1 dengan fokus pada pengembangan kemampuan sosial dan ekonomi',
                'status' => 'aktif'
            ],
            [
                'nama_kelas' => 'X IPS 2',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X IPS 2 dengan program unggulan kreativitas seni',
                'status' => 'aktif'
            ],

            // Kelas XI (SMA)
            [
                'nama_kelas' => 'XI IPA 1',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI IPA 1 dengan fokus pada pengembangan logika dan pemecahan masalah',
                'status' => 'aktif'
            ],
            [
                'nama_kelas' => 'XI IPA 2',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI IPA 2 dengan program unggulan bahasa Inggris dasar',
                'status' => 'aktif'
            ],
            [
                'nama_kelas' => 'XI IPS 1',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI IPS 1 dengan fokus pada pengembangan kemampuan analitis',
                'status' => 'aktif'
            ],
            [
                'nama_kelas' => 'XI IPS 2',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI IPS 2 dengan program unggulan teknologi informasi',
                'status' => 'aktif'
            ],

            // Kelas XII (SMA)
            [
                'nama_kelas' => 'XII IPA 1',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII IPA 1 dengan persiapan intensif untuk ujian nasional',
                'status' => 'aktif'
            ],
            [
                'nama_kelas' => 'XII IPA 2',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII IPA 2 dengan program unggulan persiapan perguruan tinggi',
                'status' => 'aktif'
            ],
            [
                'nama_kelas' => 'XII IPS 1',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII IPS 1 dengan persiapan intensif untuk ujian nasional',
                'status' => 'aktif'
            ],
            [
                'nama_kelas' => 'XII IPS 2',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII IPS 2 dengan program unggulan persiapan perguruan tinggi',
                'status' => 'aktif'
            ],

            // Kelas Nonaktif (contoh)
            [
                'nama_kelas' => 'X IPA 3',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X IPA 3 yang sudah tidak aktif',
                'status' => 'nonaktif'
            ]
        ];

        foreach ($kelasData as $kelas) {
            Kelas::create($kelas);
        }
    }
}
