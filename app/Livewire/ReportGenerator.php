<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Grade;
use App\Models\Kelas;
use App\Models\MataPelajaran;

class ReportGenerator extends Component
{
    public $selectedSiswaId;
    public $siswaList = [];
    public $reportData = null;

    /**
     * Inisialisasi daftar siswa saat komponen dimount.
     */
    public function mount()
    {
        $this->siswaList = Siswa::orderBy('nama_lengkap')->get();
    }

    /**
     * Trigger generateReport setiap kali siswa dipilih.
     */
    public function updatedSelectedSiswaId($value)
    {
        $this->generateReport();
    }

    /**
     * Ambil dan proses data nilai siswa yang dipilih menjadi struktur siap tampil.
     */
    public function generateReport()
    {
        if (!$this->selectedSiswaId) {
            $this->reportData = null;
            return;
        }
        
        $siswa = Siswa::with(['rombel.kelas', 'grades.mataPelajaran'])->find($this->selectedSiswaId);
        if (!$siswa) {
            $this->reportData = null;
            return;
        }
        
        $grades = Grade::where('siswa_id', $siswa->id)
            ->with('mataPelajaran')
            ->get();
            
        $nilai = $grades->map(function($grade) {
            return [
                'mata_pelajaran' => $grade->mataPelajaran->nama_mapel ?? '-',
                'nilai' => $grade->nilai,
                'keterangan' => $grade->keterangan ?? '-',
            ];
        });
        
        $this->reportData = [
            'siswa' => $siswa,
            'kelas' => $siswa->kelas, // Using the accessor
            'rombels' => $siswa->rombel,
            'nilai' => $nilai,
        ];
    }

    /**
     * Render tampilan komponen.
     */
    public function render()
    {
        return view('livewire.report-generator');
    }
}
