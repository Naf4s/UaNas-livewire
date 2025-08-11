<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanKenaikanKelas extends Model
{
    use HasFactory;

    protected $table = 'usulan_kenaikan_kelas';
    
    protected $fillable = [
        'rombel_id',
        'siswa_id',
        'wali_kelas_id',
        'status_usulan',
        'alasan_usulan',
        'rekomendasi',
        'semester',
        'tahun_ajaran',
        'tanggal_usulan',
        'status_approval',
        'approved_by',
        'tanggal_approval',
        'catatan_approval',
        'status_final'
    ];

    protected $casts = [
        'tanggal_usulan' => 'date',
        'tanggal_approval' => 'date',
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

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusUsulanTextAttribute()
    {
        $status = [
            'naik_kelas' => 'Naik Kelas',
            'tinggal_di_kelas' => 'Tinggal di Kelas',
            'lulus' => 'Lulus',
            'tidak_lulus' => 'Tidak Lulus'
        ];
        
        return $status[$this->status_usulan] ?? $this->status_usulan;
    }

    public function getStatusApprovalTextAttribute()
    {
        $status = [
            'pending' => 'Menunggu Approval',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'revisi' => 'Perlu Revisi'
        ];
        
        return $status[$this->status_approval] ?? $this->status_approval;
    }

    public function getStatusFinalTextAttribute()
    {
        $status = [
            'draft' => 'Draft',
            'submitted' => 'Sudah Dikirim',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak'
        ];
        
        return $status[$this->status_final] ?? $this->status_final;
    }

    public function getStatusUsulanColorAttribute()
    {
        return match($this->status_usulan) {
            'naik_kelas' => 'success',
            'tinggal_di_kelas' => 'warning',
            'lulus' => 'success',
            'tidak_lulus' => 'danger',
            default => 'secondary'
        };
    }

    public function getStatusApprovalColorAttribute()
    {
        return match($this->status_approval) {
            'pending' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
            'revisi' => 'info',
            default => 'secondary'
        };
    }

    public function getStatusFinalColorAttribute()
    {
        return match($this->status_final) {
            'draft' => 'secondary',
            'submitted' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }

    public function isNaikKelas()
    {
        return $this->status_usulan === 'naik_kelas';
    }

    public function isTinggalDiKelas()
    {
        return $this->status_usulan === 'tinggal_di_kelas';
    }

    public function isLulus()
    {
        return $this->status_usulan === 'lulus';
    }

    public function isTidakLulus()
    {
        return $this->status_usulan === 'tidak_lulus';
    }

    public function isPending()
    {
        return $this->status_approval === 'pending';
    }

    public function isApproved()
    {
        return $this->status_approval === 'disetujui';
    }

    public function isRejected()
    {
        return $this->status_approval === 'ditolak';
    }

    public function isDraft()
    {
        return $this->status_final === 'draft';
    }

    public function isSubmitted()
    {
        return $this->status_final === 'submitted';
    }

    public function isFinalApproved()
    {
        return $this->status_final === 'approved';
    }

    public function isFinalRejected()
    {
        return $this->status_final === 'rejected';
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

    public function scopeByStatusUsulan($query, $status)
    {
        return $query->where('status_usulan', $status);
    }

    public function scopeByStatusApproval($query, $status)
    {
        return $query->where('status_approval', $status);
    }

    public function scopeByStatusFinal($query, $status)
    {
        return $query->where('status_final', $status);
    }

    public function scopeBySemester($query, $semester, $tahunAjaran)
    {
        return $query->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran);
    }

    public function scopePending($query)
    {
        return $query->where('status_approval', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status_approval', 'disetujui');
    }
}
