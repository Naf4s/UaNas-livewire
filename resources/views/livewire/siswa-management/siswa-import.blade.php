<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Import Data Siswa</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Upload file Excel/CSV untuk menambahkan data siswa secara massal
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

        <!-- Import Form -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <form wire:submit="import" class="space-y-6">
                <!-- File Upload -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih File Excel/CSV <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md dark:border-gray-600">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="file" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload file</span>
                                    <input id="file" wire:model="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                XLSX, XLS, atau CSV hingga 2MB
                            </p>
                        </div>
                    </div>
                    @error('file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Import Button -->
                <div class="flex justify-center">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg wire:loading wire:target="import" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <svg wire:loading.remove wire:target="import" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                        </svg>
                        {{ $isImporting ? 'Mengimport...' : 'Mulai Import' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Current Status -->
        @if($currentStatus)
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium text-blue-900 dark:text-blue-100">{{ $currentStatus }}</span>
            </div>
        </div>
        @endif

        <!-- Progress Bar -->
        @if($isImporting)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Progress Import</h3>
            
            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                    <span>Progress</span>
                    <span>{{ number_format($progress, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Rows</p>
                            <p class="text-2xl font-semibold text-blue-900 dark:text-blue-200">{{ $totalRows }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600 dark:text-green-400">Berhasil</p>
                            <p class="text-2xl font-semibold text-green-900 dark:text-green-200">{{ $successRows }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-red-600 dark:text-red-400">Gagal</p>
                            <p class="text-2xl font-semibold text-red-900 dark:text-red-200">{{ $errorRows }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Status -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Memproses baris {{ $processedRows }} dari {{ $totalRows }}
                </p>
            </div>
        </div>
        @endif

        <!-- Error Details -->
        @if(count($errors) > 0)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-red-900 dark:text-red-100 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Detail Error ({{ count($errors) }} baris)
                </h3>
                <button wire:click="clearErrors" 
                        class="inline-flex items-center px-3 py-1 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-900/20 dark:border-red-800 dark:text-red-300 dark:hover:bg-red-900/40">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Clear Errors
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Baris</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Field</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Error</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($errors as $error)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $error['row'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $error['field'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-red-600 dark:text-red-400">
                                {{ $error['message'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Template Download -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Template Excel</h3>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Download template Excel untuk memastikan format data yang benar. Template ini berisi contoh data dan kolom yang diperlukan.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Kolom Wajib:</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <li>• NIS (Nomor Induk Siswa)</li>
                            <li>• nama_lengkap</li>
                            <li>• jenis_kelamin (L/P)</li>
                            <li>• tempat_lahir</li>
                            <li>• tanggal_lahir (YYYY-MM-DD)</li>
                            <li>• agama</li>
                            <li>• alamat</li>
                            <li>• desa_kelurahan</li>
                            <li>• kecamatan</li>
                            <li>• kabupaten_kota</li>
                            <li>• provinsi</li>
                            <li>• tanggal_masuk (YYYY-MM-DD)</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Kolom Opsional:</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <li>• NISN</li>
                            <li>• nama_panggilan</li>
                            <li>• no_hp</li>
                            <li>• nama_ayah</li>
                            <li>• pekerjaan_ayah</li>
                            <li>• no_hp_ayah</li>
                            <li>• nama_ibu</li>
                            <li>• pekerjaan_ibu</li>
                            <li>• no_hp_ibu</li>
                            <li>• nama_wali</li>
                            <li>• pekerjaan_wali</li>
                            <li>• no_hp_wali</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" wire:click="downloadTemplate"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Template Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mt-6">
            <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Petunjuk Import
            </h3>
            
            <div class="text-sm text-blue-800 dark:text-blue-200 space-y-2">
                <p><strong>1. Format File:</strong> Gunakan file Excel (.xlsx, .xls) atau CSV dengan encoding UTF-8</p>
                <p><strong>2. Header Row:</strong> Baris pertama harus berisi nama kolom sesuai template</p>
                <p><strong>3. Data Validation:</strong> Pastikan data sesuai dengan format yang ditentukan</p>
                <p><strong>4. Duplicate Check:</strong> NIS harus unik, tidak boleh duplikat dengan data yang sudah ada</p>
                <p><strong>5. Batch Size:</strong> Disarankan maksimal 1000 baris per import untuk performa optimal</p>
                <p><strong>6. Date Format:</strong> Gunakan format YYYY-MM-DD untuk tanggal lahir dan tanggal masuk</p>
                <p><strong>7. Jenis Kelamin:</strong> Gunakan L untuk Laki-laki atau P untuk Perempuan</p>
            </div>
        </div>
    </div>
</div>
