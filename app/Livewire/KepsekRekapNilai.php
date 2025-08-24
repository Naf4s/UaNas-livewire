<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Grade;
use App\Models\MataPelajaran;
use App\Models\Rombel;

class KepsekRekapNilai extends Component
{
    public $kelasId = '';
    public $kelasList = [];
    public $siswaList = [];
    public $rekap = [];

    public function mount()
    {
        $this->kelasList = Kelas::orderBy('tingkat')->get();
        $this->kelasId = $this->kelasList->first()->id ?? '';
        $this->loadRekap();
    }

    public function updatedKelasId($value)
    {
        $this->loadRekap();
    }

    /**
     * Ambil rekap nilai seluruh siswa di kelas terpilih.
     */
    public function loadRekap()
    {
        if (!$this->kelasId) {
            $this->siswaList = [];
            $this->rekap = [];
            return;
        }

        // Get siswa through rombel relationship
        $this->siswaList = Siswa::whereHas('rombel', function($query) {
            $query->where('kelas_id', $this->kelasId);
        })->get();

        $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();
        $this->rekap = [];
        
        foreach ($this->siswaList as $siswa) {
            $nilai = [];
            foreach ($mataPelajaran as $mapel) {
                $grade = Grade::where('siswa_id', $siswa->id)
                    ->where('mata_pelajaran_id', $mapel->id)
                    ->first();
                $nilai[$mapel->id] = $grade ? $grade->nilai : '-';
            }
            $this->rekap[] = [
                'siswa' => $siswa,
                'nilai' => $nilai,
            ];
        }
        $this->mataPelajaran = $mataPelajaran;
    }

    public function render()
    {
        return view('livewire.kepsek-rekap-nilai', [
            'mataPelajaran' => $this->mataPelajaran ?? [],
        ]);
    }
}
