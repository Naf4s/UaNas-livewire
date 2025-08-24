<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if data already exists
        if (MataPelajaran::count() > 0) {
            $this->command->info('Mata Pelajaran data already exists, skipping...');
            return;
        }

        $mataPelajaran = [
            // Kelompok A - Mata Pelajaran Wajib
            [
                'kode_mapel' => 'PAI',
                'nama_mapel' => 'Pendidikan Agama Islam dan Budi Pekerti',
                'deskripsi' => 'Mata pelajaran yang mengajarkan nilai-nilai agama Islam dan budi pekerti',
                'jenis' => 'Wajib',
                'jumlah_jam' => 3,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib untuk semua siswa'
            ],
            [
                'kode_mapel' => 'PPKN',
                'nama_mapel' => 'Pendidikan Pancasila dan Kewarganegaraan',
                'deskripsi' => 'Mata pelajaran yang mengajarkan nilai-nilai Pancasila dan kewarganegaraan',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib untuk semua siswa'
            ],
            [
                'kode_mapel' => 'BINDO',
                'nama_mapel' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran yang mengajarkan kemampuan berbahasa Indonesia',
                'jenis' => 'Wajib',
                'jumlah_jam' => 4,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib untuk semua siswa'
            ],
            [
                'kode_mapel' => 'MAT',
                'nama_mapel' => 'Matematika',
                'deskripsi' => 'Mata pelajaran yang mengajarkan konsep matematika dan pemecahan masalah',
                'jenis' => 'Wajib',
                'jumlah_jam' => 4,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib untuk semua siswa'
            ],
            [
                'kode_mapel' => 'SEJ',
                'nama_mapel' => 'Sejarah Indonesia',
                'deskripsi' => 'Mata pelajaran yang mengajarkan sejarah bangsa Indonesia',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib untuk semua siswa'
            ],
            [
                'kode_mapel' => 'ING',
                'nama_mapel' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran yang mengajarkan kemampuan berbahasa Inggris',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib untuk semua siswa'
            ],

            // Kelompok B - Mata Pelajaran Wajib
            [
                'kode_mapel' => 'SENBUD',
                'nama_mapel' => 'Seni Budaya',
                'deskripsi' => 'Mata pelajaran yang mengajarkan apresiasi seni dan budaya',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'B',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib untuk semua siswa'
            ],
            [
                'kode_mapel' => 'PJOK',
                'nama_mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'deskripsi' => 'Mata pelajaran yang mengajarkan kebugaran jasmani dan kesehatan',
                'jenis' => 'Wajib',
                'jumlah_jam' => 3,
                'kelompok' => 'B',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib untuk semua siswa'
            ],
            [
                'kode_mapel' => 'PRAKARYA',
                'nama_mapel' => 'Prakarya dan Kewirausahaan',
                'deskripsi' => 'Mata pelajaran yang mengajarkan keterampilan dan kewirausahaan',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'B',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib untuk semua siswa'
            ],

            // Kelompok C - Mata Pelajaran Peminatan (IPA)
            [
                'kode_mapel' => 'FIS',
                'nama_mapel' => 'Fisika',
                'deskripsi' => 'Mata pelajaran yang mengajarkan konsep-konsep fisika',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 3,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan untuk jurusan IPA'
            ],
            [
                'kode_mapel' => 'KIM',
                'nama_mapel' => 'Kimia',
                'deskripsi' => 'Mata pelajaran yang mengajarkan konsep-konsep kimia',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 3,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan untuk jurusan IPA'
            ],
            [
                'kode_mapel' => 'BIO',
                'nama_mapel' => 'Biologi',
                'deskripsi' => 'Mata pelajaran yang mengajarkan konsep-konsep biologi',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 3,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan untuk jurusan IPA'
            ],

            // Kelompok C - Mata Pelajaran Peminatan (IPS)
            [
                'kode_mapel' => 'GEO',
                'nama_mapel' => 'Geografi',
                'deskripsi' => 'Mata pelajaran yang mengajarkan konsep-konsep geografi',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 3,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan untuk jurusan IPS'
            ],
            [
                'kode_mapel' => 'EKO',
                'nama_mapel' => 'Ekonomi',
                'deskripsi' => 'Mata pelajaran yang mengajarkan konsep-konsep ekonomi',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 3,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan untuk jurusan IPS'
            ],
            [
                'kode_mapel' => 'SOS',
                'nama_mapel' => 'Sosiologi',
                'deskripsi' => 'Mata pelajaran yang mengajarkan konsep-konsep sosiologi',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 3,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan untuk jurusan IPS'
            ],

            // Mata Pelajaran Lintas Minat
            [
                'kode_mapel' => 'BINDA',
                'nama_mapel' => 'Bahasa dan Sastra Indonesia',
                'deskripsi' => 'Mata pelajaran lintas minat untuk pengembangan bahasa',
                'jenis' => 'Lintas Minat',
                'jumlah_jam' => 2,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran lintas minat'
            ],
            [
                'kode_mapel' => 'BING',
                'nama_mapel' => 'Bahasa dan Sastra Inggris',
                'deskripsi' => 'Mata pelajaran lintas minat untuk pengembangan bahasa Inggris',
                'jenis' => 'Lintas Minat',
                'jumlah_jam' => 2,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran lintas minat'
            ],

            // Mata Pelajaran Muatan Lokal
            [
                'kode_mapel' => 'BSUNDA',
                'nama_mapel' => 'Bahasa Sunda',
                'deskripsi' => 'Mata pelajaran muatan lokal untuk pengembangan bahasa daerah',
                'jenis' => 'Muatan Lokal',
                'jumlah_jam' => 2,
                'kelompok' => 'B',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran muatan lokal sesuai karakteristik daerah'
            ],
            [
                'kode_mapel' => 'KEWIRA',
                'nama_mapel' => 'Kewirausahaan',
                'deskripsi' => 'Mata pelajaran muatan lokal untuk pengembangan jiwa wirausaha',
                'jenis' => 'Muatan Lokal',
                'jumlah_jam' => 2,
                'kelompok' => 'B',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran muatan lokal sesuai kebutuhan daerah'
            ]
        ];

        foreach ($mataPelajaran as $mapel) {
            MataPelajaran::create($mapel);
        }
    }
}
