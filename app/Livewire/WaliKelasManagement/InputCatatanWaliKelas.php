<?php

namespace App\Livewire\WaliKelasManagement;

use App\Models\CatatanWaliKelas;
use App\Models\Rombel;
use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Input Catatan Wali Kelas')]
class InputCatatanWaliKelas extends Component
{
    // Properties untuk filter
    public $selectedClass = '';
    public $selectedStudent = '';
    public $selectedSemester = '';
    public $selectedTahunAjaran = '';

    // Properties untuk form catatan
    public $jenisCatatan = 'akademik';
    public $catatan = '';
    public $kategori = 'netral';
    public $tanggalCatatan = '';

    // Properties untuk data
    public $students = [];
    public $existingNotes = [];
    public $availableClasses = [];

    // Properties untuk UI
    public $isLoading = false;
    public $showSuccessMessage = false;
    public $editingNote = null;
    public $isEditing = false;

    public function mount()
    {
        $this->tanggalCatatan = date('Y-m-d');
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
        $this->selectedStudent = '';
        $this->loadStudents();
        $this->loadExistingNotes();
    }

    public function updatedSelectedStudent()
    {
        $this->loadExistingNotes();
    }

    public function updatedSelectedSemester()
    {
        $this->loadExistingNotes();
    }

    public function updatedSelectedTahunAjaran()
    {
        $this->loadExistingNotes();
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

    public function loadExistingNotes()
    {
        if (!$this->selectedClass || !$this->selectedStudent) return;

        $this->existingNotes = CatatanWaliKelas::where([
            'rombel_id' => $this->selectedClass,
            'siswa_id' => $this->selectedStudent,
            'semester' => $this->selectedSemester,
            'tahun_ajaran' => $this->selectedTahunAjaran
        ])->orderBy('tanggal_catatan', 'desc')->get();
    }

    public function resetForm()
    {
        $this->jenisCatatan = 'akademik';
        $this->catatan = '';
        $this->kategori = 'netral';
        $this->tanggalCatatan = date('Y-m-d');
        $this->editingNote = null;
        $this->isEditing = false;
    }

    public function editNote($noteId)
    {
        $note = CatatanWaliKelas::findOrFail($noteId);
        
        $this->editingNote = $note;
        $this->isEditing = true;
        $this->jenisCatatan = $note->jenis_catatan;
        $this->catatan = $note->catatan;
        $this->kategori = $note->kategori;
        $this->tanggalCatatan = $note->tanggal_catatan->format('Y-m-d');
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
            'jenisCatatan' => 'required|in:akademik,non_akademik,perilaku,kehadiran,lainnya',
            'catatan' => 'required|string|min:10',
            'kategori' => 'required|in:positif,negatif,netral',
            'tanggalCatatan' => 'required|date',
            'selectedSemester' => 'required|in:Ganjil,Genap',
            'selectedTahunAjaran' => 'required|integer|min:2020|max:2030',
        ]);

        $this->isLoading = true;

        try {
            $waliKelasId = Auth::id();

            if ($this->isEditing && $this->editingNote) {
                // Update existing note
                $this->editingNote->update([
                    'jenis_catatan' => $this->jenisCatatan,
                    'catatan' => $this->catatan,
                    'kategori' => $this->kategori,
                    'tanggal_catatan' => $this->tanggalCatatan,
                ]);
                
                session()->flash('message', 'Catatan berhasil diperbarui');
            } else {
                // Create new note
                CatatanWaliKelas::create([
                    'rombel_id' => $this->selectedClass,
                    'siswa_id' => $this->selectedStudent,
                    'wali_kelas_id' => $waliKelasId,
                    'jenis_catatan' => $this->jenisCatatan,
                    'catatan' => $this->catatan,
                    'kategori' => $this->kategori,
                    'tanggal_catatan' => $this->tanggalCatatan,
                    'semester' => $this->selectedSemester,
                    'tahun_ajaran' => $this->selectedTahunAjaran,
                    'status' => 'draft'
                ]);
                
                session()->flash('message', 'Catatan berhasil ditambahkan');
            }

            // Refresh data dan reset form
            $this->loadExistingNotes();
            $this->resetForm();
            $this->showSuccessMessage = true;

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function publishNote($noteId)
    {
        try {
            $note = CatatanWaliKelas::findOrFail($noteId);
            $note->update(['status' => 'published']);
            
            session()->flash('message', 'Catatan berhasil dipublikasikan');
            $this->loadExistingNotes();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteNote($noteId)
    {
        try {
            $note = CatatanWaliKelas::findOrFail($noteId);
            $note->delete();
            
            session()->flash('message', 'Catatan berhasil dihapus');
            $this->loadExistingNotes();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.wali-kelas-management.input-catatan-wali-kelas');
    }
}
