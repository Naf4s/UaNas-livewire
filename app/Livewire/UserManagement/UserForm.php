<?php

namespace App\Livewire\UserManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule as ValidationRule;

class UserForm extends Component
{
    public User $user;
    public $isEditing = false;

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|email')]
    public $email = '';

    #[Rule('required|in:admin,kepala,guru,siswa')]
    public $role = 'siswa';

    #[Rule('nullable|string|max:255')]
    public $nip_nis = '';

    #[Rule('nullable|string|max:20')]
    public $phone = '';

    #[Rule('nullable|string')]
    public $address = '';

    #[Rule('required|in:active,inactive')]
    public $status = 'active';

    #[Rule('nullable|min:8')]
    public $password = '';

    public function mount($userId = null)
    {
        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->isEditing = true;
            
            // Check if user can edit this user
            if (!$this->canEditUser($this->user)) {
                abort(403, 'Anda tidak memiliki izin untuk mengedit pengguna ini');
            }
            
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->role = $this->user->role;
            $this->nip_nis = $this->user->nip_nis;
            $this->phone = $this->user->phone;
            $this->address = $this->user->address;
            $this->status = $this->user->status;
            $this->password = '';
        } else {
            // Check if user can create new users
            if (!$this->canCreateUser()) {
                abort(403, 'Anda tidak memiliki izin untuk membuat pengguna baru');
            }
            
            $this->user = new User();
        }
    }

    private function canEditUser(User $userToEdit): bool
    {
        $currentUser = auth()->user();
        
        // Admin can edit anyone
        if ($currentUser->isAdmin()) {
            return true;
        }
        
        // Users can edit their own profile
        if ($currentUser->id === $userToEdit->id) {
            return true;
        }
        
        // Kepala can edit guru and siswa
        if ($currentUser->isKepala() && in_array($userToEdit->role, ['guru', 'siswa'])) {
            return true;
        }
        
        return false;
    }

    private function canCreateUser(): bool
    {
        $currentUser = auth()->user();
        
        // Admin can create anyone
        if ($currentUser->isAdmin()) {
            return true;
        }
        
        // Kepala can create guru and siswa
        if ($currentUser->isKepala()) {
            return true;
        }
        
        return false;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                ValidationRule::unique('users')->ignore($this->user->id ?? null),
            ],
            'role' => [
                'required',
                'in:' . implode(',', $this->getAllowedRoles()),
            ],
            'nip_nis' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];

        // NIP/NIS is required for guru, kepala, and admin
        if (in_array($this->role, ['guru', 'kepala', 'admin'])) {
            $rules['nip_nis'] = 'required|string|max:255';
        }

        if (!$this->isEditing || $this->password) {
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'phone.regex' => 'Format nomor telepon tidak valid. Gunakan hanya angka, +, -, spasi, dan tanda kurung.',
            'nip_nis.required' => 'NIP/NIS wajib diisi untuk role ' . ucfirst($this->role),
        ];
    }

    private function getAllowedRoles(): array
    {
        $currentUser = auth()->user();
        
        if ($currentUser->isAdmin()) {
            return ['admin', 'kepala', 'guru', 'siswa'];
        }
        
        if ($currentUser->isKepala()) {
            return ['guru', 'siswa'];
        }
        
        return ['siswa'];
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->isEditing) {
                $this->user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->role,
                    'nip_nis' => $this->nip_nis,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'status' => $this->status,
                ]);

                if ($this->password) {
                    $this->user->update(['password' => Hash::make($this->password)]);
                }
            } else {
                User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->role,
                    'nip_nis' => $this->nip_nis,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'status' => $this->status,
                    'password' => Hash::make($this->password),
                ]);
            }

            session()->flash('message', 'Pengguna berhasil ' . ($this->isEditing ? 'diperbarui' : 'ditambahkan'));
            return redirect()->route('user-management.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user-management.user-form');
    }
}