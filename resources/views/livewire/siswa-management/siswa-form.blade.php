<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $isEditing ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ $isEditing ? 'Perbarui informasi siswa yang sudah ada' : 'Masukkan data lengkap siswa baru' }}
            </p>
        </div>

        <!-- Form -->
        <form wire:submit="save" class="space-y-8">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">1</span>
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Data Pribadi</span>
                        </div>
                        <div class="w-16 h-0.5 bg-gray-300"></div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">2</span>
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Data Keluarga</span>
                        </div>
                        <div class="w-16 h-0.5 bg-gray-300"></div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">3</span>
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Data Sekolah</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 1: Data Pribadi -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Data Pribadi Siswa
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            NIS <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nis" wire:model="nis" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Masukkan NIS">
                        @error('nis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            NISN
                        </label>
                        <input type="text" id="nisn" wire:model="nisn" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Masukkan NISN (opsional)">
                        @error('nisn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="md:col-span-2">
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_lengkap" wire:model="nama_lengkap" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Masukkan nama lengkap sesuai akta kelahiran">
                        @error('nama_lengkap') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nama Panggilan -->
                    <div>
                        <label for="nama_panggilan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Panggilan
                        </label>
                        <input type="text" id="nama_panggilan" wire:model="nama_panggilan" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Nama yang biasa dipanggil">
                        @error('nama_panggilan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select id="jenis_kelamin" wire:model="jenis_kelamin" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tempat Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="tempat_lahir" wire:model="tempat_lahir" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Kota tempat lahir">
                        @error('tempat_lahir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_lahir" wire:model="tanggal_lahir" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('tanggal_lahir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Agama -->
                    <div>
                        <label for="agama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Agama <span class="text-red-500">*</span>
                        </label>
                        <select id="agama" wire:model="agama" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                        @error('agama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- No HP -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            No. HP
                        </label>
                        <input type="tel" id="no_hp" wire:model="no_hp" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="08xxxxxxxxxx">
                        @error('no_hp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    @if(!$isEditing)
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" wire:model="email" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="email@example.com">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" wire:model="password" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Minimal 8 karakter">
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>
            </div>

            <!-- Step 2: Data Keluarga -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Data Keluarga
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Data Ayah -->
                    <div class="space-y-4">
                        <h4 class="font-medium text-gray-900 dark:text-white border-b pb-2">Data Ayah</h4>
                        
                        <div>
                            <label for="nama_ayah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Ayah
                            </label>
                            <input type="text" id="nama_ayah" wire:model="nama_ayah" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Nama lengkap ayah">
                            @error('nama_ayah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pekerjaan Ayah
                            </label>
                            <input type="text" id="pekerjaan_ayah" wire:model="pekerjaan_ayah" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Pekerjaan ayah">
                            @error('pekerjaan_ayah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="no_hp_ayah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                No. HP Ayah
                            </label>
                            <input type="tel" id="no_hp_ayah" wire:model="no_hp_ayah" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="08xxxxxxxxxx">
                            @error('no_hp_ayah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Data Ibu -->
                    <div class="space-y-4">
                        <h4 class="font-medium text-gray-900 dark:text-white border-b pb-2">Data Ibu</h4>
                        
                        <div>
                            <label for="nama_ibu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Ibu
                            </label>
                            <input type="text" id="nama_ibu" wire:model="nama_ibu" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Nama lengkap ibu">
                            @error('nama_ibu') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pekerjaan Ibu
                            </label>
                            <input type="text" id="pekerjaan_ibu" wire:model="pekerjaan_ibu" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Pekerjaan ibu">
                            @error('pekerjaan_ibu') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="no_hp_ibu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                No. HP Ibu
                            </label>
                            <input type="tel" id="no_hp_ibu" wire:model="no_hp_ibu" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="08xxxxxxxxxx">
                            @error('no_hp_ibu') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Data Wali -->
                    <div class="md:col-span-2 space-y-4">
                        <h4 class="font-medium text-gray-900 dark:text-white border-b pb-2">Data Wali (Jika Berbeda)</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_wali" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Wali
                                </label>
                                <input type="text" id="nama_wali" wire:model="nama_wali" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                       placeholder="Nama lengkap wali">
                                @error('nama_wali') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="pekerjaan_wali" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pekerjaan Wali
                                </label>
                                <input type="text" id="pekerjaan_wali" wire:model="pekerjaan_wali" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                       placeholder="Pekerjaan wali">
                                @error('pekerjaan_wali') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="no_hp_wali" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    No. HP Wali
                                </label>
                                <input type="tel" id="no_hp_wali" wire:model="no_hp_wali" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                       placeholder="08xxxxxxxxxx">
                                @error('no_hp_wali') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Data Sekolah & Alamat -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Data Sekolah & Alamat
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat" wire:model="alamat" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                  placeholder="Jalan, nomor rumah, dll"></textarea>
                        @error('alamat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- RT/RW -->
                    <div>
                        <label for="rt_rw" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            RT/RW
                        </label>
                        <input type="text" id="rt_rw" wire:model="rt_rw" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="001/002">
                        @error('rt_rw') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kode Pos -->
                    <div>
                        <label for="kode_pos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kode Pos
                        </label>
                        <input type="text" id="kode_pos" wire:model="kode_pos" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="12345">
                        @error('kode_pos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Desa/Kelurahan -->
                    <div>
                        <label for="desa_kelurahan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Desa/Kelurahan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="desa_kelurahan" wire:model="desa_kelurahan" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Nama desa/kelurahan">
                        @error('desa_kelurahan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kecamatan -->
                    <div>
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kecamatan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="kecamatan" wire:model="kecamatan" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Nama kecamatan">
                        @error('kecamatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kabupaten/Kota -->
                    <div>
                        <label for="kabupaten_kota" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kabupaten/Kota <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="kabupaten_kota" wire:model="kabupaten_kota" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Nama kabupaten/kota">
                        @error('kabupaten_kota') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Provinsi -->
                    <div>
                        <label for="provinsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="provinsi" wire:model="provinsi" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               placeholder="Nama provinsi">
                        @error('provinsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status Siswa -->
                    <div>
                        <label for="status_siswa" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status Siswa <span class="text-red-500">*</span>
                        </label>
                        <select id="status_siswa" wire:model="status_siswa" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Tidak Aktif</option>
                            <option value="lulus">Lulus</option>
                            <option value="pindah">Pindah</option>
                            <option value="keluar">Keluar</option>
                        </select>
                        @error('status_siswa') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tanggal Masuk -->
                    <div>
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Masuk <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_masuk" wire:model="tanggal_masuk" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('tanggal_masuk') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tanggal Keluar -->
                    <div>
                        <label for="tanggal_keluar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Keluar
                        </label>
                        <input type="date" id="tanggal_keluar" wire:model="tanggal_keluar" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('tanggal_keluar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="md:col-span-2">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Keterangan Tambahan
                        </label>
                        <textarea id="keterangan" wire:model="keterangan" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                  placeholder="Informasi tambahan tentang siswa"></textarea>
                        @error('keterangan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('siswa.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>

                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $isEditing ? 'Update Siswa' : 'Simpan Siswa' }}
                </button>
            </div>
        </form>
    </div>
</div>
