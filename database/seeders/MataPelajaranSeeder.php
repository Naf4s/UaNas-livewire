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
        $mataPelajaran = [
            // Kelompok A (Wajib)
            [
                'kode_mapel' => 'PAI',
                'nama_mapel' => 'Pendidikan Agama Islam dan Budi Pekerti',
                'deskripsi' => 'Mata pelajaran wajib untuk semua siswa',
                'jenis' => 'Wajib',
                'jumlah_jam' => 3,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib nasional'
            ],
            [
                'kode_mapel' => 'PPKN',
                'nama_mapel' => 'Pendidikan Pancasila dan Kewarganegaraan',
                'deskripsi' => 'Mata pelajaran wajib untuk semua siswa',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib nasional'
            ],
            [
                'kode_mapel' => 'BIN',
                'nama_mapel' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran wajib untuk semua siswa',
                'jenis' => 'Wajib',
                'jumlah_jam' => 4,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib nasional'
            ],
            [
                'kode_mapel' => 'MTK',
                'nama_mapel' => 'Matematika',
                'deskripsi' => 'Mata pelajaran wajib untuk semua siswa',
                'jenis' => 'Wajib',
                'jumlah_jam' => 4,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib nasional'
            ],
            [
                'kode_mapel' => 'SEJ',
                'nama_mapel' => 'Sejarah Indonesia',
                'deskripsi' => 'Mata pelajaran wajib untuk semua siswa',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib nasional'
            ],
            [
                'kode_mapel' => 'BIG',
                'nama_mapel' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran wajib untuk semua siswa',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'A',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib nasional'
            ],

            // Kelompok B (Wajib)
            [
                'kode_mapel' => 'SEN',
                'nama_mapel' => 'Seni Budaya',
                'deskripsi' => 'Mata pelajaran wajib untuk semua siswa',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'B',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib nasional'
            ],
            [
                'kode_mapel' => 'PJK',
                'nama_mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'deskripsi' => 'Mata pelajaran wajib untuk semua siswa',
                'jenis' => 'Wajib',
                'jumlah_jam' => 3,
                'kelompok' => 'B',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib nasional'
            ],
            [
                'kode_mapel' => 'PRA',
                'nama_mapel' => 'Prakarya dan Kewirausahaan',
                'deskripsi' => 'Mata pelajaran wajib untuk semua siswa',
                'jenis' => 'Wajib',
                'jumlah_jam' => 2,
                'kelompok' => 'B',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran wajib nasional'
            ],

            // Kelompok C (Peminatan IPA)
            [
                'kode_mapel' => 'FIS',
                'nama_mapel' => 'Fisika',
                'deskripsi' => 'Mata pelajaran peminatan untuk jurusan IPA',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 4,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan IPA'
            ],
            [
                'kode_mapel' => 'KIM',
                'nama_mapel' => 'Kimia',
                'deskripsi' => 'Mata pelajaran peminatan untuk jurusan IPA',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 4,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan IPA'
            ],
            [
                'kode_mapel' => 'BIO',
                'nama_mapel' => 'Biologi',
                'deskripsi' => 'Mata pelajaran peminatan untuk jurusan IPA',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 4,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan IPA'
            ],

            // Kelompok C (Peminatan IPS)
            [
                'kode_mapel' => 'GEO',
                'nama_mapel' => 'Geografi',
                'deskripsi' => 'Mata pelajaran peminatan untuk jurusan IPS',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 4,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan IPS'
            ],
            [
                'kode_mapel' => 'EKO',
                'nama_mapel' => 'Ekonomi',
                'deskripsi' => 'Mata pelajaran peminatan untuk jurusan IPS',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 4,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan IPS'
            ],
            [
                'kode_mapel' => 'SOS',
                'nama_mapel' => 'Sosiologi',
                'deskripsi' => 'Mata pelajaran peminatan untuk jurusan IPS',
                'jenis' => 'Peminatan',
                'jumlah_jam' => 4,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran peminatan IPS'
            ],

            // Muatan Lokal
            [
                'kode_mapel' => 'BJD',
                'nama_mapel' => 'Bahasa Jawa',
                'deskripsi' => 'Mata pelajaran muatan lokal',
                'jenis' => 'Muatan Lokal',
                'jumlah_jam' => 2,
                'kelompok' => 'C',
                'status' => 'aktif',
                'catatan' => 'Mata pelajaran muatan lokal Jawa'
            ],
        ];

        foreach ($mataPelajaran as $mapel) {
            MataPelajaran::create($mapel);
        }
    }
}
