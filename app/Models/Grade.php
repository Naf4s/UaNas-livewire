<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';
    
    protected $fillable = [
        'template_kurikulum_id',
        'aspek_penilaian_id',
        'mata_pelajaran_id',
        'rombel_id',
        'siswa_id',
        'guru_id',
        'tahun_ajaran',
        'semester',
        'jenis_penilaian',
        'nilai',
        'nilai_angka',
        'catatan',
        'tanggal_penilaian',
        'status'
    ];

    protected $casts = [
        'nilai_angka' => 'decimal:2',
        'tanggal_penilaian' => 'date',
    ];

    public function templateKurikulum()
    {
        return $this->belongsTo(TemplateKurikulum::class, 'template_kurikulum_id');
    }

    public function aspekPenilaian()
    {
        return $this->belongsTo(AspekPenilaian::class, 'aspek_penilaian_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

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

    public function gradeSetting()
    {
        return $this->belongsTo(GradeSetting::class, [
            'template_kurikulum_id' => 'template_kurikulum_id',
            'aspek_penilaian_id' => 'aspek_penilaian_id',
            'mata_pelajaran_id' => 'mata_pelajaran_id'
        ]);
    }

    public function getNilaiDisplayAttribute()
    {
        if ($this->nilai_angka !== null) {
            return number_format($this->nilai_angka, 1);
        }
        return $this->nilai;
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

    public function getJenisPenilaianTextAttribute()
    {
        $jenis = [
            'Harian' => 'Penilaian Harian',
            'Tugas' => 'Tugas',
            'UTS' => 'Ujian Tengah Semester',
            'UAS' => 'Ujian Akhir Semester',
            'Praktik' => 'Praktik',
            'Proyek' => 'Proyek',
            'Portofolio' => 'Portofolio'
        ];
        
        return $jenis[$this->jenis_penilaian] ?? $this->jenis_penilaian;
    }

    public function isPublished()
    {
        return $this->status === 'published';
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    // Scope untuk query
    public function scopeByRombel($query, $rombelId)
    {
        return $query->where('rombel_id', $rombelId);
    }

    public function scopeByMataPelajaran($query, $mataPelajaranId)
    {
        return $query->where('mata_pelajaran_id', $mataPelajaranId);
    }

    public function scopeByAspek($query, $aspekId)
    {
        return $query->where('aspek_penilaian_id', $aspekId);
    }

    public function scopeBySemester($query, $tahunAjaran, $semester)
    {
        return $query->where('tahun_ajaran', $tahunAjaran)
                    ->where('semester', $semester);
    }

    public function scopeByJenisPenilaian($query, $jenis)
    {
        return $query->where('jenis_penilaian', $jenis);
    }
}
