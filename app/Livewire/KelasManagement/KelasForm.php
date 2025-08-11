<?php

namespace App\Livewire\KelasManagement;

use App\Models\Kelas;
use Livewire\Component;
use Livewire\Attributes\Rule;

class KelasForm extends Component
{
    public Kelas $kelas;
    public $isEditing = false;

    #[Rule('required|string|max:255')]
    public $nama_kelas = '';

    #[Rule('required|in:X,XI,XII')]
    public $tingkat = 'X';

    #[Rule('nullable|string|max:255')]
    public $jurusan = '';

    #[Rule('nullable|string')]
    public $deskripsi = '';

    #[Rule('required|in:aktif,nonaktif')]
    public $status = 'aktif';

    public function mount($kelasId = null)
    {
        if ($kelasId) {
            $this->kelas = Kelas::findOrFail($kelasId);
            $this->isEditing = true;
            $this->nama_kelas = $this->kelas->nama_kelas;
            $this->tingkat = $this->kelas->tingkat;
            $this->jurusan = $this->kelas->jurusan;
            $this->deskripsi = $this->kelas->deskripsi;
            $this->status = $this->kelas->status;
        } else {
            $this->kelas = new Kelas();
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $this->kelas->update([
                'nama_kelas' => $this->nama_kelas,
                'tingkat' => $this->tingkat,
                'jurusan' => $this->jurusan,
                'deskripsi' => $this->deskripsi,
                'status' => $this->status,
            ]);
        } else {
            Kelas::create([
                'nama_kelas' => $this->nama_kelas,
                'tingkat' => $this->tingkat,
                'jurusan' => $this->jurusan,
                'deskripsi' => $this->deskripsi,
                'status' => $this->status,
            ]);
        }

        session()->flash('message', 'Kelas berhasil ' . ($this->isEditing ? 'diperbarui' : 'ditambahkan'));
        return redirect()->route('kelas.index');
    }

    public function render()
    {
        return view('livewire.kelas-management.kelas-form');
    }
}
