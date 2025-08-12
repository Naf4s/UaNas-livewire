<div class="ml-4 border-l pl-4 my-2">
    <div class="flex items-center justify-between py-2 border-b last:border-b-0">
        <div class="flex-1">
            <div class="font-semibold text-gray-800 flex flex-wrap items-center gap-2">
 {{ $aspek['nama_aspek'] }}
                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $aspek['status'] === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($aspek['status']) }}
                </span>
            </div>
            <div class="text-sm text-gray-600">{{ ucfirst($aspek['tipe']) }} - Bobot: {{ $aspek['bobot'] }}%</div>
 @if ($aspek['deskripsi'])
                <div class="text-xs text-gray-500 italic mt-1">{{ $aspek['deskripsi'] }}</div>
 @endif
        </div>
        <div class="flex space-x-2 text-sm ml-4 flex-shrink-0">
             @if ($aspek['tipe'] !== 'indikator') {{-- Assuming 'indikator' is the lowest level and cannot have children --}}
                <button wire:click="showAddAspekModal({{ $aspek['id'] }})" class="text-green-600 hover:text-green-900">Tambah Sub</button>
             @endif
            <button wire:click="showEditAspekModal({{ $aspek['id'] }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
            <button wire:click="deleteAspek({{ $aspek['id'] }})" wire:confirm="Apakah Anda yakin ingin menghapus aspek ini dan semua sub-aspek di dalamnya?" class="text-red-600 hover:text-red-900">Hapus</button>
            <button wire:click="toggleAspekStatus({{ $aspek['id'] }})" class="text-yellow-600 hover:text-yellow-900">{{ $aspek['status'] === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
        </div>
    </div>

    @if (isset($aspek['all_children']) && count($aspek['all_children']) > 0)
        <div>
            @foreach ($aspek['all_children'] as $childAspek)
                @include('livewire.curriculum-management.aspek-item', ['aspek' => $childAspek])
            @endforeach
        </div>
    @endif
</div>