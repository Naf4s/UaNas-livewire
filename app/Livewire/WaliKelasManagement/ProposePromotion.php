<?php

namespace App\Livewire\WaliKelasManagement;

use App\Models\UsulanKenaikanKelas;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\Grade;
use App\Models\Absensi;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Title('Usulan Kenaikan Kelas')]
class ProposePromotion extends Component
{
    // Properties untuk filter
    public $selectedClass = '';
    public $selectedSemester = '';
    public $selectedTahunAjaran = '';

    // Properties untuk data
    public $students = [];
    public $existingProposals = [];
    public $availableClasses = [];
    public $studentStats = [];

    // Properties untuk form usulan
    public $selectedStudent = '';
    public $statusUsulan = 'naik_kelas';
    public $alasanUsulan = '';
    public $rekomendasi = '';

    // Properties untuk UI
    public $isLoading = false;
    public $showSuccessMessage = false;
    public $editingProposal = null;
    public $isEditing = false;
    public $showStudentDetail = false;

    public function mount()
    {
        $this->selectedSemester = 'Ganjil';
        $this->selectedTahunAjaran = date('Y');
        
        // Load data awal
        $this->loadAvailableClasses();
    }

    public function loadAvailableClasses()
    {
        // Load rombel yang tersedia untuk wali kelas
        $this->availableClasses = Rombel::where('status', 'aktif')
            ->with('kelas')
            ->orderBy('nama_rombel')
            ->get();
    }

    public function updatedSelectedClass()
    {
        $this->loadStudents();
        $this->loadExistingProposals();
        $this->loadStudentStats();
    }

    public function updatedSelectedSemester()
    {
        $this->loadExistingProposals();
        $this->loadStudentStats();
    }

    public function updatedSelectedTahunAjaran()
    {
        $this->loadExistingProposals();
        $this->loadStudentStats();
    }

    public function loadStudents()
    {
        if (!$this->selectedClass) return;

        $rombel = Rombel::find($this->selectedClass);
        if ($rombel) {
            $this->students = $rombel->siswaAktif()
                ->orderBy('nama_lengkap')
                ->get();
        }
    }

    public function loadExistingProposals()
    {
        if (!$this->selectedClass) return;

        $this->existingProposals = UsulanKenaikanKelas::where([
            'rombel_id' => $this->selectedClass,
            'semester' => $this->selectedSemester,
            'tahun_ajaran' => $this->selectedTahunAjaran
        ])->with(['siswa'])->orderBy('tanggal_usulan', 'desc')->get();
    }

    public function loadStudentStats()
    {
        if (!$this->selectedClass) return;

        $this->studentStats = [];

        foreach ($this->students as $student) {
            // Hitung rata-rata nilai
            $averageGrade = Grade::where([
                'siswa_id' => $student->id,
                'rombel_id' => $this->selectedClass,
                'semester' => $this->selectedSemester,
                'tahun_ajaran' => $this->selectedTahunAjaran,
                'status' => 'published'
            ])->avg('nilai_angka') ?? 0;

            // Hitung kehadiran
            $totalDays = Absensi::where([
                'rombel_id' => $this->selectedClass,
                'semester' => $this->selectedSemester,
                'tahun_ajaran' => $this->selectedTahunAjaran
            ])->distinct('tanggal')->count();

            $attendedDays = Absensi::where([
                'rombel_id' => $this->selectedClass,
                'siswa_id' => $student->id,
                'semester' => $this->selectedSemester,
                'tahun_ajaran' => $this->selectedTahunAjaran,
                'status' => 'hadir'
            ])->count();

            $attendancePercentage = $totalDays > 0 ? ($attendedDays / $totalDays) * 100 : 0;

            $this->studentStats[$student->id] = [
                'average_grade' => round($averageGrade, 2),
                'attendance_percentage' => round($attendancePercentage, 1),
                'total_days' => $totalDays,
                'attended_days' => $attendedDays
            ];
        }
    }

    public function resetForm()
    {
        $this->selectedStudent = '';
        $this->statusUsulan = 'naik_kelas';
        $this->alasanUsulan = '';
        $this->rekomendasi = '';
        $this->editingProposal = null;
        $this->isEditing = false;
    }

    public function editProposal($proposalId)
    {
        $proposal = UsulanKenaikanKelas::findOrFail($proposalId);
        
        $this->editingProposal = $proposal;
        $this->isEditing = true;
        $this->selectedStudent = $proposal->siswa_id;
        $this->statusUsulan = $proposal->status_usulan;
        $this->alasanUsulan = $proposal->alasan_usulan;
        $this->rekomendasi = $proposal->rekomendasi ?? '';
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function save()
    {
        // Validasi input
        $this->validate([
            'selectedClass' => 'required|exists:rombel,id',
            'selectedStudent' => 'required|exists:siswa,id',
            'statusUsulan' => 'required|in:naik_kelas,tinggal_di_kelas,lulus,tidak_lulus',
            'alasanUsulan' => 'required|string|min:20',
            'rekomendasi' => 'nullable|string|min:10',
            'selectedSemester' => 'required|in:Ganjil,Genap',
            'selectedTahunAjaran' => 'required|integer|min:2020|max:2030',
        ]);

        $this->isLoading = true;

        try {
            $waliKelasId = Auth::id();

            if ($this->isEditing && $this->editingProposal) {
                // Update existing proposal
                $this->editingProposal->update([
                    'status_usulan' => $this->statusUsulan,
                    'alasan_usulan' => $this->alasanUsulan,
                    'rekomendasi' => $this->rekomendasi,
                ]);
                
                session()->flash('message', 'Usulan kenaikan kelas berhasil diperbarui');
            } else {
                // Create new proposal
                UsulanKenaikanKelas::create([
                    'rombel_id' => $this->selectedClass,
                    'siswa_id' => $this->selectedStudent,
                    'wali_kelas_id' => $waliKelasId,
                    'status_usulan' => $this->statusUsulan,
                    'alasan_usulan' => $this->alasanUsulan,
                    'rekomendasi' => $this->rekomendasi,
                    'semester' => $this->selectedSemester,
                    'tahun_ajaran' => $this->selectedTahunAjaran,
                    'tanggal_usulan' => now(),
                    'status_approval' => 'pending',
                    'status_final' => 'draft'
                ]);
                
                session()->flash('message', 'Usulan kenaikan kelas berhasil ditambahkan');
            }

            // Refresh data dan reset form
            $this->loadExistingProposals();
            $this->resetForm();
            $this->showSuccessMessage = true;

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function submitProposal($proposalId)
    {
        try {
            $proposal = UsulanKenaikanKelas::findOrFail($proposalId);
            $proposal->update(['status_final' => 'submitted']);
            
            session()->flash('message', 'Usulan berhasil dikirim untuk approval');
            $this->loadExistingProposals();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteProposal($proposalId)
    {
        try {
            $proposal = UsulanKenaikanKelas::findOrFail($proposalId);
            $proposal->delete();
            
            session()->flash('message', 'Usulan berhasil dihapus');
            $this->loadExistingProposals();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getRecommendationText($studentId)
    {
        if (!isset($this->studentStats[$studentId])) return '';

        $stats = $this->studentStats[$studentId];
        $recommendations = [];

        if ($stats['average_grade'] >= 85) {
            $recommendations[] = 'Nilai akademik sangat baik';
        } elseif ($stats['average_grade'] >= 75) {
            $recommendations[] = 'Nilai akademik baik';
        } elseif ($stats['average_grade'] >= 65) {
            $recommendations[] = 'Nilai akademik cukup';
        } else {
            $recommendations[] = 'Nilai akademik perlu ditingkatkan';
        }

        if ($stats['attendance_percentage'] >= 90) {
            $recommendations[] = 'Kehadiran sangat baik';
        } elseif ($stats['attendance_percentage'] >= 80) {
            $recommendations[] = 'Kehadiran baik';
        } else {
            $recommendations[] = 'Kehadiran perlu ditingkatkan';
        }

        return implode(', ', $recommendations);
    }

    public function render()
    {
        return view('livewire.wali-kelas-management.propose-promotion');
    }
}
