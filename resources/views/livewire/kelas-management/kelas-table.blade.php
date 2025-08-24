<div>
    <div class="p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Kelas</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-white">Kelola data kelas dan rombongan belajar</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('kelas.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Kelas
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <input type="text" 
                           id="search" 
                           wire:model.live="search"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400"
                           placeholder="Cari nama kelas...">
                </div>

                <!-- Tingkat Filter -->
                <div>
                    <label for="tingkatFilter" class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                    <select id="tingkatFilter" 
                            wire:model.live="tingkatFilter"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white">
                        <option value="">Semua Tingkat</option>
                        <option value="I">I</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                        <option value="VI">VI</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="statusFilter" 
                            wire:model.live="statusFilter"
                            class= "w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 bg-white dark:bg-zinc-700 text-gray-900 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <!-- Reset Filters -->
                <div class="flex items-end">
                    <button wire:click="$set('search', ''); $set('tingkatFilter', ''); $set('statusFilter', '')"
                            class="w-full px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages -->
        @if (session()->has('message'))
            <div class="px-6 py-4 bg-green-100 border-b border-green-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3-11a1 1 0 10-2 0v2H9a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="px-6 py-4 bg-red-100 border-b border-red-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-800">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Kelas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tingkat
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Rombel
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kelas as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 + ($kelas->currentPage() - 1) * $kelas->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
<div>
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nama_kelas }}</div>
                                    @if($item->deskripsi)
                                        <div class="text-sm text-gray-500">{{ Str::limit($item->deskripsi, 50) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $item->tingkat }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $item->rombel()->count() }} Rombel
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('kelas.edit', $item->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button wire:click="delete({{ $item->id }})" 
                                            wire:confirm="Apakah Anda yakin ingin menghapus kelas ini?"
                                            class="text-red-600 hover:text-red-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 7a2 2 0 012-2h6a2 2 0 012 2v2m14 0V7a2 2 0 00-2-2M5 5a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900 mb-2">Tidak ada data kelas</p>
                                    <p class="text-gray-500">Mulai dengan menambahkan kelas pertama Anda.</p>
                                    <a href="{{ route('kelas.create') }}" 
                                       class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah Kelas Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($kelas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $kelas->links() }}
            </div>
        @endif
    </div>
</div>
