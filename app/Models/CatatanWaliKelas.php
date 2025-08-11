<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanWaliKelas extends Model
{
    use HasFactory;

    protected $table = 'catatan_wali_kelas';
    
    protected $fillable = [
        'rombel_id',
        'siswa_id',
        'wali_kelas_id',
        'jenis_catatan',
        'catatan',
        'kategori',
        'tanggal_catatan',
        'semester',
        'tahun_ajaran',
        'dibaca_ortu',
        'tanggal_dibaca_ortu',
        'tanggapan_ortu',
        'status'
    ];

    protected $casts = [
        'tanggal_catatan' => 'date',
        'tanggal_dibaca_ortu' => 'date',
        'dibaca_ortu' => 'boolean',
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function getJenisCatatanTextAttribute()
    {
        $jenis = [
            'akademik' => 'Akademik',
            'non_akademik' => 'Non-Akademik',
            'perilaku' => 'Perilaku',
            'kehadiran' => 'Kehadiran',
            'lainnya' => 'Lainnya'
        ];
        
        return $jenis[$this->jenis_catatan] ?? $this->jenis_catatan;
    }

    public function getKategoriTextAttribute()
    {
        $kategori = [
            'positif' => 'Positif',
            'negatif' => 'Negatif',
            'netral' => 'Netral'
        ];
        
        return $kategori[$this->kategori] ?? $this->kategori;
    }

    public function getKategoriColorAttribute()
    {
        return match($this->kategori) {
            'positif' => 'success',
            'negatif' => 'danger',
            'netral' => 'info',
            default => 'secondary'
        };
    }

    public function getStatusTextAttribute()
    {
        $status = [
            'draft' => 'Draft',
            'published' => 'Dipublikasi',
            'archived' => 'Diarsipkan'
        ];
        
        return $status[$this->status] ?? $this->status;
    }

    public function isPublished()
    {
        return $this->status === 'published';
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isPositif()
    {
        return $this->kategori === 'positif';
    }

    public function isNegatif()
    {
        return $this->kategori === 'negatif';
    }

    public function isNetral()
    {
        return $this->kategori === 'netral';
    }

    public function isDibacaOrtu()
    {
        return $this->dibaca_ortu;
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

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_catatan', $jenis);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeBySemester($query, $semester, $tahunAjaran)
    {
        return $query->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
