<div>
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Penilaian Siswa</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Detail lengkap penilaian siswa berdasarkan struktur kurikulum
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('penilaian.history') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('penilaian.edit', $gradeId) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Nilai
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

    @if($gradeData)
        <!-- Student Information Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-16 w-16">
                    <div class="h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                        <span class="text-xl font-medium text-blue-800 dark:text-blue-200">
                            {{ strtoupper(substr($gradeData->siswa->nama_lengkap, 0, 2)) }}
                        </span>
                    </div>
                </div>
                <div class="ml-6">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        {{ $gradeData->siswa->nama_lengkap }}
                    </h3>
                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        <p>NIS: {{ $gradeData->siswa->nis }} | NISN: {{ $gradeData->siswa->nisn ?? 'Tidak ada' }}</p>
                        <p>Kelas: {{ $gradeData->rombel->kelas->tingkat }} - {{ $gradeData->rombel->kelas->nama_kelas }} | Rombel: {{ $gradeData->rombel->nama_rombel }}</p>
                        <p>Mata Pelajaran: {{ $gradeData->mataPelajaran->nama_mapel }} | Semester: {{ $gradeData->semester === 'Ganjil' ? '1' : '2' }} | Tahun Ajaran: {{ $gradeData->tahun_ajaran }}/{{ $gradeData->tahun_ajaran + 1 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Curriculum Information -->
        @if($activeCurriculum)
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Kurikulum: {{ $activeCurriculum->nama_template }}
                        </h3>
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            {{ $activeCurriculum->jenis_kurikulum_text }} - Tahun {{ $activeCurriculum->tahun_berlaku }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Grade Details Table -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Detail Nilai per Aspek</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Nilai detail berdasarkan struktur kurikulum yang aktif
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aspek Penilaian
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tipe
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Bobot
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nilai
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nilai Terbobot
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($aspekPenilaian as $aspek)
                                                    @php
                            // For now, we'll show that no grades have been input yet
                            $nilaiAngka = null;
                            $nilaiTerbobot = 0;
                            $statusNilai = 'Belum Input';
                            $statusColor = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                        @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($aspek->tipe === 'domain')
                                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0V7a2 2 0 00-2-2H5a2 2 0 00-2 2v2"></path>
                                            </svg>
                                        @elseif($aspek->tipe === 'aspek')
                                            <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $aspek->nama_aspek }}
                                            </div>
                                            @if($aspek->parent)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    Parent: {{ $aspek->parent->nama_aspek }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $aspek->tipe === 'domain' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                           ($aspek->tipe === 'aspek' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 
                                           'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200') }}">
                                        {{ ucfirst($aspek->tipe) }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ number_format($aspek->bobot, 1) }}%
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($nilaiAngka !== null)
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ number_format($nilaiAngka, 2) }}
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ number_format($nilaiTerbobot, 2) }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                        {{ $statusNilai }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada aspek penilaian</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Struktur kurikulum belum didefinisikan.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
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
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Aspek</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ count($aspekPenilaian) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

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
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Sudah Input</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">0</dd>
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
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Belum Input</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ count($aspekPenilaian) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Nilai Rata-rata</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ number_format($gradeData->nilai_rata_rata ?? 0, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Progress Input Nilai</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <span>Progress Input</span>
                                                 <span>0 / {{ count($aspekPenilaian) }} (0%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                                 <div class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <span>Nilai Rata-rata</span>
                        <span>{{ number_format($gradeData->nilai_rata_rata ?? 0, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ ($gradeData->nilai_rata_rata ?? 0) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Data tidak ditemukan</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Data penilaian yang dicari tidak ditemukan atau telah dihapus.
            </p>
            <div class="mt-6">
                <a href="{{ route('penilaian.history') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Riwayat
                </a>
            </div>
        </div>
    @endif
</div>
