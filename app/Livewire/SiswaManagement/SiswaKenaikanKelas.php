<?php

namespace App\Livewire\SiswaManagement;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Rombel;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;

class SiswaKenaikanKelas extends Component
{
    #[Rule('required|integer|min:2020|max:2030')]
    public $tahun_ajaran = '';

    #[Rule('required|in:Ganjil,Genap')]
    public $semester = '';

    #[Rule('required|exists:kelas,id')]
    public $kelas_asal_id = '';

    #[Rule('required|exists:kelas,id')]
    public $kelas_tujuan_id = '';

    public $siswaList = [];
    public $selectedSiswa = [];
    public $isProcessing = false;
    public $progress = 0;
    public $totalSiswa = 0;
    public $processedSiswa = 0;

    public function mount()
    {
        $this->tahun_ajaran = date('Y');
        $this->semester = 'Ganjil';
    }

    public function loadSiswa()
    {
        if (!$this->kelas_asal_id) {
            session()->flash('error', 'Pilih kelas asal terlebih dahulu');
            return;
        }

        $this->siswaList = Siswa::whereHas('rombel', function ($query) {
            $query->where('kelas_id', $this->kelas_asal_id)
                  ->where('status', 'aktif');
        })->with(['rombel' => function ($query) {
            $query->where('kelas_id', $this->kelas_asal_id)
                  ->where('status', 'aktif');
        }])->get();

        $this->totalSiswa = $this->siswaList->count();
        $this->selectedSiswa = $this->siswaList->pluck('id')->toArray();
    }

    public function selectAll()
    {
        $this->selectedSiswa = $this->siswaList->pluck('id')->toArray();
    }

    public function unselectAll()
    {
        $this->selectedSiswa = [];
    }

    public function processKenaikanKelas()
    {
        if (empty($this->selectedSiswa)) {
            session()->flash('error', 'Pilih siswa yang akan dinaikkan kelas');
            return;
        }

        $this->isProcessing = true;
        $this->progress = 0;
        $this->processedSiswa = 0;

        try {
            DB::beginTransaction();

            $siswaToProcess = Siswa::whereIn('id', $this->selectedSiswa)->get();
            $totalSiswa = $siswaToProcess->count();

            foreach ($siswaToProcess as $siswa) {
                // Nonaktifkan rombel lama
                $siswa->rombel()->where('kelas_id', $this->kelas_asal_id)
                      ->where('status', 'aktif')
                      ->update(['status' => 'nonaktif']);

                // Cari rombel tujuan yang sesuai
                $rombelTujuan = Rombel::where('kelas_id', $this->kelas_tujuan_id)
                                     ->where('status', 'aktif')
                                     ->first();

                if ($rombelTujuan) {
                    // Tambahkan ke rombel baru
                    $siswa->rombel()->attach($rombelTujuan->id, [
                        'tahun_ajaran' => $this->tahun_ajaran,
                        'semester' => $this->semester,
                        'status' => 'aktif',
                        'tanggal_masuk_rombel' => now(),
                        'keterangan' => 'Kenaikan kelas otomatis'
                    ]);

                    // Update jumlah siswa di rombel
                    $rombelTujuan->increment('jumlah_siswa');
                }

                $this->processedSiswa++;
                $this->progress = ($this->processedSiswa / $totalSiswa) * 100;
            }

            DB::commit();
            session()->flash('message', "Kenaikan kelas berhasil diproses untuk {$this->processedSiswa} siswa");
            
            // Reset form
            $this->siswaList = [];
            $this->selectedSiswa = [];
            $this->totalSiswa = 0;
            $this->processedSiswa = 0;
            $this->progress = 0;

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        $this->isProcessing = false;
    }

    public function render()
    {
        $kelas = Kelas::where('status', 'aktif')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        return view('livewire.siswa-management.siswa-kenaikan-kelas', [
            'kelas' => $kelas
        ]);
    }
}
