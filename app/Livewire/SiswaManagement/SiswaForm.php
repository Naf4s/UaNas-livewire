<?php

namespace App\Livewire\SiswaManagement;

use App\Models\Siswa;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaForm extends Component
{
    public Siswa $siswa;
    public $isEditing = false;
    public $createUser = true;

    // User fields
    #[Rule('required|email|unique:users,email')]
    public $email = '';

    #[Rule('required|min:8')]
    public $password = '';

    // Siswa fields
    #[Rule('required|string|max:255|unique:siswa,nis')]
    public $nis = '';

    #[Rule('nullable|string|max:255|unique:siswa,nisn')]
    public $nisn = '';

    #[Rule('required|string|max:255')]
    public $nama_lengkap = '';

    #[Rule('nullable|string|max:255')]
    public $nama_panggilan = '';

    #[Rule('required|in:L,P')]
    public $jenis_kelamin = 'L';

    #[Rule('required|string|max:255')]
    public $tempat_lahir = '';

    #[Rule('required|date')]
    public $tanggal_lahir = '';

    #[Rule('required|string|max:255')]
    public $agama = '';

    #[Rule('required|string')]
    public $alamat = '';

    #[Rule('nullable|string|max:255')]
    public $rt_rw = '';

    #[Rule('required|string|max:255')]
    public $desa_kelurahan = '';

    #[Rule('required|string|max:255')]
    public $kecamatan = '';

    #[Rule('required|string|max:255')]
    public $kabupaten_kota = '';

    #[Rule('required|string|max:255')]
    public $provinsi = '';

    #[Rule('nullable|string|max:10')]
    public $kode_pos = '';

    #[Rule('nullable|string|max:20')]
    public $no_hp = '';

    #[Rule('nullable|string|max:255')]
    public $nama_ayah = '';

    #[Rule('nullable|string|max:255')]
    public $pekerjaan_ayah = '';

    #[Rule('nullable|string|max:20')]
    public $no_hp_ayah = '';

    #[Rule('nullable|string|max:255')]
    public $nama_ibu = '';

    #[Rule('nullable|string|max:255')]
    public $pekerjaan_ibu = '';

    #[Rule('nullable|string|max:20')]
    public $no_hp_ibu = '';

    #[Rule('nullable|string')]
    public $alamat_ortu = '';

    #[Rule('nullable|string|max:255')]
    public $nama_wali = '';

    #[Rule('nullable|string|max:255')]
    public $pekerjaan_wali = '';

    #[Rule('nullable|string|max:20')]
    public $no_hp_wali = '';

    #[Rule('nullable|string')]
    public $alamat_wali = '';

    #[Rule('required|in:aktif,nonaktif,lulus,pindah,keluar')]
    public $status_siswa = 'aktif';

    #[Rule('required|date')]
    public $tanggal_masuk = '';

    #[Rule('nullable|date')]
    public $tanggal_keluar = '';

    #[Rule('nullable|string')]
    public $keterangan = '';

    public function mount($siswaId = null)
    {
        if ($siswaId) {
            $this->siswa = Siswa::findOrFail($siswaId);
            $this->isEditing = true;
            $this->createUser = false;
            
            // Load existing data
            $this->nis = $this->siswa->nis;
            $this->nisn = $this->siswa->nisn;
            $this->nama_lengkap = $this->siswa->nama_lengkap;
            $this->nama_panggilan = $this->siswa->nama_panggilan;
            $this->jenis_kelamin = $this->siswa->jenis_kelamin;
            $this->tempat_lahir = $this->siswa->tempat_lahir;
            $this->tanggal_lahir = $this->siswa->tanggal_lahir->format('Y-m-d');
            $this->agama = $this->siswa->agama;
            $this->alamat = $this->siswa->alamat;
            $this->rt_rw = $this->siswa->rt_rw;
            $this->desa_kelurahan = $this->siswa->desa_kelurahan;
            $this->kecamatan = $this->siswa->kecamatan;
            $this->kabupaten_kota = $this->siswa->kabupaten_kota;
            $this->provinsi = $this->siswa->provinsi;
            $this->kode_pos = $this->siswa->kode_pos;
            $this->no_hp = $this->siswa->no_hp;
            $this->nama_ayah = $this->siswa->nama_ayah;
            $this->pekerjaan_ayah = $this->siswa->pekerjaan_ayah;
            $this->no_hp_ayah = $this->siswa->no_hp_ayah;
            $this->nama_ibu = $this->siswa->nama_ibu;
            $this->pekerjaan_ibu = $this->siswa->pekerjaan_ibu;
            $this->no_hp_ibu = $this->siswa->no_hp_ibu;
            $this->alamat_ortu = $this->siswa->alamat_ortu;
            $this->nama_wali = $this->siswa->nama_wali;
            $this->pekerjaan_wali = $this->siswa->pekerjaan_wali;
            $this->no_hp_wali = $this->siswa->no_hp_wali;
            $this->alamat_wali = $this->siswa->alamat_wali;
            $this->status_siswa = $this->siswa->status_siswa;
            $this->tanggal_masuk = $this->siswa->tanggal_masuk->format('Y-m-d');
            $this->tanggal_keluar = $this->siswa->tanggal_keluar ? $this->siswa->tanggal_keluar->format('Y-m-d') : '';
            $this->keterangan = $this->siswa->keterangan;
            
            // Load user data
            if ($this->siswa->user) {
                $this->email = $this->siswa->user->email;
            }
        } else {
            $this->siswa = new Siswa();
            $this->tanggal_masuk = date('Y-m-d');
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            if ($this->isEditing) {
                // Update existing siswa
                $this->siswa->update([
                    'nis' => $this->nis,
                    'nisn' => $this->nisn,
                    'nama_lengkap' => $this->nama_lengkap,
                    'nama_panggilan' => $this->nama_panggilan,
                    'jenis_kelamin' => $this->jenis_kelamin,
                    'tempat_lahir' => $this->tempat_lahir,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'agama' => $this->agama,
                    'alamat' => $this->alamat,
                    'rt_rw' => $this->rt_rw,
                    'desa_kelurahan' => $this->desa_kelurahan,
                    'kecamatan' => $this->kecamatan,
                    'kabupaten_kota' => $this->kabupaten_kota,
                    'provinsi' => $this->provinsi,
                    'kode_pos' => $this->kode_pos,
                    'no_hp' => $this->no_hp,
                    'nama_ayah' => $this->nama_ayah,
                    'pekerjaan_ayah' => $this->pekerjaan_ayah,
                    'no_hp_ayah' => $this->no_hp_ayah,
                    'nama_ibu' => $this->nama_ibu,
                    'pekerjaan_ibu' => $this->pekerjaan_ibu,
                    'no_hp_ibu' => $this->no_hp_ibu,
                    'alamat_ortu' => $this->alamat_ortu,
                    'nama_wali' => $this->nama_wali,
                    'pekerjaan_wali' => $this->pekerjaan_wali,
                    'no_hp_wali' => $this->no_hp_wali,
                    'alamat_wali' => $this->alamat_wali,
                    'status_siswa' => $this->status_siswa,
                    'tanggal_masuk' => $this->tanggal_masuk,
                    'tanggal_keluar' => $this->tanggal_keluar,
                    'keterangan' => $this->keterangan,
                ]);

                // Update user if exists
                if ($this->siswa->user) {
                    $this->siswa->user->update([
                        'name' => $this->nama_lengkap,
                        'email' => $this->email,
                    ]);
                }
            } else {
                // Create new user first
                $user = User::create([
                    'name' => $this->nama_lengkap,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'role' => 'siswa',
                    'nip_nis' => $this->nis,
                    'status' => 'active',
                ]);

                // Create new siswa
                $this->siswa = Siswa::create([
                    'user_id' => $user->id,
                    'nis' => $this->nis,
                    'nisn' => $this->nisn,
                    'nama_lengkap' => $this->nama_lengkap,
                    'nama_panggilan' => $this->nama_panggilan,
                    'jenis_kelamin' => $this->jenis_kelamin,
                    'tempat_lahir' => $this->tempat_lahir,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'agama' => $this->agama,
                    'alamat' => $this->alamat,
                    'rt_rw' => $this->rt_rw,
                    'desa_kelurahan' => $this->desa_kelurahan,
                    'kecamatan' => $this->kecamatan,
                    'kabupaten_kota' => $this->kabupaten_kota,
                    'provinsi' => $this->provinsi,
                    'kode_pos' => $this->kode_pos,
                    'no_hp' => $this->no_hp,
                    'nama_ayah' => $this->nama_ayah,
                    'pekerjaan_ayah' => $this->pekerjaan_ayah,
                    'no_hp_ayah' => $this->no_hp_ayah,
                    'nama_ibu' => $this->nama_ibu,
                    'pekerjaan_ibu' => $this->pekerjaan_ibu,
                    'no_hp_ibu' => $this->no_hp_ibu,
                    'alamat_ortu' => $this->alamat_ortu,
                    'nama_wali' => $this->nama_wali,
                    'pekerjaan_wali' => $this->pekerjaan_wali,
                    'no_hp_wali' => $this->no_hp_wali,
                    'alamat_wali' => $this->alamat_wali,
                    'status_siswa' => $this->status_siswa,
                    'tanggal_masuk' => $this->tanggal_masuk,
                    'tanggal_keluar' => $this->tanggal_keluar,
                    'keterangan' => $this->keterangan,
                ]);
            }

            DB::commit();
            session()->flash('message', 'Siswa berhasil ' . ($this->isEditing ? 'diperbarui' : 'ditambahkan'));
            return redirect()->route('siswa.index');

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.siswa-management.siswa-form');
    }
}
