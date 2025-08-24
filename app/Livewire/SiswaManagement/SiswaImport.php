<?php

namespace App\Livewire\SiswaManagement;

use App\Models\Siswa;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

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
    public $currentStatus = '';

    public function import()
    {
        $this->validate();
        $this->isImporting = true;
        $this->resetProgress();

        try {
            $this->currentStatus = 'Membaca file Excel...';
            
            // Read Excel file
            $data = Excel::toArray(new class implements ToArray, WithHeadingRow {
                public function array(array $array): array
                {
                    return $array;
                }
            }, $this->file)[0];

            if (empty($data)) {
                throw new \Exception('File Excel kosong atau tidak memiliki data yang valid.');
            }

            $this->totalRows = count($data);
            $this->currentStatus = 'Memulai proses import...';

            // Validate headers
            $requiredHeaders = ['nis', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi', 'tanggal_masuk'];
            $headers = array_keys($data[0]);
            
            $missingHeaders = array_diff($requiredHeaders, array_map('strtolower', $headers));
            if (!empty($missingHeaders)) {
                throw new \Exception('Header yang diperlukan tidak ditemukan: ' . implode(', ', $missingHeaders));
            }

            foreach ($data as $index => $row) {
                try {
                    $this->currentStatus = "Memproses baris " . ($index + 2) . " dari {$this->totalRows}";
                    
                    // Validate required fields
                    $this->validateRow($row, $index + 2);
                    
                    DB::beginTransaction();

                    // Generate email if not provided
                    $email = $this->generateUniqueEmail($row['nama_lengkap']);

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
                        'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
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
                    $this->errors[] = [
                        'row' => $index + 2,
                        'field' => 'General',
                        'message' => $e->getMessage()
                    ];
                    
                    Log::error('Import siswa error pada baris ' . ($index + 2) . ': ' . $e->getMessage());
                }

                $this->processedRows++;
                $this->progress = ($this->processedRows / $this->totalRows) * 100;
            }

            $this->currentStatus = 'Import selesai!';
            session()->flash('message', "Import selesai! Berhasil: {$this->successRows}, Gagal: {$this->errorRows}");
            $this->isImporting = false;

        } catch (\Exception $e) {
            $this->currentStatus = 'Terjadi error!';
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            $this->isImporting = false;
            Log::error('Import siswa error: ' . $e->getMessage());
        }
    }

    private function validateRow($row, $rowNumber)
    {
        $errors = [];

        // Required fields validation
        $requiredFields = [
            'nis' => 'NIS',
            'nama_lengkap' => 'Nama Lengkap',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'agama' => 'Agama',
            'alamat' => 'Alamat',
            'desa_kelurahan' => 'Desa/Kelurahan',
            'kecamatan' => 'Kecamatan',
            'kabupaten_kota' => 'Kabupaten/Kota',
            'provinsi' => 'Provinsi',
            'tanggal_masuk' => 'Tanggal Masuk'
        ];

        foreach ($requiredFields as $field => $label) {
            if (empty($row[$field])) {
                $errors[] = "Field {$label} wajib diisi";
            }
        }

        // NIS validation
        if (!empty($row['nis'])) {
            if (Siswa::where('nis', $row['nis'])->exists()) {
                $errors[] = "NIS {$row['nis']} sudah terdaftar";
            }
        }

        // Jenis kelamin validation
        if (!empty($row['jenis_kelamin'])) {
            $jenisKelamin = strtoupper($row['jenis_kelamin']);
            if (!in_array($jenisKelamin, ['L', 'P'])) {
                $errors[] = "Jenis kelamin harus L atau P";
            }
        }

        // Date validation
        if (!empty($row['tanggal_lahir'])) {
            if (!$this->isValidDate($row['tanggal_lahir'])) {
                $errors[] = "Format tanggal lahir tidak valid";
            }
        }

        if (!empty($row['tanggal_masuk'])) {
            if (!$this->isValidDate($row['tanggal_masuk'])) {
                $errors[] = "Format tanggal masuk tidak valid";
            }
        }

        if (!empty($errors)) {
            throw new \Exception(implode(', ', $errors));
        }
    }

    private function isValidDate($date)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    private function generateUniqueEmail($namaLengkap)
    {
        $baseEmail = strtolower(str_replace(' ', '', $namaLengkap)) . '@example.com';
        $email = $baseEmail;
        $counter = 1;
        
        while (User::where('email', $email)->exists()) {
            $email = strtolower(str_replace(' ', '', $namaLengkap)) . $counter . '@example.com';
            $counter++;
        }
        
        return $email;
    }

    public function resetProgress()
    {
        $this->progress = 0;
        $this->totalRows = 0;
        $this->processedRows = 0;
        $this->successRows = 0;
        $this->errorRows = 0;
        $this->errors = [];
        $this->currentStatus = '';
    }

    public function downloadTemplate()
    {
        try {
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

            $headers = [
                'nis', 'nisn', 'nama_lengkap', 'nama_panggilan', 'jenis_kelamin', 
                'tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'rt_rw', 
                'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi', 
                'kode_pos', 'no_hp', 'nama_ayah', 'pekerjaan_ayah', 'no_hp_ayah', 
                'nama_ibu', 'pekerjaan_ibu', 'no_hp_ibu', 'alamat_ortu', 
                'tanggal_masuk', 'keterangan'
            ];

            $templateData = array_merge([$headers], $data);

            return Excel::download(new class($templateData) implements \Maatwebsite\Excel\Concerns\FromArray {
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

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengunduh template: ' . $e->getMessage());
        }
    }

    public function clearErrors()
    {
        $this->errors = [];
    }

    public function render()
    {
        return view('livewire.siswa-management.siswa-import');
    }
}
