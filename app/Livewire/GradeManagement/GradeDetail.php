<?php

namespace App\Livewire\GradeManagement;

use App\Models\Grade;
use App\Models\TemplateKurikulum;
use App\Models\AspekPenilaian;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Penilaian')]
class GradeDetail extends Component
{
    public $gradeId;
    public $gradeData;
    public $activeCurriculum;
    public $aspekPenilaian = [];

    public function mount($gradeId)
    {
        $this->gradeId = $gradeId;
        $this->loadGradeData();
    }

    public function loadGradeData()
    {
        $this->gradeData = Grade::with([
            'siswa',
            'rombel.kelas',
            'mataPelajaran'
        ])->find($this->gradeId);

        if ($this->gradeData) {
            $this->loadCurriculumData();
            $this->loadAspekPenilaian();
        }
    }

    public function loadCurriculumData()
    {
        if ($this->gradeData->template_kurikulum_id) {
            $this->activeCurriculum = TemplateKurikulum::find($this->gradeData->template_kurikulum_id);
        }
    }

    public function loadAspekPenilaian()
    {
        if ($this->gradeData->template_kurikulum_id) {
            $this->aspekPenilaian = AspekPenilaian::where('template_kurikulum_id', $this->gradeData->template_kurikulum_id)
                ->where('status', 'aktif')
                ->with('parent')
                ->orderBy('urutan')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.grade-management.grade-detail');
    }
}
