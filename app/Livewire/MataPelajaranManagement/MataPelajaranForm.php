<?php

namespace App\Livewire\MataPelajaranManagement;

use App\Models\MataPelajaran;
use Livewire\Component;
use Livewire\Attributes\Rule;

class MataPelajaranForm extends Component
{
    public MataPelajaran $mataPelajaran;
    public $isEditing = false;

    #[Rule('required|string|max:10|unique:mata_pelajaran,kode_mapel')]
    public $kode_mapel = '';

    #[Rule('required|string|max:255')]
    public $nama_mapel = '';

    #[Rule('nullable|string')]
    public $deskripsi = '';

    #[Rule('required|in:Wajib,Peminatan,Lintas Minat,Muatan Lokal')]
    public $jenis = 'Wajib';

    #[Rule('required|integer|min:1|max:10')]
    public $jumlah_jam = 2;

    #[Rule('required|in:A,B,C')]
    public $kelompok = 'A';

    #[Rule('required|in:aktif,nonaktif')]
    public $status = 'aktif';

    #[Rule('nullable|string')]
    public $catatan = '';

    public function mount($mataPelajaranId = null)
    {
        if ($mataPelajaranId) {
            $this->mataPelajaran = MataPelajaran::findOrFail($mataPelajaranId);
            $this->isEditing = true;
            $this->kode_mapel = $this->mataPelajaran->kode_mapel;
            $this->nama_mapel = $this->mataPelajaran->nama_mapel;
            $this->deskripsi = $this->mataPelajaran->deskripsi;
            $this->jenis = $this->mataPelajaran->jenis;
            $this->jumlah_jam = $this->mataPelajaran->jumlah_jam;
            $this->kelompok = $this->mataPelajaran->kelompok;
            $this->status = $this->mataPelajaran->status;
            $this->catatan = $this->mataPelajaran->catatan;
        } else {
            $this->mataPelajaran = new MataPelajaran();
        }
    }

    public function save()
    {
        if ($this->isEditing) {
            $this->validate([
                'kode_mapel' => 'required|string|max:10|unique:mata_pelajaran,kode_mapel,' . $this->mataPelajaran->id,
                'nama_mapel' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'jenis' => 'required|in:Wajib,Peminatan,Lintas Minat,Muatan Lokal',
                'jumlah_jam' => 'required|integer|min:1|max:10',
                'kelompok' => 'required|in:A,B,C',
                'status' => 'required|in:aktif,nonaktif',
                'catatan' => 'nullable|string',
            ]);
        } else {
            $this->validate();
        }

        if ($this->isEditing) {
            $this->mataPelajaran->update([
                'kode_mapel' => $this->kode_mapel,
                'nama_mapel' => $this->nama_mapel,
                'deskripsi' => $this->deskripsi,
                'jenis' => $this->jenis,
                'jumlah_jam' => $this->jumlah_jam,
                'kelompok' => $this->kelompok,
                'status' => $this->status,
                'catatan' => $this->catatan,
            ]);
        } else {
            MataPelajaran::create([
                'kode_mapel' => $this->kode_mapel,
                'nama_mapel' => $this->nama_mapel,
                'deskripsi' => $this->deskripsi,
                'jenis' => $this->jenis,
                'jumlah_jam' => $this->jumlah_jam,
                'kelompok' => $this->kelompok,
                'status' => $this->status,
                'catatan' => $this->catatan,
            ]);
        }

        session()->flash('message', 'Mata pelajaran berhasil ' . ($this->isEditing ? 'diperbarui' : 'ditambahkan'));
        return redirect()->route('mata-pelajaran.index');
    }

    public function render()
    {
        return view('livewire.mata-pelajaran-management.mata-pelajaran-form');
    }
}
