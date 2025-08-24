<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Kurikulum</h1>
                <p class="text-gray-600 mt-1">Kelola template kurikulum dan struktur aspek penilaian secara fleksibel</p>
            </div>
            <div class="flex items-center space-x-3">
                <button wire:click="showAddTemplateModal()" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Template Baru
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 rounded-md p-4">
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
        <div class="bg-red-50 border border-red-200 rounded-md p-4">
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

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Template List -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Template Kurikulum</h3>
                </div>
                
                <!-- Search and Filters -->
                <div class="p-4 space-y-3">
                    <div>
                        <input wire:model.live="searchTemplate" type="text" 
                               placeholder="Cari template..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2">
                        <select wire:model.live="jenisKurikulumFilter" 
                                class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Jenis</option>
                            <option value="K13">Kurikulum 2013</option>
                            <option value="Kurikulum Merdeka">Kurikulum Merdeka</option>
                            <option value="Kurikulum 2024">Kurikulum 2024</option>
                        </select>
                        
                        <select wire:model.live="statusFilter" 
                                class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <!-- Template List -->
                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @forelse($templates as $template)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-150 {{ $selectedTemplateId == $template->id ? 'bg-blue-50 border-r-2 border-blue-500' : '' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0 cursor-pointer" wire:click="selectTemplate({{ $template->id }})">
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $template->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $template->status_text }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $template->jenis_kurikulum_text }}
                                        </span>
                                    </div>
                                    <h4 class="text-sm font-medium text-gray-900 mt-1">{{ $template->nama_template }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $template->deskripsi }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Tahun: {{ $template->tahun_berlaku }}</p>
                                </div>
                                
                                <div class="flex items-center space-x-1 ml-2">
                                    <!-- Edit Button -->
                                    <button wire:click="showEditTemplateModal({{ $template->id }})" 
                                            class="text-blue-600 hover:text-blue-800 p-1" 
                                            title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    
                                    @if($template->status !== 'aktif')
                                        <button wire:click="activateTemplate({{ $template->id }})" 
                                                class="text-green-600 hover:text-green-800 p-1" 
                                                title="Aktifkan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    
                                    <button wire:click="deleteTemplate({{ $template->id }})" 
                                            class="text-red-600 hover:text-red-800 p-1" 
                                            title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus template ini?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada template</h3>
                            <p class="mt-1 text-sm text-gray-500">Buat template kurikulum pertama untuk memulai.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($templates->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200">
                        {{ $templates->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Aspek Penilaian Tree -->
        <div class="lg:col-span-2">
            @if($selectedTemplate)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Struktur Aspek Penilaian</h3>
                                <p class="text-sm text-gray-600">{{ $selectedTemplate->nama_template }} - {{ $selectedTemplate->jenis_kurikulum_text }}</p>
                            </div>
                            <button wire:click="showAddAspekModal()" 
                                    class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Aspek
                            </button>
                        </div>
                    </div>

                    <div class="p-4">
                        @if(count($aspekPenilaianTree) > 0)
                            <div class="space-y-2">
                                @foreach($aspekPenilaianTree as $aspek)
                                    @include('livewire.curriculum-management.partials.aspek-tree-item', ['aspek' => $aspek, 'level' => 0])
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aspek penilaian</h3>
                                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan domain atau aspek penilaian.</p>
                                <div class="mt-6">
                                    <button wire:click="showAddAspekModal()" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah Aspek Pertama
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Pilih Template Kurikulum</h3>
                    <p class="mt-1 text-sm text-gray-500">Pilih template dari daftar di sebelah kiri untuk mengelola struktur aspek penilaian.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Template Kurikulum -->
    @if($showTemplateModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $isEditingTemplate ? 'Edit Template Kurikulum' : 'Tambah Template Kurikulum' }}
                        </h3>
                        <button wire:click="closeTemplateModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveTemplate" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Template</label>
                            <input wire:model="nama_template" type="text" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('nama_template') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>



                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kurikulum</label>
                                <select wire:model="jenis_kurikulum" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="K13">Kurikulum 2013</option>
                                    <option value="Kurikulum Merdeka">Kurikulum Merdeka</option>
                                    <option value="Kurikulum 2024">Kurikulum 2024</option>
                                </select>
                                @error('jenis_kurikulum') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tahun Berlaku</label>
                                <input wire:model="tahun_berlaku" type="text" maxlength="4" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('tahun_berlaku') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>



                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" wire:click="closeTemplateModal"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ $isEditingTemplate ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Aspek Penilaian -->
    @if($showAspekModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $isEditingAspek ? 'Edit Aspek Penilaian' : 'Tambah Aspek Penilaian' }}
                        </h3>
                        <button wire:click="closeAspekModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveAspect" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Aspek</label>
                            <input wire:model="nama_aspek" type="text" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('nama_aspek') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>



                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe</label>
                                <select wire:model="tipe" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="domain">Domain</option>
                                    <option value="aspek">Aspek</option>
                                    <option value="indikator">Indikator</option>
                                </select>
                                @error('tipe') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Urutan</label>
                                <input wire:model="urutan" type="number" min="0" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('urutan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bobot (%)</label>
                                <input wire:model="bobot" type="number" step="0.01" min="0" max="100" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('bobot') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select wire:model="status" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Tidak Aktif</option>
                                </select>
                                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if($parentOptions->count() > 0)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Parent Aspek (Opsional)</label>
                                <select wire:model="parent_id"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Tidak ada parent (Root)</option>
                                    @foreach($parentOptions as $option)
                                        <option value="{{ $option->id }}">{{ $option->nama_aspek }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        @endif



                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" wire:click="closeAspekModal"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ $isEditingAspek ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
