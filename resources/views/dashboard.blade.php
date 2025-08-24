<x-layouts.app :title="__('Dashboard Admin')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <!-- Header Dashboard -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Admin</h1>
                <p class="text-gray-600 dark:text-gray-400">Selamat datang di Sistem Manajemen Akademik</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('l, d F Y') }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('H:i') }} WIB</p>
            </div>
        </div>

        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Siswa -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Siswa</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Siswa::count() }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                        <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Aktif
                    </span>
                </div>
            </div>

            <!-- Total Kelas -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Kelas</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Kelas::count() }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Tersedia
                    </span>
                </div>
            </div>

            <!-- Total Mata Pelajaran -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Mata Pelajaran</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\MataPelajaran::count() }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                        <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Aktif
                    </span>
                </div>
            </div>

            <!-- Total Rombel -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-900">
                        <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Rombel</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Rombel::count() }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="inline-flex items-center rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                        <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Grafik dan Statistik Detail -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Statistik Absensi Hari Ini -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Statistik Absensi Hari Ini</h3>
                <div class="space-y-4">
                    @php
                        $today = now()->format('Y-m-d');
                        $hadir = \App\Models\Absensi::where('tanggal', $today)->where('status', 'hadir')->count();
                        $sakit = \App\Models\Absensi::where('tanggal', $today)->where('status', 'sakit')->count();
                        $izin = \App\Models\Absensi::where('tanggal', $today)->where('status', 'izin')->count();
                        $alpha = \App\Models\Absensi::where('tanggal', $today)->where('status', 'alpha')->count();
                        $total = $hadir + $sakit + $izin + $alpha;
                        $persentaseHadir = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;
                    @endphp
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Hadir</span>
                        <span class="text-sm font-semibold text-green-600">{{ $hadir }} ({{ $persentaseHadir }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $persentaseHadir }}%"></div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-blue-600">{{ $sakit }}</div>
                            <div class="text-xs text-gray-500">Sakit</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-yellow-600">{{ $izin }}</div>
                            <div class="text-xs text-gray-500">Izin</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-red-600">{{ $alpha }}</div>
                            <div class="text-xs text-gray-500">Alpha</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Penilaian -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Statistik Penilaian</h3>
                <div class="space-y-4">
                    @php
                        $totalNilai = \App\Models\Grade::count();
                        $nilaiTinggi = \App\Models\Grade::where('nilai', '>=', 85)->count();
                        $nilaiSedang = \App\Models\Grade::whereBetween('nilai', [70, 84])->count();
                        $nilaiRendah = \App\Models\Grade::where('nilai', '<', 70)->count();
                    @endphp
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $totalNilai }}</div>
                        <div class="text-sm text-gray-500">Total Nilai</div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-xl font-bold text-green-600">{{ $nilaiTinggi }}</div>
                            <div class="text-xs text-gray-500">≥85</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-yellow-600">{{ $nilaiSedang }}</div>
                            <div class="text-xs text-gray-500">70-84</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-red-600">{{ $nilaiRendah }}</div>
                            <div class="text-xs text-gray-500"><70</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Aktivitas Terbaru -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $recentActivities = collect();
                        
                        // Recent absensi
                        $recentAbsensi = \App\Models\Absensi::with('siswa')->latest('tanggal')->take(5)->get();
                        foreach($recentAbsensi as $absensi) {
                            $recentActivities->push([
                                'type' => 'absensi',
                                'message' => "Siswa {$absensi->siswa->nama} {$absensi->status} pada " . $absensi->tanggal->format('d/m/Y'),
                                'time' => $absensi->tanggal,
                                'icon' => 'calendar',
                                'color' => 'blue'
                            ]);
                        }
                        
                        // Recent grades
                        $recentGrades = \App\Models\Grade::with(['siswa', 'mataPelajaran'])->latest()->take(5)->get();
                        foreach($recentGrades as $grade) {
                            $recentActivities->push([
                                'type' => 'grade',
                                'message' => "Nilai {$grade->nilai} untuk {$grade->siswa->nama} - {$grade->mataPelajaran->nama}",
                                'time' => $grade->created_at,
                                'icon' => 'academic-cap',
                                'color' => 'green'
                            ]);
                        }
                        
                        $recentActivities = $recentActivities->sortByDesc('time')->take(8);
                    @endphp
                    
                    @foreach($recentActivities as $activity)
                    <div class="flex items-center space-x-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-900">
                            <svg class="h-4 w-4 text-{{ $activity['color'] }}-600 dark:text-{{ $activity['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($activity['icon'] == 'calendar')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                @elseif($activity['icon'] == 'academic-cap')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                @endif
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900 dark:text-white">{{ $activity['message'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['time']->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <a href="{{ route('siswa.index') }}" class="flex flex-col items-center rounded-lg border border-gray-200 p-4 text-center hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700">
                    <svg class="mb-2 h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Kelola Siswa</span>
                </a>
                
                <a href="{{ route('kelas.index') }}" class="flex flex-col items-center rounded-lg border border-gray-200 p-4 text-center hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700">
                    <svg class="mb-2 h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Kelola Kelas</span>
                </a>
                
                <a href="{{ route('mata-pelajaran.index') }}" class="flex flex-col items-center rounded-lg border border-gray-200 p-4 text-center hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700">
                    <svg class="mb-2 h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Mata Pelajaran</span>
                </a>
                
                <a href="{{ route('penilaian.input') }}" class="flex flex-col items-center rounded-lg border border-gray-200 p-4 text-center hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700">
                    <svg class="mb-2 h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Input Nilai</span>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
