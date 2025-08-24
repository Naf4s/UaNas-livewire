<?php

namespace App\Livewire\GradeManagement;

use App\Models\Grade;
use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Manajemen Penilaian')]
class GradeIndex extends Component
{
    public $stats = [];
    public $recentActivities = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentActivities();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_siswa' => Siswa::where('status_siswa', 'aktif')->count(),
            'lengkap' => Grade::where('status', 'published')->count(),
            'belum_lengkap' => Grade::where('status', 'draft')->count(),
            'belum_input' => 0, // This would need more complex logic based on curriculum structure
        ];
    }

    public function loadRecentActivities()
    {
        $this->recentActivities = Grade::with(['siswa', 'mataPelajaran'])
            ->where('status', '!=', 'draft')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.grade-management.index');
    }
}
