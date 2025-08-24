<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $casts = [
        'jumlah_jam' => 'integer',
    ];

    // Relasi dengan model lain
    public function templateKurikulum(): HasMany
    {
        return $this->hasMany(TemplateKurikulum::class, 'mata_pelajaran_id');
    }

    public function aspekPenilaian(): HasMany
    {
        return $this->hasMany(AspekPenilaian::class, 'mata_pelajaran_id');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'mata_pelajaran_id');
    }

    // Accessor methods
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

    public function isLintasMinat()
    {
        return $this->jenis === 'Lintas Minat';
    }

    public function isMuatanLokal()
    {
        return $this->jenis === 'Muatan Lokal';
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

    public function getStatusTextAttribute()
    {
        return ucfirst($this->status);
    }

    // Scope untuk filter
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeNonaktif($query)
    {
        return $query->where('status', 'nonaktif');
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    public function scopeByKelompok($query, $kelompok)
    {
        return $query->where('kelompok', $kelompok);
    }

    public function scopeWajib($query)
    {
        return $query->where('jenis', 'Wajib');
    }

    public function scopePeminatan($query)
    {
        return $query->where('jenis', 'Peminatan');
    }

    public function scopeLintasMinat($query)
    {
        return $query->where('jenis', 'Lintas Minat');
    }

    public function scopeMuatanLokal($query)
    {
        return $query->where('jenis', 'Muatan Lokal');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_mapel', 'like', '%' . $search . '%')
              ->orWhere('kode_mapel', 'like', '%' . $search . '%')
              ->orWhere('deskripsi', 'like', '%' . $search . '%');
        });
    }

    // Method untuk validasi sebelum delete
    public function canBeDeleted(): bool
    {
        // Cek apakah mata pelajaran masih digunakan
        return !$this->templateKurikulum()->exists() && 
               !$this->aspekPenilaian()->exists() && 
               !$this->grades()->exists();
    }

    // Method untuk mendapatkan total penggunaan
    public function getTotalUsageAttribute(): int
    {
        return $this->templateKurikulum()->count() + 
               $this->aspekPenilaian()->count() + 
               $this->grades()->count();
    }
}
