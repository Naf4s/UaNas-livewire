<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    
    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan',
        'deskripsi',
        'status'
    ];

    public function rombel()
    {
        return $this->hasMany(Rombel::class);
    }

    public function isActive()
    {
        return $this->status === 'aktif';
    }

    public function getTingkatJurusanAttribute()
    {
        return $this->tingkat . ' ' . ($this->jurusan ?? '');
    }
}
