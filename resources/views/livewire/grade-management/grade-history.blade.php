<div>
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Riwayat Penilaian</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Lihat dan kelola riwayat penilaian siswa yang sudah diinput
                </p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="refreshData" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
                <a href="{{ route('penilaian.input') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Input Nilai Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Filters Section -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Kelas Filter -->
            <div>
                <label for="kelasFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Kelas
                </label>
                <select id="kelasFilter" wire:model.live="selectedKelas" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Mata Pelajaran Filter -->
            <div>
                <label for="mapelFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Mata Pelajaran
                </label>
                <select id="mapelFilter" wire:model.live="selectedMapel" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Semester Filter -->
            <div>
                <label for="semesterFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Semester
                </label>
                <select id="semesterFilter" wire:model.live="selectedSemester" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Semester</option>
                    <option value="Ganjil">Semester Ganjil</option>
                    <option value="Genap">Semester Genap</option>
                </select>
            </div>

            <!-- Tahun Ajaran Filter -->
            <div>
                <label for="tahunAjaranFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tahun Ajaran
                </label>
                <select id="tahunAjaranFilter" wire:model.live="selectedTahunAjaran" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunAjaranList as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}/{{ $tahun + 1 }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <div class="max-w-md">
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Cari Siswa
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="search" wire:model.live="search" 
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       placeholder="Nama atau NIS siswa">
            </div>
        </div>
    </div>

    <!-- Grade History Table -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Siswa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Kelas & Rombel
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Mata Pelajaran
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Semester & Tahun
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Nilai Rata-rata
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Aksi
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($gradeHistory as $grade)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                                    {{ strtoupper(substr($grade->siswa->nama_lengkap, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $grade->siswa->nama_lengkap }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                NIS: {{ $grade->siswa->nis }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $grade->rombel->kelas->tingkat }} - {{ $grade->rombel->kelas->nama_kelas }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $grade->rombel->nama_rombel }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $grade->mataPelajaran->nama_mapel }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $grade->mataPelajaran->kode_mapel }}
                                </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <div class="text-sm text-gray-900 dark:text-white">
                                    Semester {{ $grade->semester === 'Ganjil' ? '1' : '2' }}
                                </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $grade->tahun_ajaran }}/{{ $grade->tahun_ajaran + 1 }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ number_format($grade->nilai_rata_rata, 2) }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $grade->total_aspek }} aspek
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'lengkap' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'belum_lengkap' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'belum_input' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                        ];
                                        $statusText = [
                                            'lengkap' => 'Lengkap',
                                            'belum_lengkap' => 'Belum Lengkap',
                                            'belum_input' => 'Belum Input'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$grade->status_nilai] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusText[$grade->status_nilai] ?? 'Unknown' }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                                                <a href="{{ route('penilaian.detail', $grade->id) }}" 
                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                           title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                                                <a href="{{ route('penilaian.edit', $grade->id) }}" 
                           class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                           title="Edit Nilai">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button wire:click="deleteGrade({{ $grade->id }})" 
                                                onclick="confirm('Apakah Anda yakin ingin menghapus nilai ini?') || event.stopImmediatePropagation()"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada data penilaian</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Mulai dengan menginput nilai siswa baru.
                                        </p>
                                        <div class="mt-6">
                                            <a href="{{ route('penilaian.input') }}" 
                                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Input Nilai Baru
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($gradeHistory->hasPages())
            <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $gradeHistory->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Nilai Lengkap</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['lengkap'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Belum Lengkap</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['belum_lengkap'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Belum Input</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['belum_input'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Siswa</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['total_siswa'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
