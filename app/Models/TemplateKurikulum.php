<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateKurikulum extends Model
{
    use HasFactory;

    protected $table = 'template_kurikulum';
    
    protected $fillable = [
        'nama_template',
        'deskripsi',
        'jenis_kurikulum',
        'status',
        'tahun_berlaku',
        'catatan'
    ];

    public function aspekPenilaian()
    {
        return $this->hasMany(AspekPenilaian::class, 'template_kurikulum_id');
    }

    public function aspekPenilaianRoot()
    {
        return $this->hasMany(AspekPenilaian::class, 'template_kurikulum_id')
                    ->whereNull('parent_id')
                    ->orderBy('urutan');
    }

    public function isActive()
    {
        return $this->status === 'aktif';
    }

    public function activate()
    {
        // Nonaktifkan semua template lain
        static::where('id', '!=', $this->id)->update(['status' => 'nonaktif']);
        
        // Aktifkan template ini
        $this->update(['status' => 'aktif']);
    }

    public function getJenisKurikulumTextAttribute()
    {
        $jenis = [
            'K13' => 'Kurikulum 2013',
            'Kurikulum Merdeka' => 'Kurikulum Merdeka',
            'Kurikulum 2024' => 'Kurikulum 2024'
        ];
        
        return $jenis[$this->jenis_kurikulum] ?? $this->jenis_kurikulum;
    }

    public function getStatusTextAttribute()
    {
        return $this->status === 'aktif' ? 'Aktif' : 'Tidak Aktif';
    }
}
