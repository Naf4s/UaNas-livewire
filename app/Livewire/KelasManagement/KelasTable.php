<?php

namespace App\Livewire\KelasManagement;

use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Manajemen Kelas')]
class KelasTable extends Component
{
    use WithPagination;

    public $search = '';
    public $tingkatFilter = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTingkatFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function delete($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        
        // Cek apakah kelas memiliki rombel
        if ($kelas->rombel()->count() > 0) {
            session()->flash('error', 'Kelas tidak dapat dihapus karena masih memiliki rombongan belajar');
            return;
        }
        
        $kelas->delete();
        session()->flash('message', 'Kelas berhasil dihapus');
    }

    public function render()
    {
        $kelas = Kelas::query()
            ->when($this->search, function ($query) {
                $query->where('nama_kelas', 'like', '%' . $this->search . '%')
                    ->orWhere('jurusan', 'like', '%' . $this->search . '%');
            })
            ->when($this->tingkatFilter, function ($query) {
                $query->where('tingkat', $this->tingkatFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->paginate(10);

        return view('livewire.kelas-management.kelas-table', [
            'kelas' => $kelas
        ]);
    }
}
