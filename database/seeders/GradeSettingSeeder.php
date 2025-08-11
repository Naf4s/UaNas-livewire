<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GradeSetting;
use App\Models\TemplateKurikulum;
use App\Models\AspekPenilaian;
use App\Models\MataPelajaran;

class GradeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get active template
        $template = TemplateKurikulum::where('status', 'aktif')->first();
        if (!$template) return;

        // Get all active aspects
        $aspects = AspekPenilaian::where('template_kurikulum_id', $template->id)
            ->where('status', 'aktif')
            ->get();

        // Get all active subjects
        $subjects = MataPelajaran::where('status', 'aktif')->get();

        foreach ($aspects as $aspect) {
            foreach ($subjects as $subject) {
                // Determine input type based on aspect type
                $inputType = $this->getInputTypeForAspect($aspect->tipe);
                $options = $this->getOptionsForInputType($inputType);
                
                GradeSetting::create([
                    'template_kurikulum_id' => $template->id,
                    'aspek_penilaian_id' => $aspect->id,
                    'mata_pelajaran_id' => $subject->id,
                    'input_type' => $inputType,
                    'nilai_min' => $this->getMinValueForAspect($aspect->tipe),
                    'nilai_max' => $this->getMaxValueForAspect($aspect->tipe),
                    'nilai_lulus' => $this->getPassValueForAspect($aspect->tipe),
                    'options' => $options,
                    'satuan' => $this->getUnitForAspect($aspect->tipe),
                    'deskripsi_input' => $this->getDescriptionForAspect($aspect->tipe),
                    'wajib_diisi' => true,
                    'bisa_diubah' => true,
                    'status' => 'aktif'
                ]);
            }
        }
    }

    private function getInputTypeForAspect($tipe)
    {
        return match($tipe) {
            'domain' => 'select',
            'aspek' => 'number',
            'indikator' => 'number',
            default => 'number'
        };
    }

    private function getOptionsForInputType($inputType)
    {
        return match($inputType) {
            'select' => [
                'A' => 'Sangat Baik (A)',
                'B' => 'Baik (B)',
                'C' => 'Cukup (C)',
                'D' => 'Kurang (D)'
            ],
            'number' => null,
            'text' => null,
            default => null
        };
    }

    private function getMinValueForAspect($tipe)
    {
        return match($tipe) {
            'domain' => 0,
            'aspek' => 0,
            'indikator' => 0,
            default => 0
        };
    }

    private function getMaxValueForAspect($tipe)
    {
        return match($tipe) {
            'domain' => 100,
            'aspek' => 100,
            'indikator' => 100,
            default => 100
        };
    }

    private function getPassValueForAspect($tipe)
    {
        return match($tipe) {
            'domain' => 75,
            'aspek' => 75,
            'indikator' => 75,
            default => 75
        };
    }

    private function getUnitForAspect($tipe)
    {
        return match($tipe) {
            'domain' => 'Skala',
            'aspek' => 'Nilai',
            'indikator' => 'Nilai',
            default => 'Nilai'
        };
    }

    private function getDescriptionForAspect($tipe)
    {
        return match($tipe) {
            'domain' => 'Pilih skala penilaian untuk domain ini',
            'aspek' => 'Input nilai angka untuk aspek penilaian',
            'indikator' => 'Input nilai angka untuk indikator penilaian',
            default => 'Input nilai untuk penilaian'
        };
    }
}
