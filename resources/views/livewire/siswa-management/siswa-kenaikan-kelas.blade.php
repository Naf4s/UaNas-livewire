<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Kenaikan Kelas Siswa</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Proses kenaikan kelas siswa dari kelas asal ke kelas tujuan
                    </p>
                </div>
                <a href="{{ route('siswa.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Siswa
                </a>
            </div>
        </div>

        <!-- Configuration Form -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Konfigurasi Kenaikan Kelas
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Tahun Ajaran -->
                <div>
                    <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="tahun_ajaran" wire:model="tahun_ajaran" min="2020" max="2030"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                           placeholder="2024">
                    @error('tahun_ajaran') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Semester -->
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Semester <span class="text-red-500">*</span>
                    </label>
                    <select id="semester" wire:model="semester" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Pilih Semester</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                    @error('semester') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Kelas Asal -->
                <div>
                    <label for="kelas_asal_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kelas Asal <span class="text-red-500">*</span>
                    </label>
                    <select id="kelas_asal_id" wire:model="kelas_asal_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Pilih Kelas Asal</option>
                        @foreach(\App\Models\Kelas::where('status', 'aktif')->orderBy('tingkat')->get() as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_asal_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Kelas Tujuan -->
                <div>
                    <label for="kelas_tujuan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kelas Tujuan <span class="text-red-500">*</span>
                    </label>
                    <select id="kelas_tujuan_id" wire:model="kelas_tujuan_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Pilih Kelas Tujuan</option>
                        @foreach(\App\Models\Kelas::where('status', 'aktif')->orderBy('tingkat')->get() as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->tingkat }} - {{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_tujuan_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Load Students Button -->
            <div class="mt-6 flex justify-center">
                <button type="button" wire:click="loadSiswa" 
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Muat Daftar Siswa
                </button>
            </div>
        </div>

        <!-- Student List -->
        @if(count($siswaList) > 0)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Daftar Siswa ({{ count($siswaList) }})
                </h3>
                
                <div class="flex space-x-3">
                    <button type="button" wire:click="selectAll" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Pilih Semua
                    </button>
                    <button type="button" wire:click="unselectAll" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal Pilih
                    </button>
                </div>
            </div>

            <!-- Student Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <input type="checkbox" 
                                       wire:model="selectAll" 
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Siswa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                NIS/NISN
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Rombel Saat Ini
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($siswaList as $siswa)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" 
                                       wire:model="selectedSiswa" 
                                       value="{{ $siswa->id }}"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </td>
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
                                            {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ $siswa->umur }} tahun
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $siswa->nis }}</div>
                                @if($siswa->nisn)
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $siswa->nisn }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($siswa->rombel->count() > 0)
                                    @foreach($siswa->rombel as $rombel)
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $rombel->kelas->tingkat }} - {{ $rombel->nama_rombel }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $rombel->pivot->tahun_ajaran }}/{{ $rombel->pivot->semester }}
                                    </div>
                                    @endforeach
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Belum ada rombel</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'aktif' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'nonaktif' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        'lulus' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'pindah' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'keluar' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$siswa->status_siswa] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $siswa->status_siswa_text }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Process Button -->
            <div class="mt-6 flex justify-center">
                <button type="button" wire:click="processKenaikanKelas" 
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-8 py-3 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg wire:loading wire:target="processKenaikanKelas" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg wire:loading.remove wire:target="processKenaikanKelas" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Proses Kenaikan Kelas ({{ count($selectedSiswa) }} siswa)
                </button>
            </div>
        </div>
        @endif

        <!-- Progress Processing -->
        @if($isProcessing)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Memproses Kenaikan Kelas
            </h3>
            
            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                    <span>Progress</span>
                    <span>{{ $progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-green-600 h-2.5 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                </div>
            </div>

            <!-- Current Status -->
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Memproses siswa {{ $processedSiswa }} dari {{ $totalSiswa }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                    Mohon tunggu, jangan tutup halaman ini
                </p>
            </div>
        </div>
        @endif

        <!-- Summary Information -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Informasi Penting
            </h3>
            
            <div class="text-sm text-blue-800 dark:text-blue-200 space-y-2">
                <p><strong>• Backup Data:</strong> Pastikan data sudah di-backup sebelum melakukan kenaikan kelas</p>
                <p><strong>• Validasi:</strong> Sistem akan memvalidasi data siswa sebelum diproses</p>
                <p><strong>• Rombel:</strong> Siswa akan dipindahkan ke rombel yang sesuai di kelas tujuan</p>
                <p><strong>• Status:</strong> Rombel lama akan dinonaktifkan, rombel baru akan diaktifkan</p>
                <p><strong>• Rollback:</strong> Jika terjadi error, proses dapat di-rollback secara manual</p>
            </div>
        </div>
    </div>
</div>
