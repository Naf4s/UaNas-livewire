<?php

namespace App\Livewire\AttendanceManagement;

use App\Models\Absensi;
use App\Models\Rombel;
use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Title('Input Absensi')]
class InputAbsensi extends Component
{
    // Properties untuk filter
    public $selectedClass = '';
    public $selectedDate = '';
    public $selectedSemester = '';
    public $selectedTahunAjaran = '';

    // Properties untuk data absensi
    public $students = [];
    public $attendanceData = [];
    public $existingAttendance = [];

    // Properties untuk UI
    public $isLoading = false;
    public $showSuccessMessage = false;

    public function mount()
    {
        $this->selectedDate = date('Y-m-d');
        $this->selectedSemester = 'Ganjil';
        $this->selectedTahunAjaran = date('Y');
        
        // Load data awal
        $this->loadAvailableClasses();
    }

    public function loadAvailableClasses()
    {
        // Load rombel yang tersedia untuk guru
        $this->availableClasses = Rombel::where('status', 'aktif')
            ->with('kelas')
            ->orderBy('nama_rombel')
            ->get();
    }

    public function updatedSelectedClass()
    {
        $this->loadStudents();
        $this->loadExistingAttendance();
        $this->resetAttendanceData();
    }

    public function updatedSelectedDate()
    {
        $this->loadExistingAttendance();
        $this->resetAttendanceData();
    }

    public function updatedSelectedSemester()
    {
        $this->loadExistingAttendance();
        $this->resetAttendanceData();
    }

    public function updatedSelectedTahunAjaran()
    {
        $this->loadExistingAttendance();
        $this->resetAttendanceData();
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

    public function loadExistingAttendance()
    {
        if (!$this->selectedClass || !$this->selectedDate) return;

        $existingAttendance = Absensi::where([
            'rombel_id' => $this->selectedClass,
            'tanggal' => $this->selectedDate,
            'semester' => $this->selectedSemester,
            'tahun_ajaran' => $this->selectedTahunAjaran
        ])->get();

        $this->existingAttendance = $existingAttendance->keyBy('siswa_id');
    }

    public function resetAttendanceData()
    {
        $this->attendanceData = [];
        
        if ($this->students->count() > 0) {
            foreach ($this->students as $student) {
                $existing = $this->existingAttendance->get($student->id);
                
                $this->attendanceData[$student->id] = [
                    'status' => $existing ? $existing->status : 'hadir',
                    'jam_masuk' => $existing ? $existing->jam_masuk : '07:00',
                    'jam_keluar' => $existing ? $existing->jam_keluar : '12:00',
                    'keterangan' => $existing ? $existing->keterangan : '',
                    'attendance_id' => $existing ? $existing->id : null
                ];
            }
        }
    }

    public function save()
    {
        // Validasi input
        $this->validate([
            'selectedClass' => 'required|exists:rombel,id',
            'selectedDate' => 'required|date',
            'selectedSemester' => 'required|in:Ganjil,Genap',
            'selectedTahunAjaran' => 'required|integer|min:2020|max:2030',
        ]);

        if (empty($this->attendanceData)) {
            session()->flash('error', 'Tidak ada data absensi yang diinput');
            return;
        }

        $this->isLoading = true;

        try {
            DB::beginTransaction();

            $guruId = Auth::id();
            $savedCount = 0;
            $updatedCount = 0;

            foreach ($this->attendanceData as $siswaId => $attendanceData) {
                $data = array_merge($attendanceData, [
                    'rombel_id' => $this->selectedClass,
                    'siswa_id' => $siswaId,
                    'guru_id' => $guruId,
                    'tanggal' => $this->selectedDate,
                    'semester' => $this->selectedSemester,
                    'tahun_ajaran' => $this->selectedTahunAjaran
                ]);

                if (isset($data['attendance_id'])) {
                    // Update existing attendance
                    Absensi::where('id', $data['attendance_id'])->update($data);
                    $updatedCount++;
                } else {
                    // Create new attendance
                    Absensi::create($data);
                    $savedCount++;
                }
            }

            DB::commit();

            $totalCount = $savedCount + $updatedCount;
            if ($totalCount > 0) {
                session()->flash('message', "Berhasil menyimpan {$savedCount} absensi baru dan memperbarui {$updatedCount} absensi");
                $this->showSuccessMessage = true;
                
                // Refresh existing attendance
                $this->loadExistingAttendance();
                $this->resetAttendanceData();
            } else {
                session()->flash('error', 'Tidak ada absensi yang berhasil disimpan');
            }

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function quickSetStatus($status)
    {
        if (empty($this->attendanceData)) return;

        foreach ($this->attendanceData as $siswaId => $data) {
            $this->attendanceData[$siswaId]['status'] = $status;
        }

        session()->flash('message', "Status absensi semua siswa diubah menjadi: " . ucfirst($status));
    }

    public function render()
    {
        $availableClasses = Rombel::where('status', 'aktif')
            ->with('kelas')
            ->orderBy('nama_rombel')
            ->get();

        return view('livewire.attendance-management.input-absensi', [
            'availableClasses' => $availableClasses
        ]);
    }
}
