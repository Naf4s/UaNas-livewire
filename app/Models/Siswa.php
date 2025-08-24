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

    // Add missing kelas relationship through rombel
    public function kelas()
    {
        return $this->hasManyThrough(
            Kelas::class,
            Rombel::class,
            'id', // Foreign key on rombel table
            'id', // Foreign key on kelas table
            'id', // Local key on siswa table
            'kelas_id' // Local key on rombel table
        )->join('siswa_rombel', 'rombel.id', '=', 'siswa_rombel.rombel_id')
          ->where('siswa_rombel.siswa_id', $this->id)
          ->where('siswa_rombel.status', 'aktif');
    }

    // Add direct access to current kelas through active rombel
    public function getKelasAttribute()
    {
        $activeRombel = $this->rombelAktif()->first();
        return $activeRombel ? $activeRombel->kelas : null;
    }

    // Add grades relationship
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // Add absensi relationship
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    // Add catatanWaliKelas relationship
    public function catatanWaliKelas()
    {
        return $this->hasMany(CatatanWaliKelas::class);
    }

    // Add usulanKenaikanKelas relationship
    public function usulanKenaikanKelas()
    {
        return $this->hasMany(UsulanKenaikanKelas::class);
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

    // Add accessor for nama (backward compatibility)
    public function getNamaAttribute()
    {
        return $this->nama_lengkap;
    }
}
