<div>
    <div class="p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ $isEditing ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
            </h2>
            <a href="{{ route('user-management.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-zinc-300 bg-gray-100 dark:bg-zinc-700 rounded-md hover:bg-gray-200 dark:hover:bg-zinc-600">
                Kembali
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 rounded">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-400 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Nama Lengkap</label>
                    <input wire:model="name" type="text" id="name" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400">
                    @error('name') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Email</label>
                    <input wire:model="email" type="email" id="email" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400">
                    @error('email') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Role</label>
                    <select wire:model="role" id="role" 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white">
                        @if(auth()->user()->isAdmin())
                            <option value="admin">Admin</option>
                            <option value="kepala">Kepala Sekolah</option>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isKepala())
                            <option value="guru">Guru</option>
                        @endif
                        <option value="siswa">Siswa</option>
                    </select>
                    @error('role') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- NIP/NIS -->
                <div>
                    <label for="nip_nis" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">NIP/NIS</label>
                    <input wire:model="nip_nis" type="text" id="nip_nis" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400">
                    @error('nip_nis') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Telepon</label>
                    <input wire:model="phone" type="text" id="phone" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400">
                    @error('phone') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Status</label>
                    <select wire:model="status" id="status" 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                    @error('status') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Alamat</label>
                <textarea wire:model="address" id="address" rows="3" 
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400"></textarea>
                @error('address') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">
                    {{ $isEditing ? 'Password Baru (kosongkan jika tidak ingin mengubah)' : 'Password' }}
                </label>
                <input wire:model="password" type="password" id="password" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400">
                @error('password') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                @if($isEditing)
                    <p class="mt-1 text-sm text-gray-500 dark:text-zinc-400">Kosongkan field ini jika tidak ingin mengubah password</p>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('user-management.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-zinc-300 bg-gray-100 dark:bg-zinc-700 rounded-md hover:bg-gray-200 dark:hover:bg-zinc-600">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 dark:bg-blue-500 rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                    {{ $isEditing ? 'Update Pengguna' : 'Simpan Pengguna' }}
                </button>
            </div>
        </form>
    </div>
</div>
