@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Data Siswa</h1>
                        <p class="text-gray-600 mt-1">Data Siswa/i SMK Taruna Bhakti</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3">
                <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">
                <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                </div>
                <p class="text-yellow-700">{{ session('warning') }}</p>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($cards as $card)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">{{ $card->title }}</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $card->value }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-blue-600"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-green-600 flex items-center">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i>
                        {{ $card->trend }} dari bulan lalu
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Students Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Siswa</h2>
                    <a href="{{ route('siswa.create') }}" 
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-200 hover:shadow-lg">
                        <i class="fas fa-plus"></i>
                        Tambah Siswa Baru
                    </a>
                </div>
            </div>

            <!-- Table -->
            @if(count($list_siswa) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($list_siswa as $siswa)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $siswa['nisn'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $siswa['nama'] ?? $siswa['name'] ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $siswa['kelas'] ?? $siswa['class'] ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('siswa.edit', $siswa['id'] ?? $siswa['nisn']) }}"
                                       class="text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-1">
                                        <i class="fas fa-edit text-xs"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('siswa.destroy', $siswa['id'] ?? $siswa['nisn']) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 transition-colors flex items-center gap-1">
                                            <i class="fas fa-trash text-xs"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <!-- Empty State -->
            <div class="px-6 py-12 text-center">
                <div class="flex flex-col items-center justify-center text-gray-500">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-users text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data siswa</h3>
                    <p class="mb-4">Belum ada data siswa yang terdaftar</p>
                    <a href="{{ route('siswa.create') }}" 
                       class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <i class="fas fa-plus"></i>
                        Tambah Siswa Pertama
                    </a>
                </div>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection