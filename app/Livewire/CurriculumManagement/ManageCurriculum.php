<?php

namespace App\Livewire\CurriculumManagement;

use App\Models\TemplateKurikulum;
use App\Models\AspekPenilaian;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Manajemen Kurikulum')]
class ManageCurriculum extends Component
{
    use WithPagination;

    // Properties untuk template kurikulum
    public $searchTemplate = '';
    public $jenisKurikulumFilter = '';
    public $statusFilter = '';
    public $showTemplateModal = false;
    public $editingTemplate = null;
    public $isEditingTemplate = false;

    // Properties untuk aspek penilaian
    public $selectedTemplateId = null;
    public $selectedTemplate = null;
    public $aspekPenilaianTree = [];
    public $expandedAspeks = [];

    // Properties untuk modal aspek penilaian
    public $showAspekModal = false;
    public $editingAspek = null;
    public $isEditingAspek = false;

    // Form properties untuk template kurikulum
    public $nama_template = '';
    public $deskripsi = '';
    public $jenis_kurikulum = 'K13';
    public $tahun_berlaku = '';
    public $catatan = '';

    // Form properties untuk aspek penilaian
    public $nama_aspek = '';
    public $tipe = 'domain';
    public $parent_id = '';
    public $urutan = 0;
    public $bobot = 0.00;
    public $status = 'aktif';

    public function mount()
    {
        // Load template pertama sebagai default jika ada
        $firstTemplate = TemplateKurikulum::first();
        if ($firstTemplate) {
            $this->selectTemplate($firstTemplate->id);
        }
        
        // Set tahun default
        $this->tahun_berlaku = date('Y');
    }

    // Methods untuk template kurikulum
    public function updatingSearchTemplate()
    {
        $this->resetPage();
    }

    public function updatingJenisKurikulumFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function activateTemplate($templateId)
    {
        $template = TemplateKurikulum::findOrFail($templateId);
        $template->activate();
        
        session()->flash('message', "Template kurikulum '{$template->nama_template}' berhasil diaktifkan");
        
        // Refresh data
        $this->loadTemplateData();
    }

    public function deleteTemplate($templateId)
    {
        $template = TemplateKurikulum::findOrFail($templateId);
        
        // Cek apakah template masih digunakan
        if ($template->aspekPenilaian()->count() > 0) {
            session()->flash('error', 'Template tidak dapat dihapus karena masih memiliki aspek penilaian');
            return;
        }
        
        $template->delete();
        session()->flash('message', 'Template kurikulum berhasil dihapus');
        
        // Reset selection jika template yang dihapus sedang dipilih
        if ($this->selectedTemplateId == $templateId) {
            $this->selectedTemplateId = null;
            $this->selectedTemplate = null;
            $this->aspekPenilaianTree = [];
        }
    }

    // Methods untuk modal template kurikulum
    public function showAddTemplateModal()
    {
        $this->resetTemplateForm();
        $this->isEditingTemplate = false;
        $this->showTemplateModal = true;
    }

    public function showEditTemplateModal($templateId)
    {
        $template = TemplateKurikulum::findOrFail($templateId);
        
        $this->editingTemplate = $template;
        $this->isEditingTemplate = true;
        $this->nama_template = $template->nama_template;
        $this->deskripsi = $template->deskripsi;
        $this->jenis_kurikulum = $template->jenis_kurikulum;
        $this->tahun_berlaku = $template->tahun_berlaku;
        $this->catatan = $template->catatan;
        
        $this->showTemplateModal = true;
    }

    public function closeTemplateModal()
    {
        $this->showTemplateModal = false;
        $this->resetTemplateForm();
    }

    public function resetTemplateForm()
    {
        $this->editingTemplate = null;
        $this->isEditingTemplate = false;
        $this->nama_template = '';
        $this->deskripsi = '';
        $this->jenis_kurikulum = 'K13';
        $this->tahun_berlaku = date('Y');
        $this->catatan = '';
    }

    public function saveTemplate()
    {
        $this->validate([
            'nama_template' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_kurikulum' => 'required|in:K13,Kurikulum Merdeka,Kurikulum 2024',
            'tahun_berlaku' => 'required|string|max:4',
            'catatan' => 'nullable|string',
        ]);

        try {
            if ($this->isEditingTemplate && $this->editingTemplate) {
                // Update existing template
                $this->editingTemplate->update([
                    'nama_template' => $this->nama_template,
                    'deskripsi' => $this->deskripsi,
                    'jenis_kurikulum' => $this->jenis_kurikulum,
                    'tahun_berlaku' => $this->tahun_berlaku,
                    'catatan' => $this->catatan,
                ]);
                
                session()->flash('message', 'Template kurikulum berhasil diperbarui');
            } else {
                // Create new template
                TemplateKurikulum::create([
                    'nama_template' => $this->nama_template,
                    'deskripsi' => $this->deskripsi,
                    'jenis_kurikulum' => $this->jenis_kurikulum,
                    'tahun_berlaku' => $this->tahun_berlaku,
                    'catatan' => $this->catatan,
                    'status' => 'nonaktif', // Default nonaktif
                ]);
                
                session()->flash('message', 'Template kurikulum berhasil ditambahkan');
            }

            // Close modal dan refresh data
            $this->closeTemplateModal();
            $this->loadTemplateData();

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Methods untuk aspek penilaian
    public function selectTemplate($templateId)
    {
        $this->selectedTemplateId = $templateId;
        $this->selectedTemplate = TemplateKurikulum::findOrFail($templateId);
        $this->loadAspekPenilaianTree();
    }

    public function loadAspekPenilaianTree()
    {
        if (!$this->selectedTemplateId) return;

        $this->aspekPenilaianTree = AspekPenilaian::where('template_kurikulum_id', $this->selectedTemplateId)
            ->root()
            ->with('allChildren')
            ->ordered()
            ->get()
            ->toArray();
    }

    public function toggleAspekExpansion($aspekId)
    {
        if (in_array($aspekId, $this->expandedAspeks)) {
            $this->expandedAspeks = array_diff($this->expandedAspeks, [$aspekId]);
        } else {
            $this->expandedAspeks[] = $aspekId;
        }
    }

    public function loadTemplateData()
    {
        // Refresh templates list
        $this->dispatch('$refresh');
    }

    // Methods untuk modal aspek penilaian
    public function showAddAspekModal($parentId = null)
    {
        $this->resetAspekForm();
        $this->parent_id = $parentId;
        $this->isEditingAspek = false;
        $this->showAspekModal = true;
    }

    public function showEditAspekModal($aspekId)
    {
        $aspek = AspekPenilaian::findOrFail($aspekId);
        
        $this->editingAspek = $aspek;
        $this->isEditingAspek = true;
        $this->nama_aspek = $aspek->nama_aspek;
        $this->tipe = $aspek->tipe;
        $this->parent_id = $aspek->parent_id;
        $this->urutan = $aspek->urutan;
        $this->bobot = $aspek->bobot;
        $this->status = $aspek->status;
        
        $this->showAspekModal = true;
    }

    public function closeAspekModal()
    {
        $this->showAspekModal = false;
        $this->resetAspekForm();
    }

    public function resetAspekForm()
    {
        $this->editingAspek = null;
        $this->isEditingAspek = false;
        $this->nama_aspek = '';
        $this->tipe = 'domain';
        $this->parent_id = '';
        $this->urutan = 0;
        $this->bobot = 0.00;
        $this->status = 'aktif';
    }

    public function saveAspect()
    {
        $this->validate([
            'nama_aspek' => 'required|string|max:255',
            'tipe' => 'required|in:domain,aspek,indikator',
            'parent_id' => 'nullable|exists:aspek_penilaian,id',
            'urutan' => 'required|integer|min:0',
            'bobot' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        try {
            if ($this->isEditingAspek && $this->editingAspek) {
                // Update existing aspek
                $this->editingAspek->update([
                    'nama_aspek' => $this->nama_aspek,
                    'tipe' => $this->tipe,
                    'parent_id' => $this->parent_id ?: null,
                    'urutan' => $this->urutan,
                    'bobot' => $this->bobot,
                    'status' => $this->status,
                ]);
                
                session()->flash('message', 'Aspek penilaian berhasil diperbarui');
            } else {
                // Create new aspek
                AspekPenilaian::create([
                    'template_kurikulum_id' => $this->selectedTemplateId,
                    'parent_id' => $this->parent_id ?: null,
                    'nama_aspek' => $this->nama_aspek,
                    'tipe' => $this->tipe,
                    'urutan' => $this->urutan,
                    'bobot' => $this->bobot,
                    'status' => $this->status,
                ]);
                
                session()->flash('message', 'Aspek penilaian berhasil ditambahkan');
            }

            // Refresh tree dan close modal
            $this->loadAspekPenilaianTree();
            $this->closeAspekModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteAspek($aspekId)
    {
        $aspek = AspekPenilaian::findOrFail($aspekId);
        
        // Cek apakah aspek memiliki children
        if ($aspek->children()->count() > 0) {
            session()->flash('error', 'Aspek tidak dapat dihapus karena masih memiliki sub-aspek');
            return;
        }
        
        $aspek->delete();
        session()->flash('message', 'Aspek penilaian berhasil dihapus');
        
        // Refresh tree
        $this->loadAspekPenilaianTree();
    }

    public function toggleAspekStatus($aspekId)
    {
        $aspek = AspekPenilaian::findOrFail($aspekId);
        $newStatus = $aspek->status === 'aktif' ? 'nonaktif' : 'aktif';
        $aspek->update(['status' => $newStatus]);
        
        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('message', "Aspek '{$aspek->nama_aspek}' berhasil {$statusText}");
        
        // Refresh tree
        $this->loadAspekPenilaianTree();
    }

    public function render()
    {
        $templates = TemplateKurikulum::query()
            ->when($this->searchTemplate, function ($query) {
                $query->where('nama_template', 'like', '%' . $this->searchTemplate . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->searchTemplate . '%');
            })
            ->when($this->jenisKurikulumFilter, function ($query) {
                $query->where('jenis_kurikulum', $this->jenisKurikulumFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('status', 'desc')
            ->orderBy('nama_template')
            ->paginate(10);

        // Get available parent options for aspek form
        $parentOptions = [];
        if ($this->selectedTemplateId) {
            $parentOptions = AspekPenilaian::where('template_kurikulum_id', $this->selectedTemplateId)
                ->where('id', '!=', $this->editingAspek?->id)
                ->orderBy('nama_aspek')
                ->get();
        }

        return view('livewire.curriculum-management.manage-curriculum', [
            'templates' => $templates,
            'parentOptions' => $parentOptions
        ]);
    }
}
