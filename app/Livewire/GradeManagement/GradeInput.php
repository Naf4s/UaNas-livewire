<?php

namespace App\Livewire\GradeManagement;

use App\Models\Grade;
use App\Models\GradeSetting;
use App\Models\TemplateKurikulum;
use App\Models\MataPelajaran;
use App\Models\Rombel;
use App\Models\AspekPenilaian;
use App\Models\Siswa;
use App\Models\Kelas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Title('Input Penilaian')]
class GradeInput extends Component
{
    // Properties untuk filter dropdown dengan wire:model.live
    public $selectedKelas = '';
    public $selectedRombel = '';
    public $selectedMapel = '';
    public $selectedSemester = '';
    public $selectedTahunAjaran = '';
    public $nilaiSiswa = [];

    // Properties untuk data yang diambil berdasarkan filter
    public $kelasList = [];
    public $rombelList = [];
    public $mapelList = [];
    public $tahunAjaranList = [];
    public $siswaList = [];
    public $aspekPenilaian = [];
    public $activeCurriculum;

    // Properties untuk UI
    public $isLoading = false;

    public function mount()
    {
        $this->selectedTahunAjaran = date('Y');
        $this->selectedSemester = 'Ganjil';
        
        // Load data awal
        $this->loadInitialData();
    }

    public function loadInitialData()
    {
        // Load kurikulum aktif
        $this->activeCurriculum = TemplateKurikulum::where('status', 'aktif')->first();
        
        // Load data filter
        $this->loadKelasList();
        $this->loadTahunAjaranList();
    }

    public function loadKelasList()
    {
        $this->kelasList = Kelas::where('status', 'aktif')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();
    }

    public function loadRombelList()
    {
        if (!$this->selectedKelas) {
            $this->rombelList = [];
            return;
        }

        $this->rombelList = Rombel::where('kelas_id', $this->selectedKelas)
            ->where('status', 'aktif')
            ->orderBy('nama_rombel')
            ->get();
    }

    public function loadMapelList()
    {
        $this->mapelList = MataPelajaran::where('status', 'aktif')
            ->orderBy('nama_mapel')
            ->get();
    }

    public function loadTahunAjaranList()
    {
        $currentYear = date('Y');
        $this->tahunAjaranList = range($currentYear - 2, $currentYear + 2);
    }

    public function loadSiswaList()
    {
        if (!$this->selectedRombel) {
            $this->siswaList = [];
            return;
        }

        $rombel = Rombel::find($this->selectedRombel);
        if ($rombel) {
            $this->siswaList = $rombel->siswaAktif()
                ->orderBy('nama_lengkap')
                ->get();
        }
    }

    public function loadAspekPenilaian()
    {
        if (!$this->activeCurriculum) {
            $this->aspekPenilaian = [];
            return;
        }

        $this->aspekPenilaian = AspekPenilaian::where('template_kurikulum_id', $this->activeCurriculum->id)
            ->where('status', 'aktif')
            ->orderBy('urutan')
            ->get();
    }

    // Methods yang dipanggil saat filter berubah (wire:model.live)
    public function updatedSelectedKelas()
    {
        $this->selectedRombel = '';
        $this->selectedMapel = '';
        $this->selectedSemester = '';
        $this->selectedTahunAjaran = '';
        $this->siswaList = [];
        $this->aspekPenilaian = [];
        $this->nilaiSiswa = [];
        
        $this->loadRombelList();
    }

    public function updatedSelectedRombel()
    {
        $this->selectedMapel = '';
        $this->selectedSemester = '';
        $this->selectedTahunAjaran = '';
        $this->siswaList = [];
        $this->aspekPenilaian = [];
        $this->nilaiSiswa = [];
        
        $this->loadSiswaList();
    }

    public function updatedSelectedMapel()
    {
        $this->selectedSemester = '';
        $this->selectedTahunAjaran = '';
        $this->aspekPenilaian = [];
        $this->nilaiSiswa = [];
        
        $this->loadAspekPenilaian();
    }

    public function updatedSelectedSemester()
    {
        $this->selectedTahunAjaran = '';
        $this->nilaiSiswa = [];
    }

    public function updatedSelectedTahunAjaran()
    {
        $this->nilaiSiswa = [];
    }

    public function refreshData()
    {
        $this->loadInitialData();
        $this->loadKelasList();
        $this->loadRombelList();
        $this->loadMapelList();
        $this->loadSiswaList();
        $this->loadAspekPenilaian();
    }

    public function hitungRataRata($siswaId)
    {
        if (!isset($this->nilaiSiswa[$siswaId])) {
            return 0;
        }

        $nilaiArray = array_filter($this->nilaiSiswa[$siswaId], function($nilai) {
            return is_numeric($nilai) && $nilai > 0;
        });

        if (empty($nilaiArray)) {
            return 0;
        }

        return array_sum($nilaiArray) / count($nilaiArray);
    }

    public function saveAllNilai()
    {
        if (!$this->selectedKelas || !$this->selectedRombel || !$this->selectedMapel || 
            !$this->selectedSemester || !$this->selectedTahunAjaran) {
            session()->flash('error', 'Pilih semua filter terlebih dahulu');
            return;
        }

        if (empty($this->nilaiSiswa)) {
            session()->flash('error', 'Tidak ada nilai yang diinput');
            return;
        }

        $this->isLoading = true;

        try {
            DB::beginTransaction();

            $guruId = Auth::id();
            $savedCount = 0;
            $updatedCount = 0;

            foreach ($this->nilaiSiswa as $siswaId => $aspekNilai) {
                foreach ($aspekNilai as $aspekId => $nilai) {
                    if (empty($nilai) || !is_numeric($nilai)) {
                        continue;
                    }

                    // Check if grade already exists
                    $existingGrade = Grade::where([
                        'siswa_id' => $siswaId,
                        'aspek_penilaian_id' => $aspekId,
                        'mata_pelajaran_id' => $this->selectedMapel,
                        'rombel_id' => $this->selectedRombel,
                        'semester' => $this->selectedSemester,
                        'tahun_ajaran' => $this->selectedTahunAjaran,
                    ])->first();

                    $gradeData = [
                        'siswa_id' => $siswaId,
                        'aspek_penilaian_id' => $aspekId,
                        'mata_pelajaran_id' => $this->selectedMapel,
                        'rombel_id' => $this->selectedRombel,
                        'semester' => $this->selectedSemester,
                        'tahun_ajaran' => $this->selectedTahunAjaran,
                        'guru_id' => $guruId,
                        'nilai' => $nilai,
                        'status' => 'published',
                    ];

                    if ($existingGrade) {
                        $existingGrade->update($gradeData);
                        $updatedCount++;
                    } else {
                        Grade::create($gradeData);
                        $savedCount++;
                    }
                }
            }

            DB::commit();

            $totalCount = $savedCount + $updatedCount;
            if ($totalCount > 0) {
                session()->flash('message', "Berhasil menyimpan {$savedCount} nilai baru dan memperbarui {$updatedCount} nilai");
            } else {
                session()->flash('error', 'Tidak ada nilai yang berhasil disimpan');
            }

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function exportNilai()
    {
        // Implementation for Excel export
        session()->flash('message', 'Fitur export akan segera tersedia');
    }

    public function generateRapor()
    {
        // Implementation for report generation
        session()->flash('message', 'Fitur generate rapor akan segera tersedia');
    }

    public function resetForm()
    {
        $this->nilaiSiswa = [];
        session()->flash('message', 'Form telah direset');
    }

    public function render()
    {
        return view('livewire.grade-management.grade-input');
    }
}
