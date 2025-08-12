<div class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">
    <div class="container mx-auto py-8 text-gray-900 dark:text-gray-200">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Manajemen Kurikulum</h2>

        {{-- Bagian Notifikasi --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-800 dark:border-green-700 dark:text-green-200 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg wire:click="session()->forget('message')" class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15L6.306 7.354a1.2 1.2 0 1 1 1.697-1.697l2.757 3.153 2.651-3.029a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.15 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 dark:bg-red-800 dark:border-red-700 dark:text-red-200 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg wire:click="session()->forget('error')" class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15L6.306 7.354a1.2 1.2 0 1 1 1.697-1.697l2.757 3.153 2.651-3.029a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.15 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif

        <div class="flex flex-wrap -mx-4">
            {{-- Bagian Template Kurikulum (Kiri) --}}
            <div class="w-full lg:w-1/3 px-4 mb-6 lg:mb-0">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-200">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Template Kurikulum</h3>

                    {{-- Pencarian dan Filter --}}
                    <div class="mb-4">
                        <input type="text" wire:model.live="searchTemplate" placeholder="Cari template..." class="form-input w-full rounded-md shadow-sm bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400">
                    </div>
                    <div class="flex space-x-4 mb-4">
                        <select wire:model.live="jenisKurikulumFilter" class="form-select rounded-md shadow-sm bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                            <option value="">Semua Jenis</option>
                             <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                            <option value="lokal">Lokal</option>
                        </select>
                         <select wire:model.live="statusFilter" class="form-select rounded-md shadow-sm bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    {{-- Tabel Template Kurikulum --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        Nama Template
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($templates as $template)
                                    <tr wire:key="template-{{ $template->id }}" class="{{ $selectedTemplateId == $template->id ? 'bg-blue-50 dark:bg-blue-900' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                <button wire:click="selectTemplate({{ $template->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 focus:outline-none">
                                                     {{ $template->nama_template }}
                                                </button>
                                            </div>
                                        </td>
                                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $template->status === 'aktif' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                                {{ ucfirst($template->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
 <button wire:click="showEditTemplateModal({{ $template->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-2">Edit</button>

                                            @if($template->status === 'nonaktif')
                                                 <button wire:click="activateTemplate({{ $template->id }})" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-600 mr-2">Aktifkan</button>
                                            @else
                                                {{-- Tidak ada tombol nonaktifkan langsung, aktivasi template lain akan menonaktifkan yang aktif saat ini --}}
                                            @endif

                                            @if($template->aspekPenilaian()->count() == 0) {{-- Hanya izinkan hapus jika tidak ada aspek --}}
                                                 <button wire:click="deleteTemplate({{ $template->id }})" wire:confirm="Apakah Anda yakin ingin menghapus template ini? Ini akan menghapus semua aspek penilaian di dalamnya." class="text-red-600 hover:text-red-900">Hapus</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Tidak ada template kurikulum ditemukan.
                                        </td
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                     <div class="mt-4">
                         {{ $templates->links() }}
                     </div>
                    <button wire:click="showCreateTemplateModal" class="mt-4 px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-md shadow hover:bg-blue-700 dark:hover:bg-blue-800">Tambah Template Baru</button>

                </div>
            </div>

            {{-- Bagian Aspek Penilaian (Kanan) --}}
            <div class="w-full lg:w-2/3 px-4">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-200">
                    <h3 class="text-xl font-semibold mb-4">Aspek Penilaian
                         @if($selectedTemplate)
                            - <span class="text-indigo-600">{{ $selectedTemplate->nama_template }}</span>
                         @endif
                    </h3>

                     @if($selectedTemplate)
                         {{-- Tombol Tambah Aspek Root --}}
                        <div class="mb-4 text-right text-gray-900 dark:text-gray-200">
                            <button wire:click="showAddAspekModal()" class="px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-md shadow hover:bg-green-700 dark:hover:bg-green-800">Tambah Aspek Baru (Root)</button>
                        </div>

                        {{-- Struktur Pohon Aspek Penilaian --}}
                        <div class="border rounded-md p-4 border-gray-200 dark:border-gray-700">
                            @forelse ($aspekPenilaianTree as $aspek)
                                @include('livewire.curriculum-management.aspek-item', ['aspek' => $aspek])
                            @empty
                                <p class="text-gray-500 text-center">Pilih template kurikulum atau tambahkan aspek pertama.</p>
                            @endforelse
                        </div>
                     @else
                         <p class="text-gray-500 dark:text-gray-400 text-center">Silakan pilih template kurikulum dari daftar di samping.</p>
                     @endif
                </div>
            </div>
        </div>

        {{-- Modal Tambah/Edit Aspek Penilaian --}}
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" style="display: {{ $showAspekModal ? 'block' : 'none' }};">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <h3 class="text-lg font-semibold mb-4">{{ $isEditingAspek ? 'Edit' : 'Tambah' }} Aspek Penilaian</h3>

                <form wire:submit.prevent="saveAspect">
                    <div class="mb-4">
                        <label for="nama_aspek" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Aspek</label>
                        <input type="text" id="nama_aspek" wire:model="nama_aspek" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        @error('nama_aspek') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                     <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                        <textarea id="deskripsi" wire:model="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        @error('deskripsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe Aspek</label>
                        <select id="tipe" wire:model="tipe" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                            <option value="domain">Domain</option>
                            <option value="aspek">Aspek</option>
                            <option value="indikator">Indikator</option>
                            {{-- Anda mungkin perlu menambahkan tipe input penilaian di sini jika 'tipe' di model AspekPenilaian juga mencakup itu --}}
                            {{-- Atau tambahkan field terpisah untuk tipe input penilaian jika 'tipe' hanya untuk hierarki --}}
                        </select>
                        @error('tipe') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                     {{-- Field Parent Aspek (sembunyikan jika menambah root atau mengedit root) --}}
                     @if (!$isEditingAspek || ($isEditingAspek && $editingAspek?->parent_id))
                         <div class="mb-4">
                             <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Aspek (Opsional)</label>
                             <select id="parent_id" wire:model="parent_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                                 <option value="">Pilih Parent</option>
                                 @foreach($parentOptions as $parentOption)
                                     <option value="{{ $parentOption->id }}">{{ $parentOption->nama_aspek }}</option>
                                 @endforeach
                             </select>
                             @error('parent_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                         </div>
                     @endif


                     <div class="mb-4">
                        <label for="urutan" class="block text-sm font-medium text-gray-700">Urutan</label>
                    <input type="number" id="urutan" wire:model="urutan" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        @error('urutan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                     <div class="mb-4">
                        <label for="bobot" class="block text-sm font-medium text-gray-700">Bobot (%)</label>
                    <input type="number" step="0.01" id="bobot" wire:model="bobot" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        @error('bobot') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                     <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" wire:model="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan (Opsional)</label>
                     <textarea id="catatan" wire:model="catatan" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200"></textarea>
                        @error('catatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="button" wire:click="closeAspekModal" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md shadow hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    {{-- Modal Tambah/Edit Template Kurikulum --}}
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" style="display: {{ $showCreateTemplateModal || $showEditTemplateModal ? 'block' : 'none' }};">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800 dark:border-gray-700 text-gray-900 dark:text-gray-200">
            <h3 class="text-lg font-semibold mb-4">
                {{ $isEditingTemplate ? 'Edit' : 'Tambah' }} Template Kurikulum
            </h3>

            <form wire:submit.prevent="{{ $isEditingTemplate ? 'updateTemplate' : 'saveTemplate' }}">
                <div class="mb-4">
                    <label for="nama_template" class="block text-sm font-medium text-gray-700">Nama Template</label>
                    <input type="text" id="nama_template" wire:model="{{ $isEditingTemplate ? 'nama_template_edit' : 'nama_template_baru' }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                    @error($isEditingTemplate ? 'nama_template_edit' : 'nama_template_baru') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi_template" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi_template" wire:model="{{ $isEditingTemplate ? 'deskripsi_edit' : 'deskripsi_baru' }}" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200"></textarea>
                    @error($isEditingTemplate ? 'deskripsi_edit' : 'deskripsi_baru') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="jenis_kurikulum" class="block text-sm font-medium text-gray-700">Jenis Kurikulum</label>
                    <select id="jenis_kurikulum" wire:model="{{ $isEditingTemplate ? 'jenis_kurikulum_edit' : 'jenis_kurikulum_baru' }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="nasional">Nasional</option>
                        <option value="internasional">Internasional</option>
                        <option value="lokal">Lokal</option>
                    </select>
                    @error($isEditingTemplate ? 'jenis_kurikulum_edit' : 'jenis_kurikulum_baru') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                 @if ($isEditingTemplate)
                    <div class="mb-4">
                        <label for="status_template" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status_template" wire:model="status_template_edit" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                        @error('status_template_edit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                 @endif

                <div class="flex justify-end">
                    <button type="button" wire:click="{{ $isEditingTemplate ? 'closeEditTemplateModal' : 'closeCreateTemplateModal' }}" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md shadow hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
