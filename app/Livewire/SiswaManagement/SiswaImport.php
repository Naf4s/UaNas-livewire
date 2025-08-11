<?php

namespace App\Livewire\SiswaManagement;

use App\Models\Siswa;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport extends Component
{
    use WithFileUploads;

    #[Rule('required|file|mimes:xlsx,xls,csv|max:2048')]
    public $file;

    public $progress = 0;
    public $totalRows = 0;
    public $processedRows = 0;
    public $successRows = 0;
    public $errorRows = 0;
    public $errors = [];
    public $isImporting = false;

    public function import()
    {
        $this->validate();
        $this->isImporting = true;
        $this->resetProgress();

        try {
            $data = Excel::toArray(new class implements ToModel, WithHeadingRow, WithValidation {
                public function model(array $row)
                {
                    return $row;
                }

                public function rules(): array
                {
                    return [
                        'nis' => 'required|unique:siswa,nis',
                        'nama_lengkap' => 'required',
                        'jenis_kelamin' => 'required|in:L,P',
                        'tempat_lahir' => 'required',
                        'tanggal_lahir' => 'required|date',
                        'agama' => 'required',
                        'alamat' => 'required',
                        'desa_kelurahan' => 'required',
                        'kecamatan' => 'required',
                        'kabupaten_kota' => 'required',
                        'provinsi' => 'required',
                        'tanggal_masuk' => 'required|date',
                    ];
                }
            }, $this->file)[0];

            $this->totalRows = count($data);
            $this->processedRows = 0;
            $this->successRows = 0;
            $this->errorRows = 0;
            $this->errors = [];

            foreach ($data as $index => $row) {
                try {
                    DB::beginTransaction();

                    // Generate email if not provided
                    $email = $row['email'] ?? strtolower(str_replace(' ', '', $row['nama_lengkap'])) . '@example.com';
                    $counter = 1;
                    while (User::where('email', $email)->exists()) {
                        $email = strtolower(str_replace(' ', '', $row['nama_lengkap'])) . $counter . '@example.com';
                        $counter++;
                    }

                    // Create user
                    $user = User::create([
                        'name' => $row['nama_lengkap'],
                        'email' => $email,
                        'password' => Hash::make('password123'), // Default password
                        'role' => 'siswa',
                        'nip_nis' => $row['nis'],
                        'status' => 'active',
                    ]);

                    // Create siswa
                    Siswa::create([
                        'user_id' => $user->id,
                        'nis' => $row['nis'],
                        'nisn' => $row['nisn'] ?? null,
                        'nama_lengkap' => $row['nama_lengkap'],
                        'nama_panggilan' => $row['nama_panggilan'] ?? null,
                        'jenis_kelamin' => $row['jenis_kelamin'],
                        'tempat_lahir' => $row['tempat_lahir'],
                        'tanggal_lahir' => $row['tanggal_lahir'],
                        'agama' => $row['agama'],
                        'alamat' => $row['alamat'],
                        'rt_rw' => $row['rt_rw'] ?? null,
                        'desa_kelurahan' => $row['desa_kelurahan'],
                        'kecamatan' => $row['kecamatan'],
                        'kabupaten_kota' => $row['kabupaten_kota'],
                        'provinsi' => $row['provinsi'],
                        'kode_pos' => $row['kode_pos'] ?? null,
                        'no_hp' => $row['no_hp'] ?? null,
                        'nama_ayah' => $row['nama_ayah'] ?? null,
                        'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? null,
                        'no_hp_ayah' => $row['no_hp_ayah'] ?? null,
                        'nama_ibu' => $row['nama_ibu'] ?? null,
                        'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? null,
                        'no_hp_ibu' => $row['no_hp_ibu'] ?? null,
                        'alamat_ortu' => $row['alamat_ortu'] ?? null,
                        'nama_wali' => $row['nama_wali'] ?? null,
                        'pekerjaan_wali' => $row['pekerjaan_wali'] ?? null,
                        'no_hp_wali' => $row['no_hp_wali'] ?? null,
                        'alamat_wali' => $row['alamat_wali'] ?? null,
                        'status_siswa' => 'aktif',
                        'tanggal_masuk' => $row['tanggal_masuk'],
                        'keterangan' => $row['keterangan'] ?? null,
                    ]);

                    DB::commit();
                    $this->successRows++;

                } catch (\Exception $e) {
                    DB::rollback();
                    $this->errorRows++;
                    $this->errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                }

                $this->processedRows++;
                $this->progress = ($this->processedRows / $this->totalRows) * 100;
            }

            session()->flash('message', "Import selesai! Berhasil: {$this->successRows}, Gagal: {$this->errorRows}");
            $this->isImporting = false;

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            $this->isImporting = false;
        }
    }

    public function resetProgress()
    {
        $this->progress = 0;
        $this->totalRows = 0;
        $this->processedRows = 0;
        $this->successRows = 0;
        $this->errorRows = 0;
        $this->errors = [];
    }

    public function downloadTemplate()
    {
        // Generate sample Excel template
        $data = [
            [
                'nis' => '2024001',
                'nisn' => '1234567890',
                'nama_lengkap' => 'Ahmad Siswa',
                'nama_panggilan' => 'Ahmad',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2006-01-15',
                'agama' => 'Islam',
                'alamat' => 'Jl. Contoh No. 123',
                'rt_rw' => '001/002',
                'desa_kelurahan' => 'Contoh',
                'kecamatan' => 'Contoh',
                'kabupaten_kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '12345',
                'no_hp' => '08123456789',
                'nama_ayah' => 'Bapak Siswa',
                'pekerjaan_ayah' => 'Wiraswasta',
                'no_hp_ayah' => '08123456788',
                'nama_ibu' => 'Ibu Siswa',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'no_hp_ibu' => '08123456787',
                'alamat_ortu' => 'Jl. Contoh No. 123',
                'tanggal_masuk' => '2024-07-01',
                'keterangan' => 'Siswa baru'
            ]
        ];

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromArray {
            private $data;
            
            public function __construct($data)
            {
                $this->data = $data;
            }
            
            public function array(): array
            {
                return $this->data;
            }
        }, 'template_import_siswa.xlsx');
    }

    public function render()
    {
        return view('livewire.siswa-management.siswa-import');
    }
}
