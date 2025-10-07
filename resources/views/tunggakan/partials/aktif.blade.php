<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- LOOPING UNTUK CARD STATISTIK --}}
    @foreach($cards as $card)
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">{{ $card->title }}</p>
            <p class="text-3xl font-bold text-gray-800">{{ $card->value }}</p>
        </div>
        {{-- Menggunakan data icon dari Controller --}}
        <div class="{{ $card->icon_bg }} p-3 rounded-full">
            <svg class="w-6 h-6 {{ $card->icon_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card->icon_path }}"></path>
            </svg>
        </div>
    </div>
    @endforeach
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Siswa Dengan Tunggakan Aktif</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Tunggakan</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lama Tunggakan</th>
                </tr>
            </thead>
            <tbody>
                {{-- LOOPING DATA TUNGGAKAN --}}
                @forelse($duedate_data as $data)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $data->no }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $data->nama }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $data->kelas }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $data->jumlah }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $data->lama }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada data tunggakan aktif.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Pagination akan bekerja jika data dikirim sebagai object Pagination dari Controller --}}
    <div class="mt-4 flex justify-end items-center">
        {{-- ... Kode Pagination statis atau dinamis ... --}}
        <span class="text-gray-600 mr-2">
            <svg class="w-4 h-4 inline-block transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </span>
        <a href="#" class="px-3 py-1 border rounded-md text-gray-700 bg-blue-100 font-semibold">1</a>
        <a href="#" class="px-3 py-1 border rounded-md text-gray-700 hover:bg-gray-100">2</a>
        <span class="text-gray-600 ml-2">
            <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </span>
    </div>
</div>