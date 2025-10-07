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
                </tr>
            </thead>
            <tbody>
                {{-- LOOPING DATA PEMBAYARAN RIWAYAT --}}
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
                            {{ $data->status == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $data->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="py-4 text-center text-gray-500">Tidak ada data riwayat pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>