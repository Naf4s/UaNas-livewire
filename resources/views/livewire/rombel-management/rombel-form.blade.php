<div class="p-6 bg-white rounded-lg shadow-sm">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ $isEditing ? 'Edit Rombongan Belajar' : 'Tambah Rombongan Belajar Baru' }}
                </h2>
                <p class="text-gray-600 mt-1">
                    {{ $isEditing ? 'Perbarui informasi rombongan belajar' : 'Buat rombongan belajar baru untuk siswa' }}
                </p>
            </div>
            <a href="{{ route('rombel.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 rounded-md bg-green-50 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 rounded-md bg-red-50 border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kelas -->
            <div>
                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Kelas <span class="text-red-500">*</span>
                </label>
                <select wire:model="kelas_id" id="kelas_id" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('kelas_id') border-red-300 @enderror">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} ({{ $k->tingkat }})
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kode Rombel -->
            <div>
                <label for="kode_rombel" class="block text-sm font-medium text-gray-700 mb-2">
                    Kode Rombel <span class="text-red-500">*</span>
                </label>
                <input wire:model="kode_rombel" type="text" id="kode_rombel" 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('kode_rombel') border-red-300 @enderror"
                       placeholder="Contoh: X-IPA-1">
                @error('kode_rombel')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Rombel -->
            <div>
                <label for="nama_rombel" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Rombel <span class="text-red-500">*</span>
                </label>
                <input wire:model="nama_rombel" type="text" id="nama_rombel" 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('nama_rombel') border-red-300 @enderror"
                       placeholder="Contoh: X IPA 1">
                @error('nama_rombel')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kapasitas -->
            <div>
                <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-2">
                    Kapasitas Maksimal <span class="text-red-500">*</span>
                </label>
                <input wire:model="kapasitas" type="number" id="kapasitas" min="1" max="100"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('kapasitas') border-red-300 @enderror"
                       placeholder="40">
                @error('kapasitas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Jumlah maksimal siswa yang dapat ditampung</p>
            </div>

            <!-- Wali Kelas -->
            <div>
                <label for="wali_kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Wali Kelas
                </label>
                <select wire:model="wali_kelas_id" id="wali_kelas_id" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('wali_kelas_id') border-red-300 @enderror">
                    <option value="">Pilih Wali Kelas</option>
                    @foreach($guru as $g)
                        <option value="{{ $g->id }}" {{ $wali_kelas_id == $g->id ? 'selected' : '' }}>
                            {{ $g->name }} ({{ ucfirst($g->role) }})
                        </option>
                    @endforeach
                </select>
                @error('wali_kelas_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Guru yang bertanggung jawab atas rombel ini</p>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select wire:model="status" id="status" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('status') border-red-300 @enderror">
                    <option value="aktif" {{ $status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi
            </label>
            <textarea wire:model="deskripsi" id="deskripsi" rows="3"
                      class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('deskripsi') border-red-300 @enderror"
                      placeholder="Tambahkan deskripsi atau catatan tambahan tentang rombel ini..."></textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
            <a href="{{ route('rombel.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Batal
            </a>
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg wire:loading.remove wire:target="save" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span wire:loading.remove wire:target="save">{{ $isEditing ? 'Perbarui' : 'Simpan' }}</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
