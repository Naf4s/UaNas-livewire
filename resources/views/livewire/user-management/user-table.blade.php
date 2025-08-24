<div>
    <div class="p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Manajemen Pengguna</h2>
            <div class="flex space-x-2">
                <button wire:click="exportUsers" class="px-4 py-2 text-sm font-medium text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/20 rounded-md hover:bg-green-200 dark:hover:bg-green-900/30">
                    Export CSV
                </button>
                <a href="{{ route('user-management.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 dark:bg-blue-500 rounded-md hover:bg-blue-700 dark:hover:bg-blue-600">
                    Tambah Pengguna
                </a>
            </div>
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

        <!-- Statistics -->
        <div class="grid grid-cols-2 gap-4 mb-6 md:grid-cols-4">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalUsers }}</div>
                <div class="text-sm text-blue-600 dark:text-blue-400">Total Pengguna</div>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $activeUsers }}</div>
                <div class="text-sm text-green-600 dark:text-green-400">Aktif</div>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border border-red-200 dark:border-red-800">
                <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $inactiveUsers }}</div>
                <div class="text-sm text-red-600 dark:text-red-400">Tidak Aktif</div>
            </div>
            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-200 dark:border-purple-800">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $adminUsers + $kepalaUsers + $guruUsers }}</div>
                <div class="text-sm text-purple-600 dark:text-purple-400">Staff</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
            <div>
                <input wire:model.live="search" type="text" placeholder="Cari nama/email/NIP/NIS..." 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400">
            </div>
            <div>
                <select wire:model.live="roleFilter" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="kepala">Kepala Sekolah</option>
                    <option value="guru">Guru</option>
                    <option value="siswa">Siswa</option>
                </select>
            </div>
            <div>
                <select wire:model.live="statusFilter" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('name')">
                            <div class="flex items-center">
                                Nama
                                @if($sortField === 'name')
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('email')">
                            <div class="flex items-center">
                                Email
                                @if($sortField === 'email')
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('role')">
                            <div class="flex items-center">
                                Role
                                @if($sortField === 'role')
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">NIP/NIS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700/50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($user->role === 'admin') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                                @elseif($user->role === 'kepala') bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300
                                @elseif($user->role === 'guru') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                                @else bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $user->nip_nis ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $user->phone ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($user->status === 'active') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                                    @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                                    @endif">
                                    {{ $user->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                                @if($user->id !== auth()->id())
                                    <button wire:click="toggleStatus({{ $user->id }})" 
                                            class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        {{ $user->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="showUserDetails({{ $user->id }})" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 mr-3">Detail</button>
                            <a href="{{ route('user-management.edit', $user->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3">Edit</a>
                            @if($user->id !== auth()->id())
                                <button wire:click="confirmDelete({{ $user->id }})" 
                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Hapus</button>
                            @else
                                <span class="text-gray-400 dark:text-zinc-500">Akun Sendiri</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-zinc-400">
                            Tidak ada data pengguna ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($confirmingDelete)
    <div class="fixed inset-0 bg-gray-600/50 dark:bg-black/50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-zinc-800 border-gray-200 dark:border-zinc-700">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-4">Konfirmasi Hapus</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-zinc-400">
                        Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button wire:click="delete" class="px-4 py-2 bg-red-500 dark:bg-red-600 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 dark:hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 dark:focus:ring-red-500">
                        Hapus
                    </button>
                    <button wire:click="cancelDelete" class="px-4 py-2 bg-gray-500 dark:bg-zinc-600 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-zinc-500">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- User Details Modal -->
    @if($showingUserDetails && $selectedUser)
    <div class="fixed inset-0 bg-gray-600/50 dark:bg-black/50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-2xl shadow-lg rounded-md bg-white dark:bg-zinc-800 max-w-2xl border-gray-200 dark:border-zinc-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Detail Pengguna</h3>
                <button wire:click="closeUserDetails" class="text-gray-400 dark:text-zinc-400 hover:text-gray-600 dark:hover:text-zinc-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Nama Lengkap</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedUser->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Email</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedUser->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Role</label>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-1
                        @if($selectedUser->role === 'admin') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                        @elseif($selectedUser->role === 'kepala') bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300
                        @elseif($selectedUser->role === 'guru') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                        @else bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                        @endif">
                        {{ ucfirst($selectedUser->role) }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">NIP/NIS</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedUser->nip_nis ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Telepon</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedUser->phone ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Status</label>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-1
                        @if($selectedUser->status === 'active') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                        @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                        @endif">
                        {{ $selectedUser->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Alamat</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedUser->address ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Dibuat Pada</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedUser->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Terakhir Diperbarui</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedUser->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button wire:click="closeUserDetails" class="px-4 py-2 bg-gray-500 dark:bg-zinc-600 text-white text-sm font-medium rounded-md hover:bg-gray-600 dark:hover:bg-zinc-700">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
