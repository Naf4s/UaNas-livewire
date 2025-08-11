<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AspekPenilaian extends Model
{
    use HasFactory;

    protected $table = 'aspek_penilaian';
    
    protected $fillable = [
        'template_kurikulum_id',
        'parent_id',
        'nama_aspek',
        'deskripsi',
        'tipe',
        'urutan',
        'bobot',
        'status',
        'catatan'
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
    ];

    public function templateKurikulum()
    {
        return $this->belongsTo(TemplateKurikulum::class, 'template_kurikulum_id');
    }

    public function parent()
    {
        return $this->belongsTo(AspekPenilaian::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AspekPenilaian::class, 'parent_id')
                    ->orderBy('urutan');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    public function isLeaf()
    {
        return $this->children()->count() === 0;
    }

    public function getLevelAttribute()
    {
        $level = 0;
        $current = $this;
        
        while ($current->parent) {
            $level++;
            $current = $current->parent;
        }
        
        return $level;
    }

    public function getTipeTextAttribute()
    {
        $tipe = [
            'domain' => 'Domain',
            'aspek' => 'Aspek',
            'indikator' => 'Indikator'
        ];
        
        return $tipe[$this->tipe] ?? $this->tipe;
    }

    public function getBobotTextAttribute()
    {
        return $this->bobot . '%';
    }

    public function isActive()
    {
        return $this->status === 'aktif';
    }

    // Scope untuk query hierarki
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}
