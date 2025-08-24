<?php

namespace App\Livewire\MataPelajaranManagement;

use App\Models\MataPelajaran;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Manajemen Mata Pelajaran')]
#[Layout('components.layouts.app')]
class MataPelajaranTable extends Component
{
    use WithPagination;

    public $search = '';
    public $jenisFilter = '';
    public $kelompokFilter = '';
    public $statusFilter = '';
    public $perPage = 15;

    protected $queryString = [
        'search' => ['except' => ''],
        'jenisFilter' => ['except' => ''],
        'kelompokFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'perPage' => ['except' => 15],
    ];

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

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'jenisFilter', 'kelompokFilter', 'statusFilter']);
        $this->resetPage();
    }

    public function delete($mapelId)
    {
        try {
            $mapel = MataPelajaran::findOrFail($mapelId);
            
            // Cek apakah mata pelajaran masih digunakan di sistem lain
            if (!$mapel->canBeDeleted()) {
                $usageCount = $mapel->total_usage;
                session()->flash('error', "Mata pelajaran tidak dapat dihapus karena masih digunakan di {$usageCount} tempat. Silakan nonaktifkan terlebih dahulu.");
                return;
            }
            
            $mapel->delete();
            session()->flash('success', 'Mata pelajaran berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus mata pelajaran: ' . $e->getMessage());
        }
    }

    public function toggleStatus($mapelId)
    {
        try {
            $mapel = MataPelajaran::findOrFail($mapelId);
            $newStatus = $mapel->status === 'aktif' ? 'nonaktif' : 'aktif';
            $mapel->update(['status' => $newStatus]);
            
            $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
            session()->flash('success', "Mata pelajaran {$mapel->nama_mapel} berhasil {$statusText}");
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $mataPelajaran = MataPelajaran::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_mapel', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_mapel', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                });
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
            ->paginate($this->perPage);

        $jenisOptions = [
            'Wajib' => 'Mata Pelajaran Wajib',
            'Peminatan' => 'Mata Pelajaran Peminatan',
            'Lintas Minat' => 'Mata Pelajaran Lintas Minat',
            'Muatan Lokal' => 'Mata Pelajaran Muatan Lokal'
        ];

        $kelompokOptions = [
            'A' => 'Kelompok A (Wajib)',
            'B' => 'Kelompok B (Wajib)',
            'C' => 'Kelompok C (Peminatan)'
        ];

        $statusOptions = [
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif'
        ];

        return view('livewire.mata-pelajaran-management.mata-pelajaran-table', [
            'mataPelajaran' => $mataPelajaran,
            'jenisOptions' => $jenisOptions,
            'kelompokOptions' => $kelompokOptions,
            'statusOptions' => $statusOptions,
        ]);
    }
}
