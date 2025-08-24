<div>
    <!-- Header Section -->
    <div class="mb-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Manajemen Penilaian</h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                Kelola penilaian siswa berdasarkan struktur kurikulum yang fleksibel
            </p>
        </div>
    </div>

    <!-- Navigation Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Input Penilaian Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Input Penilaian</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Input nilai siswa baru</p>
                    </div>
                </div>
                <div class="mt-4">
                                            <a href="{{ route('penilaian.input') }}" 
                           class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Mulai Input
                    </a>
                </div>
            </div>
        </div>

        <!-- Riwayat Penilaian Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Riwayat Penilaian</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Lihat dan kelola nilai</p>
                    </div>
                </div>
                <div class="mt-4">
                                            <a href="{{ route('penilaian.history') }}" 
                           class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>

        <!-- Laporan Penilaian Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Laporan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Generate laporan nilai</p>
                    </div>
                </div>
                <div class="mt-4">
                                            <a href="{{ route('penilaian.report') }}" 
                           class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Buat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Nilai Lengkap</dt>
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
    </div>

    <!-- Recent Activities -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Penilaian yang baru saja diinput atau diupdate</p>
        </div>
        <div class="p-6">
            @if(count($recentActivities) > 0)
                <div class="space-y-4">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $activity->siswa->nama_lengkap }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $activity->mataPelajaran->nama_mapel }} - Semester {{ $activity->semester === 'Ganjil' ? '1' : '2' }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 text-sm text-gray-500 dark:text-gray-400">
                                {{ $activity->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('penilaian.history') }}" 
                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                        Lihat semua aktivitas →
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada aktivitas</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Mulai dengan menginput nilai siswa pertama.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('penilaian.input') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Input Nilai Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('penilaian.import') }}" 
               class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Import Nilai</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Upload nilai dari file Excel</p>
                </div>
            </a>

            <a href="{{ route('penilaian.export') }}" 
               class="relative rounded-lg border border-gray-300 bg-white px-6 py-2 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Export Nilai</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Download nilai dalam format Excel</p>
                </div>
            </a>
        </div>
    </div>
</div>
