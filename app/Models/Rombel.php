<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    protected $table = 'rombel';
    
    protected $fillable = [
        'kelas_id',
        'nama_rombel',
        'kode_rombel',
        'kapasitas',
        'jumlah_siswa',
        'wali_kelas_id',
        'deskripsi',
        'status'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_rombel')
                    ->withPivot('tahun_ajaran', 'semester', 'status', 'tanggal_masuk_rombel', 'tanggal_keluar_rombel')
                    ->withTimestamps();
    }

    public function siswaAktif()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_rombel')
                    ->wherePivot('status', 'aktif')
                    ->withPivot('tahun_ajaran', 'semester', 'tanggal_masuk_rombel');
    }

    public function isActive()
    {
        return $this->status === 'aktif';
    }

    public function getSisaKapasitasAttribute()
    {
        return $this->kapasitas - $this->jumlah_siswa;
    }

    public function isFull()
    {
        return $this->jumlah_siswa >= $this->kapasitas;
    }
}
