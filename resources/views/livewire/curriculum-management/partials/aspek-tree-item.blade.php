@php
    $hasChildren = isset($aspek['children']) && count($aspek['children']) > 0;
    $isExpanded = in_array($aspek['id'], $expandedAspeks ?? []);
@endphp

<div class="border border-gray-200 rounded-lg overflow-hidden">
    <div class="bg-gray-50 px-4 py-3 hover:bg-gray-100 transition-colors duration-150">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3 flex-1">
                <!-- Expand/Collapse Icon -->
                @if($hasChildren)
                    <button wire:click="toggleAspekExpansion({{ $aspek['id'] }})" 
                            class="text-gray-500 hover:text-gray-700 transition-transform duration-200 {{ $isExpanded ? 'rotate-90' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                @else
                    <div class="w-4"></div> <!-- Spacer untuk alignment -->
                @endif

                <!-- Aspek Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-2">
                        <!-- Status Badge -->
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $aspek['status'] === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $aspek['status'] === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        
                        <!-- Type Badge -->
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                            {{ $aspek['tipe'] === 'domain' ? 'bg-blue-100 text-blue-800' : 
                               ($aspek['tipe'] === 'aspek' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800') }}">
                            {{ ucfirst($aspek['tipe']) }}
                        </span>
                        
                        <!-- Bobot Badge -->
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ number_format($aspek['bobot'], 1) }}%
                        </span>
                    </div>
                    
                    <h4 class="text-sm font-medium text-gray-900 mt-1">{{ $aspek['nama_aspek'] }}</h4>
                    
                    <div class="flex items-center space-x-4 mt-1 text-xs text-gray-500">
                        <span>Urutan: {{ $aspek['urutan'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-1 ml-2">
                <!-- Add Sub-Aspek Button -->
                <button wire:click="showAddAspekModal({{ $aspek['id'] }})" 
                        class="text-green-600 hover:text-green-800 p-1" 
                        title="Tambah Sub-Aspek">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
                
                <!-- Edit Button -->
                <button wire:click="showEditAspekModal({{ $aspek['id'] }})" 
                        class="text-blue-600 hover:text-blue-800 p-1" 
                        title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </button>
                
                <!-- Toggle Status Button -->
                <button wire:click="toggleAspekStatus({{ $aspek['id'] }})" 
                        class="{{ $aspek['status'] === 'aktif' ? 'text-yellow-600 hover:text-yellow-800' : 'text-green-600 hover:text-green-800' }} p-1" 
                        title="{{ $aspek['status'] === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                    @if($aspek['status'] === 'aktif')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @endif
                </button>
                
                <!-- Delete Button -->
                <button wire:click="deleteAspek({{ $aspek['id'] }})" 
                        class="text-red-600 hover:text-red-800 p-1" 
                        title="Hapus"
                        onclick="return confirm('Yakin ingin menghapus aspek ini?')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Children Aspek -->
    @if($hasChildren && $isExpanded)
        <div class="border-t border-gray-200 bg-white">
            <div class="pl-6 pr-4 py-2 space-y-2">
                @foreach($aspek['children'] as $childAspek)
                    @include('livewire.curriculum-management.partials.aspek-tree-item', ['aspek' => $childAspek, 'level' => $level + 1])
                @endforeach
            </div>
        </div>
    @endif
</div>
