<?php

namespace App\Livewire\MataPelajaranManagement;

use App\Models\MataPelajaran;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Manajemen Mata Pelajaran')]
class MataPelajaranTable extends Component
{
    use WithPagination;

    public $search = '';
    public $jenisFilter = '';
    public $kelompokFilter = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingJenisFilter()
    {
        $this->resetPage();
    }

    public function updatingKelompokFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function delete($mapelId)
    {
        $mapel = MataPelajaran::findOrFail($mapelId);
        
        // Cek apakah mata pelajaran masih digunakan di sistem lain
        // (bisa ditambahkan pengecekan relasi dengan tabel lain)
        
        $mapel->delete();
        session()->flash('message', 'Mata pelajaran berhasil dihapus');
    }

    public function toggleStatus($mapelId)
    {
        $mapel = MataPelajaran::findOrFail($mapelId);
        $newStatus = $mapel->status === 'aktif' ? 'nonaktif' : 'aktif';
        $mapel->update(['status' => $newStatus]);
        
        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('message', "Mata pelajaran {$mapel->nama_mapel} berhasil {$statusText}");
    }

    public function render()
    {
        $mataPelajaran = MataPelajaran::query()
            ->when($this->search, function ($query) {
                $query->where('nama_mapel', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_mapel', 'like', '%' . $this->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->when($this->jenisFilter, function ($query) {
                $query->where('jenis', $this->jenisFilter);
            })
            ->when($this->kelompokFilter, function ($query) {
                $query->where('kelompok', $this->kelompokFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('kelompok')
            ->orderBy('nama_mapel')
            ->paginate(15);

        return view('livewire.mata-pelajaran-management.mata-pelajaran-table', [
            'mataPelajaran' => $mataPelajaran
        ]);
    }
}
