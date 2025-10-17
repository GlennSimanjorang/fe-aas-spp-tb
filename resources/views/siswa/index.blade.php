@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#4A3AFF] to-[#6A5BFF] text-white rounded-xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl md:text-3xl font-bold mb-1">Data Siswa</h1>
                <p class="text-sm opacity-90">Data Siswa/i SMK Taruna Bhakti</p>
            </div>
        </div>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($cards as $card)
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-gray-700">{{ $card->title }}</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $card->value }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-sm text-gray-500 flex items-center">
                    <span class="text-green-500 flex items-center">
                        {{ $card->trend }} dari bulan lalu
                    </span>
                </p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Daftar Siswa --}}
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div class="mb-4 md:mb-0">
                <label class="font-bold text-lg text-gray-800">Daftar Siswa</label>
            </div>
            {{-- Search bar (optional) --}}
        </div>

        @if(count($list_siswa) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($list_siswa as $siswa)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $siswa['nisn'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $siswa['nama'] ?? $siswa['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $siswa['kelas'] ?? $siswa['class'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </td>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('siswa.show', $siswa['nisn']) }}" class="text-[#4A3AFF] hover:text-[#3A2AFF]">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-gray-50 rounded-lg p-8 flex flex-col items-center justify-center border-2 border-dashed border-gray-200">
            <p class="text-gray-500 mb-2">Data siswa akan muncul di sini</p>
            <p class="text-sm text-gray-400">Gunakan kolom pencarian untuk menemukan siswa</p>
        </div>
        @endif
    </div>

</div>
@endsection