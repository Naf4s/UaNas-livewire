<?php

namespace App\Livewire\UserManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;

class UserForm extends Component
{
    public User $user;
    public $isEditing = false;

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|email|unique:users,email')]
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

    #[Rule('required|min:8')]
    public $password = '';

    public function mount($userId = null)
    {
        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->isEditing = true;
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->role = $this->user->role;
            $this->nip_nis = $this->user->nip_nis;
            $this->phone = $this->user->phone;
            $this->address = $this->user->address;
            $this->status = $this->user->status;
            $this->password = '';
        } else {
            $this->user = new User();
        }
    }

    public function save()
    {
        $this->validate();

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
    }

    public function render()
    {
        return view('livewire.user-management.user-form');
    }
}