<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $isEditing ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran Baru' }}
                    </h2>
                    <a href="{{ route('mata-pelajaran.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>

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

                <form wire:submit="save" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kode Mata Pelajaran -->
                        <div>
                            <label for="kode_mapel" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="kode_mapel" 
                                   wire:model="kode_mapel" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('kode_mapel') border-red-500 @enderror"
                                   placeholder="Contoh: MAT001"
                                   maxlength="10">
                            @error('kode_mapel')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Maksimal 10 karakter, akan otomatis diubah ke huruf besar</p>
                        </div>

                        <!-- Nama Mata Pelajaran -->
                        <div>
                            <label for="nama_mapel" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_mapel" 
                                   wire:model="nama_mapel" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('nama_mapel') border-red-500 @enderror"
                                   placeholder="Contoh: Matematika">
                            @error('nama_mapel')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Mata Pelajaran -->
                        <div>
                            <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <select id="jenis" 
                                    wire:model="jenis" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('jenis') border-red-500 @enderror">
                                <option value="Wajib">Mata Pelajaran Wajib</option>
                                <option value="Peminatan">Mata Pelajaran Peminatan</option>
                                <option value="Lintas Minat">Mata Pelajaran Lintas Minat</option>
                                <option value="Muatan Lokal">Mata Pelajaran Muatan Lokal</option>
                            </select>
                            @error('jenis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelompok -->
                        <div>
                            <label for="kelompok" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelompok <span class="text-red-500">*</span>
                            </label>
                            <select id="kelompok" 
                                    wire:model="kelompok" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('kelompok') border-red-500 @enderror">
                                <option value="A">Kelompok A (Wajib)</option>
                                <option value="B">Kelompok B (Wajib)</option>
                                <option value="C">Kelompok C (Peminatan)</option>
                            </select>
                            @error('kelompok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Kelompok akan otomatis disesuaikan dengan jenis mata pelajaran</p>
                        </div>

                        <!-- Jumlah Jam -->
                        <div>
                            <label for="jumlah_jam" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Jam per Minggu <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="jumlah_jam" 
                                   wire:model="jumlah_jam" 
                                   min="1" 
                                   max="10"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('jumlah_jam') border-red-500 @enderror">
                            @error('jumlah_jam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Minimal 1 jam, maksimal 10 jam per minggu</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" 
                                    wire:model="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Mata Pelajaran
                        </label>
                        <textarea id="deskripsi" 
                                  wire:model="deskripsi" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('deskripsi') border-red-500 @enderror"
                                  placeholder="Deskripsi singkat tentang mata pelajaran ini..."></textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Maksimal 500 karakter</p>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea id="catatan" 
                                  wire:model="catatan" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('catatan') border-red-500 @enderror"
                                  placeholder="Catatan khusus atau informasi tambahan..."></textarea>
                        @error('catatan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Maksimal 1000 karakter</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <button type="button" 
                                wire:click="cancel"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Batal
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $isEditing ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
