<?php

namespace App\Livewire\RombelManagement;

use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;

class RombelForm extends Component
{
    public Rombel $rombel;
    public $isEditing = false;

    #[Rule('required|exists:kelas,id')]
    public $kelas_id = '';

    #[Rule('required|string|max:255')]
    public $nama_rombel = '';

    #[Rule('required|string|max:255')]
    public $kode_rombel = '';

    #[Rule('required|integer|min:1|max:100')]
    public $kapasitas = 40;

    #[Rule('nullable|exists:users,id')]
    public $wali_kelas_id = '';

    #[Rule('nullable|string')]
    public $deskripsi = '';

    #[Rule('required|in:aktif,nonaktif')]
    public $status = 'aktif';

    public function mount($rombelId = null)
    {
        if ($rombelId) {
            $this->rombel = Rombel::findOrFail($rombelId);
            $this->isEditing = true;
            $this->kelas_id = $this->rombel->kelas_id;
            $this->nama_rombel = $this->rombel->nama_rombel;
            $this->kode_rombel = $this->rombel->kode_rombel;
            $this->kapasitas = $this->rombel->kapasitas;
            $this->wali_kelas_id = $this->rombel->wali_kelas_id;
            $this->deskripsi = $this->rombel->deskripsi;
            $this->status = $this->rombel->status;
        } else {
            $this->rombel = new Rombel();
        }
    }

    public function updatedKodeRombel()
    {
        // Reset validation error for kode_rombel when user types
        $this->resetValidation('kode_rombel');
    }

    public function save()
    {
        // Custom validation for kode_rombel uniqueness
        $kodeRule = 'required|string|max:255|unique:rombel,kode_rombel';
        if ($this->isEditing) {
            $kodeRule .= ',' . $this->rombel->id;
        }

        $this->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama_rombel' => 'required|string|max:255',
            'kode_rombel' => $kodeRule,
            'kapasitas' => 'required|integer|min:1|max:100',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        try {
            if ($this->isEditing) {
                $this->rombel->update([
                    'kelas_id' => $this->kelas_id,
                    'nama_rombel' => $this->nama_rombel,
                    'kode_rombel' => $this->kode_rombel,
                    'kapasitas' => $this->kapasitas,
                    'wali_kelas_id' => $this->wali_kelas_id,
                    'deskripsi' => $this->deskripsi,
                    'status' => $this->status,
                ]);
            } else {
                Rombel::create([
                    'kelas_id' => $this->kelas_id,
                    'nama_rombel' => $this->nama_rombel,
                    'kode_rombel' => $this->kode_rombel,
                    'kapasitas' => $this->kapasitas,
                    'wali_kelas_id' => $this->wali_kelas_id,
                    'deskripsi' => $this->deskripsi,
                    'status' => $this->status,
                    'jumlah_siswa' => 0,
                ]);
            }

            session()->flash('message', 'Rombongan belajar berhasil ' . ($this->isEditing ? 'diperbarui' : 'ditambahkan'));
            return redirect()->route('rombel.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $kelas = Kelas::where('status', 'aktif')->orderBy('nama_kelas')->get();
        $guru = User::whereIn('role', ['guru', 'kepala'])->where('status', 'active')->orderBy('name')->get();

        return view('livewire.rombel-management.rombel-form', [
            'kelas' => $kelas,
            'guru' => $guru
        ]);
    }
}
