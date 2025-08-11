<div>
    <h2 class="text-xl font-bold mb-4">Cetak Rapor Siswa</h2>
    <div class="mb-4">
        <label for="siswa" class="block mb-1">Pilih Siswa:</label>
        <select wire:model="selectedSiswaId" id="siswa" class="border rounded p-2 w-full">
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswaList as $siswa)
                <option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->kelas->nama ?? '-' }})</option>
            @endforeach
        </select>
    </div>
    @if($reportData)
        <div id="rapor-area" class="bg-white p-6 rounded shadow mb-4">
            <h3 class="text-lg font-semibold mb-2">Rapor Siswa</h3>
            <p><strong>Nama:</strong> {{ $reportData['siswa']->nama }}</p>
            <p><strong>Kelas:</strong> {{ $reportData['kelas']->nama ?? '-' }}</p>
            <p><strong>Rombel:</strong> 
                @foreach($reportData['rombels'] as $rombel)
                    {{ $rombel->nama }}@if(!$loop->last), @endif
                @endforeach
            </p>
            <table class="w-full mt-4 border">
                <thead>
                    <tr>
                        <th class="border px-2 py-1">Mata Pelajaran</th>
                        <th class="border px-2 py-1">Nilai</th>
                        <th class="border px-2 py-1">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData['nilai'] as $nilai)
                        <tr>
                            <td class="border px-2 py-1">{{ $nilai['mata_pelajaran'] }}</td>
                            <td class="border px-2 py-1">{{ $nilai['nilai'] }}</td>
                            <td class="border px-2 py-1">{{ $nilai['keterangan'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded">Cetak Rapor</button>
    @endif

    <style>
        @media print {
            body * { visibility: hidden; }
            #rapor-area, #rapor-area * { visibility: visible; }
            #rapor-area { position: absolute; left: 0; top: 0; width: 100%; }
            button, select, label, h2 { display: none !important; }
        }
    </style>
</div>
