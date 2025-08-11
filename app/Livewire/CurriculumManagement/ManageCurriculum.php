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

    // Properties untuk aspek penilaian
    public $selectedTemplateId = null;
    public $selectedTemplate = null;
    public $aspekPenilaianTree = [];

    // Properties untuk modal aspek penilaian
    public $showAspekModal = false;
    public $editingAspek = null;
    public $isEditingAspek = false;

    // Form properties untuk aspek penilaian
    public $nama_aspek = '';
    public $deskripsi = '';
    public $tipe = 'domain';
    public $parent_id = '';
    public $urutan = 0;
    public $bobot = 0.00;
    public $status = 'aktif';
    public $catatan = '';

    public function mount()
    {
        // Load template pertama sebagai default jika ada
        $firstTemplate = TemplateKurikulum::first();
        if ($firstTemplate) {
            $this->selectTemplate($firstTemplate->id);
        }
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
        $this->deskripsi = $aspek->deskripsi;
        $this->tipe = $aspek->tipe;
        $this->parent_id = $aspek->parent_id;
        $this->urutan = $aspek->urutan;
        $this->bobot = $aspek->bobot;
        $this->status = $aspek->status;
        $this->catatan = $aspek->catatan;
        
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
        $this->deskripsi = '';
        $this->tipe = 'domain';
        $this->parent_id = '';
        $this->urutan = 0;
        $this->bobot = 0.00;
        $this->status = 'aktif';
        $this->catatan = '';
    }

    public function saveAspect()
    {
        $this->validate([
            'nama_aspek' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:domain,aspek,indikator',
            'parent_id' => 'nullable|exists:aspek_penilaian,id',
            'urutan' => 'required|integer|min:0',
            'bobot' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string',
        ]);

        try {
            if ($this->isEditingAspek && $this->editingAspek) {
                // Update existing aspek
                $this->editingAspek->update([
                    'nama_aspek' => $this->nama_aspek,
                    'deskripsi' => $this->deskripsi,
                    'tipe' => $this->tipe,
                    'parent_id' => $this->parent_id ?: null,
                    'urutan' => $this->urutan,
                    'bobot' => $this->bobot,
                    'status' => $this->status,
                    'catatan' => $this->catatan,
                ]);
                
                session()->flash('message', 'Aspek penilaian berhasil diperbarui');
            } else {
                // Create new aspek
                AspekPenilaian::create([
                    'template_kurikulum_id' => $this->selectedTemplateId,
                    'parent_id' => $this->parent_id ?: null,
                    'nama_aspek' => $this->nama_aspek,
                    'deskripsi' => $this->deskripsi,
                    'tipe' => $this->tipe,
                    'urutan' => $this->urutan,
                    'bobot' => $this->bobot,
                    'status' => $this->status,
                    'catatan' => $this->catatan,
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
