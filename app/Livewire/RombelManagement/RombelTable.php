<?php

namespace App\Livewire\RombelManagement;

use App\Models\Rombel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Manajemen Rombongan Belajar')]
class RombelTable extends Component
{
    use WithPagination;

    public $search = '';
    public $kelasFilter = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKelasFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function delete($rombelId)
    {
        $rombel = Rombel::findOrFail($rombelId);
        
        // Cek apakah rombel masih memiliki siswa
        if ($rombel->jumlah_siswa > 0) {
            session()->flash('error', 'Rombongan belajar tidak dapat dihapus karena masih memiliki siswa');
            return;
        }
        
        $rombel->delete();
        session()->flash('message', 'Rombongan belajar berhasil dihapus');
    }

    public function render()
    {
        $rombel = Rombel::with(['kelas', 'waliKelas'])
            ->when($this->search, function ($query) {
                $query->where('nama_rombel', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_rombel', 'like', '%' . $this->search . '%');
            })
            ->when($this->kelasFilter, function ($query) {
                $query->where('kelas_id', $this->kelasFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('kelas_id')
            ->orderBy('nama_rombel')
            ->paginate(10);

        $kelas = \App\Models\Kelas::where('status', 'aktif')->orderBy('nama_kelas')->get();

        return view('livewire.rombel-management.rombel-table', [
            'rombel' => $rombel,
            'kelas' => $kelas
        ]);
    }
}
