<?php

namespace App\Livewire\UserManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

#[Title('Manajemen Pengguna')]
class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $confirmingDelete = false;
    public $userToDelete = null;
    public $showingUserDetails = false;
    public $selectedUser = null;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function exportUsers()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('nip_nis', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['Nama', 'Email', 'Role', 'NIP/NIS', 'Telepon', 'Status', 'Alamat', 'Dibuat Pada']);
            
            // Add data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    ucfirst($user->role),
                    $user->nip_nis ?? '-',
                    $user->phone ?? '-',
                    $user->status === 'active' ? 'Aktif' : 'Tidak Aktif',
                    $user->address ?? '-',
                    $user->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function showUserDetails($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->showingUserDetails = true;
    }

    public function closeUserDetails()
    {
        $this->showingUserDetails = false;
        $this->selectedUser = null;
    }

    public function confirmDelete($userId)
    {
        $this->userToDelete = $userId;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        if ($this->userToDelete) {
            $user = User::findOrFail($this->userToDelete);
            
            // Prevent deleting own account
            if ($user->id === auth()->id()) {
                session()->flash('error', 'Tidak dapat menghapus akun sendiri');
                $this->cancelDelete();
                return;
            }

            $user->delete();
            session()->flash('message', 'Pengguna berhasil dihapus');
            $this->cancelDelete();
        }
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->userToDelete = null;
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent deactivating own account
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Tidak dapat menonaktifkan akun sendiri');
            return;
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);
        
        $statusText = $newStatus === 'active' ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('message', "Pengguna berhasil {$statusText}");
    }

    #[On('userDeleted')]
    public function refreshTable()
    {
        $this->render();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('nip_nis', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        // Get user statistics
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $adminUsers = User::where('role', 'admin')->count();
        $kepalaUsers = User::where('role', 'kepala')->count();
        $guruUsers = User::where('role', 'guru')->count();
        $siswaUsers = User::where('role', 'siswa')->count();

        return view('livewire.user-management.user-table', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'adminUsers' => $adminUsers,
            'kepalaUsers' => $kepalaUsers,
            'guruUsers' => $guruUsers,
            'siswaUsers' => $siswaUsers,
        ]);
    }
}