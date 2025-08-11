<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TemplateKurikulum;
use App\Models\AspekPenilaian;

class TemplateKurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create K13 Template
        $k13Template = TemplateKurikulum::create([
            'nama_template' => 'Kurikulum 2013 SMA',
            'deskripsi' => 'Template kurikulum 2013 untuk SMA dengan aspek penilaian sikap, pengetahuan, dan keterampilan',
            'jenis_kurikulum' => 'K13',
            'status' => 'aktif',
            'tahun_berlaku' => 2024,
            'catatan' => 'Template default kurikulum 2013'
        ]);

        // Create Kurikulum Merdeka Template
        $merdekaTemplate = TemplateKurikulum::create([
            'nama_template' => 'Kurikulum Merdeka SMA',
            'deskripsi' => 'Template kurikulum merdeka untuk SMA dengan aspek penilaian yang lebih fleksibel',
            'jenis_kurikulum' => 'Kurikulum Merdeka',
            'status' => 'nonaktif',
            'tahun_berlaku' => 2024,
            'catatan' => 'Template kurikulum merdeka'
        ]);

        // Create sample aspek penilaian for K13
        $this->createK13AspekPenilaian($k13Template->id);
    }

    private function createK13AspekPenilaian($templateId)
    {
        // Domain 1: Sikap Spiritual
        $sikapSpiritual = AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => null,
            'nama_aspek' => 'Sikap Spiritual',
            'deskripsi' => 'Aspek penilaian untuk sikap spiritual siswa',
            'tipe' => 'domain',
            'urutan' => 1,
            'bobot' => 15.00,
            'status' => 'aktif',
            'catatan' => 'Domain utama untuk penilaian sikap spiritual'
        ]);

        // Sub-aspek untuk Sikap Spiritual
        AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => $sikapSpiritual->id,
            'nama_aspek' => 'Beriman dan Bertakwa',
            'deskripsi' => 'Kemampuan siswa dalam menunjukkan keimanan dan ketakwaan',
            'tipe' => 'aspek',
            'urutan' => 1,
            'bobot' => 7.50,
            'status' => 'aktif',
            'catatan' => 'Sub-aspek keimanan dan ketakwaan'
        ]);

        AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => $sikapSpiritual->id,
            'nama_aspek' => 'Berakhlak Mulia',
            'deskripsi' => 'Kemampuan siswa dalam menunjukkan akhlak mulia',
            'tipe' => 'aspek',
            'urutan' => 2,
            'bobot' => 7.50,
            'status' => 'aktif',
            'catatan' => 'Sub-aspek akhlak mulia'
        ]);

        // Domain 2: Sikap Sosial
        $sikapSosial = AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => null,
            'nama_aspek' => 'Sikap Sosial',
            'deskripsi' => 'Aspek penilaian untuk sikap sosial siswa',
            'tipe' => 'domain',
            'urutan' => 2,
            'bobot' => 15.00,
            'status' => 'aktif',
            'catatan' => 'Domain utama untuk penilaian sikap sosial'
        ]);

        // Sub-aspek untuk Sikap Sosial
        AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => $sikapSosial->id,
            'nama_aspek' => 'Jujur',
            'deskripsi' => 'Kemampuan siswa dalam menunjukkan kejujuran',
            'tipe' => 'aspek',
            'urutan' => 1,
            'bobot' => 5.00,
            'status' => 'aktif',
            'catatan' => 'Sub-aspek kejujuran'
        ]);

        AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => $sikapSosial->id,
            'nama_aspek' => 'Disiplin',
            'deskripsi' => 'Kemampuan siswa dalam menunjukkan kedisiplinan',
            'tipe' => 'aspek',
            'urutan' => 2,
            'bobot' => 5.00,
            'status' => 'aktif',
            'catatan' => 'Sub-aspek kedisiplinan'
        ]);

        AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => $sikapSosial->id,
            'nama_aspek' => 'Tanggung Jawab',
            'deskripsi' => 'Kemampuan siswa dalam menunjukkan tanggung jawab',
            'tipe' => 'aspek',
            'urutan' => 3,
            'bobot' => 5.00,
            'status' => 'aktif',
            'catatan' => 'Sub-aspek tanggung jawab'
        ]);

        // Domain 3: Pengetahuan
        $pengetahuan = AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => null,
            'nama_aspek' => 'Pengetahuan',
            'deskripsi' => 'Aspek penilaian untuk pengetahuan siswa',
            'tipe' => 'domain',
            'urutan' => 3,
            'bobot' => 35.00,
            'status' => 'aktif',
            'catatan' => 'Domain utama untuk penilaian pengetahuan'
        ]);

        // Sub-aspek untuk Pengetahuan
        AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => $pengetahuan->id,
            'nama_aspek' => 'Pemahaman Konsep',
            'deskripsi' => 'Kemampuan siswa dalam memahami konsep materi',
            'tipe' => 'aspek',
            'urutan' => 1,
            'bobot' => 17.50,
            'status' => 'aktif',
            'catatan' => 'Sub-aspek pemahaman konsep'
        ]);

        AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => $pengetahuan->id,
            'nama_aspek' => 'Aplikasi Konsep',
            'deskripsi' => 'Kemampuan siswa dalam mengaplikasikan konsep',
            'tipe' => 'aspek',
            'urutan' => 2,
            'bobot' => 17.50,
            'status' => 'aktif',
            'catatan' => 'Sub-aspek aplikasi konsep'
        ]);

        // Domain 4: Keterampilan
        $keterampilan = AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => null,
            'nama_aspek' => 'Keterampilan',
            'deskripsi' => 'Aspek penilaian untuk keterampilan siswa',
            'tipe' => 'domain',
            'urutan' => 4,
            'bobot' => 35.00,
            'status' => 'aktif',
            'catatan' => 'Domain utama untuk penilaian keterampilan'
        ]);

        // Sub-aspek untuk Keterampilan
        AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => $keterampilan->id,
            'nama_aspek' => 'Keterampilan Praktik',
            'deskripsi' => 'Kemampuan siswa dalam praktik langsung',
            'tipe' => 'aspek',
            'urutan' => 1,
            'bobot' => 17.50,
            'status' => 'aktif',
            'catatan' => 'Sub-aspek keterampilan praktik'
        ]);

        AspekPenilaian::create([
            'template_kurikulum_id' => $templateId,
            'parent_id' => $keterampilan->id,
            'nama_aspek' => 'Keterampilan Produk',
            'deskripsi' => 'Kemampuan siswa dalam menghasilkan produk',
            'tipe' => 'aspek',
            'urutan' => 2,
            'bobot' => 17.50,
            'status' => 'aktif',
            'catatan' => 'Sub-aspek keterampilan produk'
        ]);
    }
}
