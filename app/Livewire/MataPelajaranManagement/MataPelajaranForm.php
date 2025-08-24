<?php

namespace App\Livewire\MataPelajaranManagement;

use App\Models\MataPelajaran;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

#[Title('Form Mata Pelajaran')]
class MataPelajaranForm extends Component
{
    public MataPelajaran $mataPelajaran;
    public $isEditing = false;

    #[Rule('required|string|max:10|unique:mata_pelajaran,kode_mapel')]
    public $kode_mapel = '';

    #[Rule('required|string|max:255')]
    public $nama_mapel = '';

    #[Rule('nullable|string|max:500')]
    public $deskripsi = '';

    #[Rule('required|in:Wajib,Peminatan,Lintas Minat,Muatan Lokal')]
    public $jenis = 'Wajib';

    #[Rule('required|integer|min:1|max:10')]
    public $jumlah_jam = 2;

    #[Rule('required|in:A,B,C')]
    public $kelompok = 'A';

    #[Rule('required|in:aktif,nonaktif')]
    public $status = 'aktif';

    #[Rule('nullable|string|max:1000')]
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

    public function updatedJenis()
    {
        // Auto-set kelompok berdasarkan jenis mata pelajaran
        if ($this->jenis === 'Wajib') {
            $this->kelompok = in_array($this->kelompok, ['A', 'B']) ? $this->kelompok : 'A';
        } elseif ($this->jenis === 'Peminatan' || $this->jenis === 'Lintas Minat') {
            $this->kelompok = 'C';
        } elseif ($this->jenis === 'Muatan Lokal') {
            $this->kelompok = 'B';
        }
    }

    public function save()
    {
        if ($this->isEditing) {
            $this->validate([
                'kode_mapel' => 'required|string|max:10|unique:mata_pelajaran,kode_mapel,' . $this->mataPelajaran->id,
                'nama_mapel' => 'required|string|max:255',
                'deskripsi' => 'nullable|string|max:500',
                'jenis' => 'required|in:Wajib,Peminatan,Lintas Minat,Muatan Lokal',
                'jumlah_jam' => 'required|integer|min:1|max:10',
                'kelompok' => 'required|in:A,B,C',
                'status' => 'required|in:aktif,nonaktif',
                'catatan' => 'nullable|string|max:1000',
            ]);
        } else {
            $this->validate();
        }

        try {
            if ($this->isEditing) {
                $this->mataPelajaran->update([
                    'kode_mapel' => strtoupper(trim($this->kode_mapel)),
                    'nama_mapel' => trim($this->nama_mapel),
                    'deskripsi' => trim($this->deskripsi),
                    'jenis' => $this->jenis,
                    'jumlah_jam' => $this->jumlah_jam,
                    'kelompok' => $this->kelompok,
                    'status' => $this->status,
                    'catatan' => trim($this->catatan),
                ]);
                
                session()->flash('success', 'Mata pelajaran berhasil diperbarui');
            } else {
                MataPelajaran::create([
                    'kode_mapel' => strtoupper(trim($this->kode_mapel)),
                    'nama_mapel' => trim($this->nama_mapel),
                    'deskripsi' => trim($this->deskripsi),
                    'jenis' => $this->jenis,
                    'jumlah_jam' => $this->jumlah_jam,
                    'kelompok' => $this->kelompok,
                    'status' => $this->status,
                    'catatan' => trim($this->catatan),
                ]);
                
                session()->flash('success', 'Mata pelajaran berhasil ditambahkan');
            }

            return redirect()->route('mata-pelajaran.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('mata-pelajaran.index');
    }

    public function render()
    {
        return view('livewire.mata-pelajaran-management.mata-pelajaran-form')
            ->layout('components.layouts.app');
    }
}
