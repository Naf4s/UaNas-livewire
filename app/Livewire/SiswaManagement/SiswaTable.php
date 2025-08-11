<?php

namespace App\Livewire\SiswaManagement;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Manajemen Siswa')]
class SiswaTable extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $jenisKelaminFilter = '';
    public $agamaFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingJenisKelaminFilter()
    {
        $this->resetPage();
    }

    public function updatingAgamaFilter()
    {
        $this->resetPage();
    }

    public function delete($siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        
        // Cek apakah siswa masih aktif di rombel
        if ($siswa->rombelAktif()->count() > 0) {
            session()->flash('error', 'Siswa tidak dapat dihapus karena masih aktif di rombongan belajar');
            return;
        }
        
        // Hapus user terkait
        if ($siswa->user) {
            $siswa->user->delete();
        }
        
        $siswa->delete();
        session()->flash('message', 'Siswa berhasil dihapus');
    }

    public function render()
    {
        $siswa = Siswa::with(['user', 'rombelAktif.rombel.kelas'])
            ->when($this->search, function ($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('nis', 'like', '%' . $this->search . '%')
                    ->orWhere('nisn', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status_siswa', $this->statusFilter);
            })
            ->when($this->jenisKelaminFilter, function ($query) {
                $query->where('jenis_kelamin', $this->jenisKelaminFilter);
            })
            ->when($this->agamaFilter, function ($query) {
                $query->where('agama', $this->agamaFilter);
            })
            ->orderBy('nama_lengkap')
            ->paginate(15);

        return view('livewire.siswa-management.siswa-table', [
            'siswa' => $siswa
        ]);
    }
}
