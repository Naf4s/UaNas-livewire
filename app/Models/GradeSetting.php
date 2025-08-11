<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeSetting extends Model
{
    use HasFactory;

    protected $table = 'grade_settings';
    
    protected $fillable = [
        'template_kurikulum_id',
        'aspek_penilaian_id',
        'mata_pelajaran_id',
        'input_type',
        'nilai_min',
        'nilai_max',
        'nilai_lulus',
        'options',
        'satuan',
        'deskripsi_input',
        'wajib_diisi',
        'bisa_diubah',
        'status'
    ];

    protected $casts = [
        'nilai_min' => 'decimal:2',
        'nilai_max' => 'decimal:2',
        'nilai_lulus' => 'decimal:2',
        'options' => 'array',
        'wajib_diisi' => 'boolean',
        'bisa_diubah' => 'boolean',
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

    public function getInputTypeTextAttribute()
    {
        $types = [
            'number' => 'Input Angka',
            'select' => 'Pilihan Dropdown',
            'text' => 'Input Teks',
            'checkbox' => 'Checkbox',
            'radio' => 'Radio Button'
        ];
        
        return $types[$this->input_type] ?? $this->input_type;
    }

    public function getOptionsArrayAttribute()
    {
        if (is_array($this->options)) {
            return $this->options;
        }
        
        if (is_string($this->options)) {
            return json_decode($this->options, true) ?? [];
        }
        
        return [];
    }

    public function getRangeTextAttribute()
    {
        if ($this->input_type === 'number') {
            return "{$this->nilai_min} - {$this->nilai_max}";
        }
        
        return $this->satuan ?? 'N/A';
    }

    public function isNumberInput()
    {
        return $this->input_type === 'number';
    }

    public function isSelectInput()
    {
        return $this->input_type === 'select';
    }

    public function isTextInput()
    {
        return $this->input_type === 'text';
    }

    public function isCheckboxInput()
    {
        return $this->input_type === 'checkbox';
    }

    public function isRadioInput()
    {
        return $this->input_type === 'radio';
    }

    public function isActive()
    {
        return $this->status === 'aktif';
    }

    public function isRequired()
    {
        return $this->wajib_diisi;
    }

    public function isEditable()
    {
        return $this->bisa_diubah;
    }

    // Scope untuk query
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByInputType($query, $inputType)
    {
        return $query->where('input_type', $inputType);
    }

    public function scopeRequired($query)
    {
        return $query->where('wajib_diisi', true);
    }
}
