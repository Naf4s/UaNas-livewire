<div>
    <h2 class="text-xl font-bold mb-4">Rekapitulasi Nilai Siswa per Kelas</h2>
    <div class="mb-4">
        <label for="kelas" class="block mb-1">Pilih Kelas:</label>
        <select wire:model="kelasId" id="kelas" class="border rounded p-2 w-full max-w-xs">
            @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead>
                <tr>
                    <th class="border px-2 py-1">No</th>
                    <th class="border px-2 py-1">Nama Siswa</th>
                    @foreach($mataPelajaran as $mapel)
                        <th class="border px-2 py-1">{{ $mapel->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($rekap as $i => $row)
                    <tr>
                        <td class="border px-2 py-1">{{ $i+1 }}</td>
                        <td class="border px-2 py-1">{{ $row['siswa']->nama }}</td>
                        @foreach($mataPelajaran as $mapel)
                            <td class="border px-2 py-1 text-center">{{ $row['nilai'][$mapel->id] }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <style>
        @media print {
            body * { visibility: hidden; }
            #app, #app * { visibility: visible; }
            select, label, h2 { display: none !important; }
            table { page-break-inside: avoid; }
        }
    </style>
</div>
