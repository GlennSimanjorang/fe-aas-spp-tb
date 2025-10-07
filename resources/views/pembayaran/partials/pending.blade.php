<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- LOOPING UNTUK CARD STATISTIK --}}
    @foreach($cards as $card)
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">{{ $card->title }}</p>
            <p class="text-3xl font-bold text-gray-800">{{ $card->value }}</p>
        </div>
        {{-- Logika sederhana untuk ikon berdasarkan title --}}
        <div class="bg-yellow-100 p-3 rounded-full">
            @if($card->title == 'Menunggu Konfirmasi')
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            @elseif($card->title == 'Total Nilai Pending')
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zM4 17a1 1 0 011-1h14a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3z"></path></svg>
            @else
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M16 11h.01M19 5h-4V3a1 1 0 00-1-1H7a1 1 0 00-1 1v2H3a2 2 0 00-2 2v10a2 2 0 002 2h18a2 2 0 002-2V7a2 2 0 00-2-2z"></path></svg>
            @endif
        </div>
    </div>
    @endforeach
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <input type="text" placeholder="Cari Siswa, Nis" class="p-2 border rounded-md">
        <div class="flex space-x-2">
            <select class="p-2 border rounded-md">
                <option>Semua Siswa</option>
            </select>
            <select class="p-2 border rounded-md">
                <option>Semua Metode</option>
            </select>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-50">
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><input type="checkbox"></th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu</th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nis</th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Periode</th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Metode</th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bukti</th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- LOOPING DATA PEMBAYARAN --}}
                @forelse($payment_data as $data)
                <tr class="border-b border-gray-200">
                    <td class="py-2 px-4"><input type="checkbox"></td>
                    <td class="py-2 px-4">{{ $data->waktu }}</td>
                    <td class="py-2 px-4">{{ $data->nis }}</td>
                    <td class="py-2 px-4">{{ $data->nama }}</td>
                    <td class="py-2 px-4">{{ $data->kelas }}</td>
                    <td class="py-2 px-4">{{ $data->periode }}</td>
                    <td class="py-2 px-4">{{ $data->jumlah }}</td>
                    <td class="py-2 px-4">{{ $data->metode }}</td>
                    <td class="py-2 px-4">{{ $data->bukti }}</td>
                    <td class="py-2 px-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $data->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ $data->status }}
                        </span>
                    </td>
                    <td class="py-2 px-4">
                        <button class="bg-blue-600 text-white text-xs px-2 py-1 rounded-md">Lihat Bukti</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="py-4 text-center text-gray-500">Tidak ada data pembayaran yang menunggu konfirmasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>