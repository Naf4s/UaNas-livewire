<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';
    
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'deskripsi',
        'jenis',
        'jumlah_jam',
        'kelompok',
        'status',
        'catatan'
    ];

    public function isActive()
    {
        return $this->status === 'aktif';
    }

    public function isWajib()
    {
        return $this->jenis === 'Wajib';
    }

    public function isPeminatan()
    {
        return $this->jenis === 'Peminatan';
    }

    public function getJenisTextAttribute()
    {
        $jenis = [
            'Wajib' => 'Mata Pelajaran Wajib',
            'Peminatan' => 'Mata Pelajaran Peminatan',
            'Lintas Minat' => 'Mata Pelajaran Lintas Minat',
            'Muatan Lokal' => 'Mata Pelajaran Muatan Lokal'
        ];
        
        return $jenis[$this->jenis] ?? $this->jenis;
    }

    public function getKelompokTextAttribute()
    {
        $kelompok = [
            'A' => 'Kelompok A (Wajib)',
            'B' => 'Kelompok B (Wajib)',
            'C' => 'Kelompok C (Peminatan)'
        ];
        
        return $kelompok[$this->kelompok] ?? $this->kelompok;
    }

    public function getJumlahJamTextAttribute()
    {
        return $this->jumlah_jam . ' jam/minggu';
    }

    // Scope untuk filter
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    public function scopeByKelompok($query, $kelompok)
    {
        return $query->where('kelompok', $kelompok);
    }
}
