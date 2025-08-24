<x-layouts.app.sidebar title="Edit Rombongan Belajar">
    <flux:main>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @livewire('rombel-management.rombel-form', ['rombelId' => $rombel->id])
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>
