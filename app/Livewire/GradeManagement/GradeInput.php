<?php

namespace App\Livewire\GradeManagement;

use App\Models\Grade;
use App\Models\GradeSetting;
use App\Models\TemplateKurikulum;
use App\Models\MataPelajaran;
use App\Models\Rombel;
use App\Models\AspekPenilaian;
use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Title('Input Penilaian')]
class GradeInput extends Component
{
    // Properties untuk filter dropdown dengan wire:model.live
    public $selectedClass = '';
    public $selectedSubject = '';
    public $selectedAspect = '';
    public $selectedTemplate = '';
    public $selectedSemester = '';
    public $selectedTahunAjaran = '';
    public $selectedJenisPenilaian = 'Harian';
    public $tanggalPenilaian = '';

    // Property array untuk menampung semua nilai yang diinput
    public $grades = [];

    // Properties untuk data yang diambil berdasarkan filter
    public $availableClasses = [];
    public $availableSubjects = [];
    public $availableAspects = [];
    public $availableTemplates = [];
    public $students = [];
    public $currentGradeSettings = null;

    // Properties untuk UI
    public $isLoading = false;
    public $showSuccessMessage = false;

    public function mount()
    {
        $this->tanggalPenilaian = date('Y-m-d');
        $this->selectedTahunAjaran = date('Y');
        $this->selectedSemester = 'Ganjil';
        
        // Load data awal
        $this->loadInitialData();
    }

    public function loadInitialData()
    {
        // Load template kurikulum yang aktif
        $this->availableTemplates = TemplateKurikulum::where('status', 'aktif')->get();
        
        if ($this->availableTemplates->count() > 0) {
            $this->selectedTemplate = $this->availableTemplates->first()->id;
        }

        // Load rombel yang tersedia untuk guru
        $this->loadAvailableClasses();
    }

    // Methods yang dipanggil saat filter berubah (wire:model.live)
    public function updatedSelectedTemplate()
    {
        $this->selectedClass = '';
        $this->selectedSubject = '';
        $this->selectedAspect = '';
        $this->loadAvailableClasses();
        $this->loadAvailableSubjects();
        $this->loadAvailableAspects();
        $this->loadStudents();
        $this->resetGrades();
    }

    public function updatedSelectedClass()
    {
        $this->selectedSubject = '';
        $this->selectedAspect = '';
        $this->loadAvailableSubjects();
        $this->loadAvailableAspects();
        $this->loadStudents();
        $this->resetGrades();
    }

    public function updatedSelectedSubject()
    {
        $this->selectedAspect = '';
        $this->loadAvailableAspects();
        $this->loadStudents();
        $this->resetGrades();
    }

    public function updatedSelectedAspect()
    {
        $this->loadStudents();
        $this->loadGradeSettings();
        $this->loadExistingGrades();
        $this->resetGrades();
    }

    public function updatedSelectedSemester()
    {
        $this->loadExistingGrades();
        $this->resetGrades();
    }

    public function updatedSelectedTahunAjaran()
    {
        $this->loadExistingGrades();
        $this->resetGrades();
    }

    public function updatedSelectedJenisPenilaian()
    {
        $this->loadExistingGrades();
        $this->resetGrades();
    }

    // Load data berdasarkan filter
    public function loadAvailableClasses()
    {
        if (!$this->selectedTemplate) return;

        // Load rombel yang tersedia (bisa ditambahkan filter berdasarkan guru)
        $this->availableClasses = Rombel::where('status', 'aktif')
            ->with('kelas')
            ->orderBy('nama_rombel')
            ->get();
    }

    public function loadAvailableSubjects()
    {
        if (!$this->selectedTemplate || !$this->selectedClass) return;

        // Load mata pelajaran yang tersedia
        $this->availableSubjects = MataPelajaran::where('status', 'aktif')
            ->orderBy('nama_mapel')
            ->get();
    }

    public function loadAvailableAspects()
    {
        if (!$this->selectedTemplate || !$this->selectedClass || !$this->selectedSubject) return;

        // Load aspek penilaian berdasarkan template dan mata pelajaran
        $this->availableAspects = AspekPenilaian::where('template_kurikulum_id', $this->selectedTemplate)
            ->where('status', 'aktif')
            ->orderBy('urutan')
            ->get();
    }

    public function loadStudents()
    {
        if (!$this->selectedClass) return;

        // Load siswa yang ada di rombel tersebut
        $rombel = Rombel::find($this->selectedClass);
        if ($rombel) {
            $this->students = $rombel->siswaAktif()
                ->orderBy('nama_lengkap')
                ->get();
        }
    }

    public function loadGradeSettings()
    {
        if (!$this->selectedTemplate || !$this->selectedSubject || !$this->selectedAspect) return;

        // Load pengaturan input untuk aspek penilaian ini
        $this->currentGradeSettings = GradeSetting::where([
            'template_kurikulum_id' => $this->selectedTemplate,
            'aspek_penilaian_id' => $this->selectedAspect,
            'mata_pelajaran_id' => $this->selectedSubject,
            'status' => 'aktif'
        ])->first();

        // Jika tidak ada pengaturan, buat default
        if (!$this->currentGradeSettings) {
            $this->currentGradeSettings = new GradeSetting([
                'input_type' => 'number',
                'nilai_min' => 0,
                'nilai_max' => 100,
                'nilai_lulus' => 75,
                'satuan' => 'Nilai',
                'wajib_diisi' => true,
                'bisa_diubah' => true
            ]);
        }
    }

    public function loadExistingGrades()
    {
        if (!$this->selectedTemplate || !$this->selectedSubject || !$this->selectedAspect || !$this->selectedClass) return;

        // Load nilai yang sudah ada
        $existingGrades = Grade::where([
            'template_kurikulum_id' => $this->selectedTemplate,
            'aspek_penilaian_id' => $this->selectedAspect,
            'mata_pelajaran_id' => $this->selectedSubject,
            'rombel_id' => $this->selectedClass,
            'tahun_ajaran' => $this->selectedTahunAjaran,
            'semester' => $this->selectedSemester,
            'jenis_penilaian' => $this->selectedJenisPenilaian
        ])->get();

        // Populate grades array dengan nilai yang sudah ada
        foreach ($existingGrades as $grade) {
            $this->grades[$grade->siswa_id] = [
                'nilai_angka' => $grade->nilai_angka,
                'nilai' => $grade->nilai,
                'catatan' => $grade->catatan,
                'grade_id' => $grade->id
            ];
        }
    }

    public function resetGrades()
    {
        $this->grades = [];
        $this->loadExistingGrades();
    }

    // Method untuk menyimpan nilai
    public function save()
    {
        // Validasi input
        $this->validate([
            'selectedTemplate' => 'required|exists:template_kurikulum,id',
            'selectedClass' => 'required|exists:rombel,id',
            'selectedSubject' => 'required|exists:mata_pelajaran,id',
            'selectedAspect' => 'required|exists:aspek_penilaian,id',
            'selectedSemester' => 'required|in:Ganjil,Genap',
            'selectedTahunAjaran' => 'required|integer|min:2020|max:2030',
            'selectedJenisPenilaian' => 'required|in:Harian,Tugas,UTS,UAS,Praktik,Proyek,Portofolio',
            'tanggalPenilaian' => 'required|date',
        ]);

        if (empty($this->grades)) {
            session()->flash('error', 'Tidak ada nilai yang diinput');
            return;
        }

        $this->isLoading = true;

        try {
            DB::beginTransaction();

            $guruId = Auth::id();
            $savedCount = 0;
            $updatedCount = 0;

            foreach ($this->grades as $siswaId => $gradeData) {
                // Skip jika tidak ada nilai yang diinput
                if (empty($gradeData['nilai_angka']) && empty($gradeData['nilai'])) {
                    continue;
                }

                $gradeData = array_merge($gradeData, [
                    'template_kurikulum_id' => $this->selectedTemplate,
                    'aspek_penilaian_id' => $this->selectedAspect,
                    'mata_pelajaran_id' => $this->selectedSubject,
                    'rombel_id' => $this->selectedClass,
                    'siswa_id' => $siswaId,
                    'guru_id' => $guruId,
                    'tahun_ajaran' => $this->selectedTahunAjaran,
                    'semester' => $this->selectedSemester,
                    'jenis_penilaian' => $this->selectedJenisPenilaian,
                    'tanggal_penilaian' => $this->tanggalPenilaian,
                    'status' => 'draft'
                ]);

                if (isset($gradeData['grade_id'])) {
                    // Update existing grade
                    Grade::where('id', $gradeData['grade_id'])->update($gradeData);
                    $updatedCount++;
                } else {
                    // Create new grade
                    Grade::create($gradeData);
                    $savedCount++;
                }
            }

            DB::commit();

            $totalCount = $savedCount + $updatedCount;
            if ($totalCount > 0) {
                session()->flash('message', "Berhasil menyimpan {$savedCount} nilai baru dan memperbarui {$updatedCount} nilai");
                $this->showSuccessMessage = true;
                
                // Refresh existing grades
                $this->loadExistingGrades();
            } else {
                session()->flash('error', 'Tidak ada nilai yang berhasil disimpan');
            }

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function publishGrades()
    {
        if (!$this->selectedTemplate || !$this->selectedSubject || !$this->selectedAspect || !$this->selectedClass) {
            session()->flash('error', 'Pilih semua filter terlebih dahulu');
            return;
        }

        try {
            $updatedCount = Grade::where([
                'template_kurikulum_id' => $this->selectedTemplate,
                'aspek_penilaian_id' => $this->selectedAspect,
                'mata_pelajaran_id' => $this->selectedSubject,
                'rombel_id' => $this->selectedClass,
                'tahun_ajaran' => $this->selectedTahunAjaran,
                'semester' => $this->selectedSemester,
                'jenis_penilaian' => $this->selectedJenisPenilaian,
                'status' => 'draft'
            ])->update(['status' => 'published']);

            if ($updatedCount > 0) {
                session()->flash('message', "Berhasil mempublikasikan {$updatedCount} nilai");
                $this->loadExistingGrades();
            } else {
                session()->flash('error', 'Tidak ada nilai draft yang dapat dipublikasikan');
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.grade-management.grade-input');
    }
}
