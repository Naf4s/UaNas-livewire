<div>
    <h2 class="text-xl font-bold mb-4">Validasi Usulan Kenaikan Kelas</h2>
    @if(session()->has('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead>
                <tr>
                    <th class="border px-2 py-1">No</th>
                    <th class="border px-2 py-1">Nama Siswa</th>
                    <th class="border px-2 py-1">Kelas Asal</th>
                    <th class="border px-2 py-1">Kelas Tujuan</th>
                    <th class="border px-2 py-1">Status</th>
                    <th class="border px-2 py-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usulanList as $i => $usulan)
                    <tr>
                        <td class="border px-2 py-1">{{ $i+1 }}</td>
                        <td class="border px-2 py-1">{{ $usulan->siswa->nama ?? '-' }}</td>
                        <td class="border px-2 py-1">{{ $usulan->kelas_asal->nama ?? '-' }}</td>
                        <td class="border px-2 py-1">{{ $usulan->kelas_tujuan->nama ?? '-' }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $usulan->status }}</td>
                        <td class="border px-2 py-1">
                            @if($usulan->status === 'menunggu')
                                <button wire:click="validasi({{ $usulan->id }})" class="bg-green-600 text-white px-2 py-1 rounded mr-1">Validasi</button>
                                <button wire:click="tolak({{ $usulan->id }})" class="bg-red-600 text-white px-2 py-1 rounded">Tolak</button>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border px-2 py-2 text-center text-gray-500">Tidak ada usulan kenaikan kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
