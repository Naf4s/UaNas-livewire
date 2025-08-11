<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    
    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'rt_rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'no_hp',
        'email',
        'nama_ayah',
        'pekerjaan_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'no_hp_ibu',
        'alamat_ortu',
        'nama_wali',
        'pekerjaan_wali',
        'no_hp_wali',
        'alamat_wali',
        'status_siswa',
        'tanggal_masuk',
        'tanggal_keluar',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rombel()
    {
        return $this->belongsToMany(Rombel::class, 'siswa_rombel')
                    ->withPivot('tahun_ajaran', 'semester', 'status', 'tanggal_masuk_rombel', 'tanggal_keluar_rombel')
                    ->withTimestamps();
    }

    public function rombelAktif()
    {
        return $this->belongsToMany(Rombel::class, 'siswa_rombel')
                    ->wherePivot('status', 'aktif')
                    ->withPivot('tahun_ajaran', 'semester', 'tanggal_masuk_rombel');
    }

    public function getUmurAttribute()
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function getStatusSiswaTextAttribute()
    {
        $status = [
            'aktif' => 'Aktif',
            'nonaktif' => 'Tidak Aktif',
            'lulus' => 'Lulus',
            'pindah' => 'Pindah',
            'keluar' => 'Keluar'
        ];
        
        return $status[$this->status_siswa] ?? $this->status_siswa;
    }

    public function isActive()
    {
        return $this->status_siswa === 'aktif';
    }

    public function getAlamatLengkapAttribute()
    {
        $alamat = $this->alamat;
        if ($this->rt_rw) $alamat .= ', RT/RW ' . $this->rt_rw;
        $alamat .= ', ' . $this->desa_kelurahan;
        $alamat .= ', ' . $this->kecamatan;
        $alamat .= ', ' . $this->kabupaten_kota;
        $alamat .= ', ' . $this->provinsi;
        if ($this->kode_pos) $alamat .= ' ' . $this->kode_pos;
        
        return $alamat;
    }
}
