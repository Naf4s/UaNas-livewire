<div>
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Input Penilaian Siswa</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Input nilai siswa berdasarkan struktur kurikulum yang aktif
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
                <button wire:click="exportNilai" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Excel
                </button>
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

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Filters Section -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Kelas Filter -->
            <div>
                <label for="kelasFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Kelas
                </label>
                <select id="kelasFilter" wire:model.live="selectedKelas" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Rombel Filter -->
            <div>
                <label for="rombelFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Rombel
                </label>
                <select id="rombelFilter" wire:model.live="selectedRombel" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Pilih Rombel</option>
                    @foreach($rombelList as $rombel)
                        <option value="{{ $rombel->id }}">{{ $rombel->nama_rombel }}</option>
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
                    <option value="">Pilih Mapel</option>
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
                    <option value="">Pilih Semester</option>
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
                    <option value="">Pilih Tahun</option>
                    @foreach($tahunAjaranList as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}/{{ $tahun + 1 }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Kurikulum Info -->
    @if($activeCurriculum)
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        Kurikulum Aktif: {{ $activeCurriculum->nama_template }}
                    </h3>
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        {{ $activeCurriculum->jenis_kurikulum_text }} - Tahun {{ $activeCurriculum->tahun_berlaku }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Input Penilaian Table -->
    @if($selectedKelas && $selectedRombel && $selectedMapel && $selectedSemester && $selectedTahunAjaran)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Input Nilai Siswa</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $selectedKelasText }} - {{ $selectedRombelText }} - {{ $selectedMapelText }}
                            <br>
                            Semester {{ $selectedSemester }} - Tahun Ajaran {{ $selectedTahunAjaran }}/{{ $selectedTahunAjaran + 1 }}
                        </p>
                    </div>
                    <button wire:click="saveAllNilai" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Semua Nilai
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Siswa
                            </th>
                            @foreach($aspekPenilaian as $aspek)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <div class="text-center">
                                        <div class="font-medium">{{ $aspek->nama_aspek }}</div>
                                        <div class="text-xs text-gray-400">{{ $aspek->tipe }}</div>
                                        <div class="text-xs text-blue-600">{{ number_format($aspek->bobot, 1) }}%</div>
                                    </div>
                                </th>
                            @endforeach
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Rata-rata
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($siswaList as $siswa)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $siswa->nama_lengkap }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                NIS: {{ $siswa->nis }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                @foreach($aspekPenilaian as $aspek)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center">
                                            <input type="number" 
                                                   wire:model.live="nilaiSiswa.{{ $siswa->id }}.{{ $aspek->id }}"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 text-center border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                   placeholder="0-100">
                                        </div>
                                    </td>
                                @endforeach
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ number_format($this->hitungRataRata($siswa->id), 2) }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($aspekPenilaian) + 2 }}" class="px-6 py-12 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada siswa</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Pilih kelas, rombel, dan mata pelajaran untuk menampilkan daftar siswa.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button wire:click="generateRapor" 
                       class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Generate Rapor</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Buat rapor nilai siswa</p>
                    </div>
                </button>

                <button wire:click="exportNilai" 
                       class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Export Excel</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Download nilai dalam Excel</p>
                    </div>
                </button>

                <button wire:click="resetForm" 
                       class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Reset Form</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kosongkan semua input</p>
                    </div>
                </button>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Filter untuk Memulai</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Pilih kelas, rombel, mata pelajaran, semester, dan tahun ajaran untuk menampilkan form input penilaian.
            </p>
        </div>
    @endif

    <!-- Loading Indicator -->
    <div wire:loading class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <div class="bg-white rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <svg class="animate-spin h-8 w-8 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-lg font-medium text-gray-900">Memproses...</span>
                </div>
            </div>
        </div>
    </div>
</div>
