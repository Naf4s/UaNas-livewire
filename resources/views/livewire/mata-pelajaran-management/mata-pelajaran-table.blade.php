<div>
    <div class="p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Manajemen Mata Pelajaran</h2>
                    <a href="{{ route('mata-pelajaran.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Mata Pelajaran
                    </a>
                </div>

                <!-- Flash Messages -->
                @if (session()->has('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Search and Filters -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div class="lg:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="search" 
                                       wire:model.live.debounce.300ms="search" 
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Cari nama, kode, atau deskripsi...">
                            </div>
                        </div>

                        <!-- Jenis Filter -->
                        <div>
                            <label for="jenisFilter" class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                            <select id="jenisFilter" 
                                    wire:model.live="jenisFilter" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Jenis</option>
                                @foreach($jenisOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kelompok Filter -->
                        <div>
                            <label for="kelompokFilter" class="block text-sm font-medium text-gray-700 mb-1">Kelompok</label>
                            <select id="kelompokFilter" 
                                    wire:model.live="kelompokFilter" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Kelompok</option>
                                @foreach($kelompokOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="statusFilter" 
                                    wire:model.live="statusFilter" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Status</option>
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Reset Filters Button -->
                    <div class="mt-4 flex justify-end">
                        <button type="button" 
                                wire:click="resetFilters"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Filter
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Mata Pelajaran
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kelompok
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jam/Minggu
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($mataPelajaran as $mapel)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $mapel->kode_mapel }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $mapel->nama_mapel }}</div>
                                        @if($mapel->deskripsi)
                                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ $mapel->deskripsi }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($mapel->jenis === 'Wajib') bg-blue-100 text-blue-800
                                            @elseif($mapel->jenis === 'Peminatan') bg-green-100 text-green-800
                                            @elseif($mapel->jenis === 'Lintas Minat') bg-yellow-100 text-yellow-800
                                            @else bg-purple-100 text-purple-800
                                            @endif">
                                            {{ $mapel->jenis_text }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($mapel->kelompok === 'A') bg-red-100 text-red-800
                                            @elseif($mapel->kelompok === 'B') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ $mapel->kelompok_text }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $mapel->jumlah_jam_text }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($mapel->status === 'aktif') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($mapel->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('mata-pelajaran.edit', $mapel->id) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <button wire:click="toggleStatus({{ $mapel->id }})" 
                                                    class="text-{{ $mapel->status === 'aktif' ? 'yellow' : 'green' }}-600 hover:text-{{ $mapel->status === 'aktif' ? 'yellow' : 'green' }}-900"
                                                    title="{{ $mapel->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($mapel->status === 'aktif')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    @endif
                                                </svg>
                                            </button>
                                            
                                            <button wire:click="delete({{ $mapel->id }})" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')"
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
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center py-8">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900 mb-2">Tidak ada mata pelajaran</p>
                                            <p class="text-gray-500">Mulai dengan menambahkan mata pelajaran pertama Anda.</p>
                                            <a href="{{ route('mata-pelajaran.create') }}" 
                                               class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Tambah Mata Pelajaran
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($mataPelajaran->hasPages())
                    <div class="mt-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <label for="perPage" class="text-sm text-gray-700">Tampilkan:</label>
                                <select id="perPage" 
                                        wire:model.live="perPage" 
                                        class="border border-gray-300 rounded-md px-2 py-1 text-sm">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <span class="text-sm text-gray-700">per halaman</span>
                            </div>
                            
                            <div class="text-sm text-gray-700">
                                Menampilkan {{ $mataPelajaran->firstItem() ?? 0 }} - {{ $mataPelajaran->lastItem() ?? 0 }} dari {{ $mataPelajaran->total() }} mata pelajaran
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            {{ $mataPelajaran->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
