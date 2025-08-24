<?php

namespace App\Livewire\GradeManagement;

use App\Models\Grade;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Riwayat Penilaian')]
class GradeHistory extends Component
{
    use WithPagination;

    // Filter properties
    public $selectedKelas = '';
    public $selectedMapel = '';
    public $selectedSemester = '';
    public $selectedTahunAjaran = '';
    public $search = '';

    // Data properties
    public $kelasList = [];
    public $mapelList = [];
    public $tahunAjaranList = [];
    public $gradeHistory;
    public $stats = [];

    public function mount()
    {
        $this->loadFilterData();
        $this->loadGradeHistory();
        $this->loadStats();
    }

    public function loadFilterData()
    {
        // Load kelas list
        $this->kelasList = Kelas::where('status', 'aktif')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        // Load mata pelajaran list
        $this->mapelList = MataPelajaran::where('status', 'aktif')
            ->orderBy('nama_mapel')
            ->get();

        // Load tahun ajaran list (last 5 years)
        $currentYear = date('Y');
        $this->tahunAjaranList = range($currentYear - 2, $currentYear + 2);
    }

    public function loadGradeHistory()
    {
        $query = Grade::with(['siswa', 'rombel.kelas', 'mataPelajaran'])
            ->where('status', '!=', 'draft');

        // Apply filters
        if ($this->selectedKelas) {
            $query->whereHas('rombel', function ($q) {
                $q->where('kelas_id', $this->selectedKelas);
            });
        }

        if ($this->selectedMapel) {
            $query->where('mata_pelajaran_id', $this->selectedMapel);
        }

        if ($this->selectedSemester) {
            $query->where('semester', $this->selectedSemester);
        }

        if ($this->selectedTahunAjaran) {
            $query->where('tahun_ajaran', $this->selectedTahunAjaran);
        }

        if ($this->search) {
            $query->whereHas('siswa', function ($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                  ->orWhere('nis', 'like', '%' . $this->search . '%');
            });
        }

        $this->gradeHistory = $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function loadStats()
    {
        $this->stats = [
            'total_siswa' => Siswa::where('status_siswa', 'aktif')->count(),
            'lengkap' => Grade::where('status', 'published')->count(),
            'belum_lengkap' => Grade::where('status', 'draft')->count(),
            'belum_input' => 0, // This would need more complex logic based on curriculum structure
        ];
    }

    public function refreshData()
    {
        $this->loadGradeHistory();
        $this->loadStats();
    }

    public function deleteGrade($gradeId)
    {
        try {
            $grade = Grade::findOrFail($gradeId);
            $grade->delete();
            
            session()->flash('message', 'Nilai berhasil dihapus');
            $this->loadGradeHistory();
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus nilai: ' . $e->getMessage());
        }
    }

    public function updatedSelectedKelas()
    {
        $this->resetPage();
        $this->loadGradeHistory();
    }

    public function updatedSelectedMapel()
    {
        $this->resetPage();
        $this->loadGradeHistory();
    }

    public function updatedSelectedSemester()
    {
        $this->resetPage();
        $this->loadGradeHistory();
    }

    public function updatedSelectedTahunAjaran()
    {
        $this->resetPage();
        $this->loadGradeHistory();
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->loadGradeHistory();
    }

    public function render()
    {
        return view('livewire.grade-management.grade-history');
    }
}
