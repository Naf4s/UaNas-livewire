<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    
    protected $fillable = [
        'rombel_id',
        'siswa_id',
        'guru_id',
        'tanggal',
        'status',
        'jam_masuk',
        'jam_keluar',
        'keterangan',
        'semester',
        'tahun_ajaran'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
        'jam_keluar' => 'datetime:H:i',
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function getStatusTextAttribute()
    {
        $status = [
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'alpha' => 'Alpha',
            'terlambat' => 'Terlambat'
        ];
        
        return $status[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'hadir' => 'success',
            'sakit' => 'warning',
            'izin' => 'info',
            'alpha' => 'danger',
            'terlambat' => 'warning',
            default => 'secondary'
        };
    }

    public function isHadir()
    {
        return $this->status === 'hadir';
    }

    public function isSakit()
    {
        return $this->status === 'sakit';
    }

    public function isIzin()
    {
        return $this->status === 'izin';
    }

    public function isAlpha()
    {
        return $this->status === 'alpha';
    }

    public function isTerlambat()
    {
        return $this->status === 'terlambat';
    }

    // Scope untuk query
    public function scopeByRombel($query, $rombelId)
    {
        return $query->where('rombel_id', $rombelId);
    }

    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    public function scopeByTanggal($query, $tanggal)
    {
        return $query->where('tanggal', $tanggal);
    }

    public function scopeBySemester($query, $semester, $tahunAjaran)
    {
        return $query->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
