<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UsulanKenaikanKelas;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class AdminValidasiKenaikan extends Component
{
    public $usulanList = [];

    public function mount()
    {
        $this->loadUsulan();
    }

    public function loadUsulan()
    {
        $this->usulanList = UsulanKenaikanKelas::with(['siswa', 'kelas_asal', 'kelas_tujuan'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function validasi($usulanId)
    {
        DB::transaction(function () use ($usulanId) {
            $usulan = UsulanKenaikanKelas::findOrFail($usulanId);
            $siswa = Siswa::findOrFail($usulan->siswa_id);
            $siswa->kelas_id = $usulan->kelas_tujuan_id;
            $siswa->save();
            $usulan->status = 'disetujui';
            $usulan->save();
        });
        $this->loadUsulan();
        session()->flash('success', 'Usulan kenaikan kelas telah divalidasi.');
    }

    public function tolak($usulanId)
    {
        $usulan = UsulanKenaikanKelas::findOrFail($usulanId);
        $usulan->status = 'ditolak';
        $usulan->save();
        $this->loadUsulan();
        session()->flash('success', 'Usulan kenaikan kelas telah ditolak.');
    }

    public function render()
    {
        return view('livewire.admin-validasi-kenaikan');
    }
}
