@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl font-bold text-gray-900">Daftar Tunggakan</h1>
                    <p class="text-gray-600 mt-2">Monitor semua pembayaran yang terlambat</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        {{ count($tunggakan) }} Tunggakan
                    </span>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Siswa
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kelas
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tagihan
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sudah Bayar
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jatuh Tempo
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tunggakan as $t)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $t->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-blue-600 text-xs"></i>
                                        </div>
                                        {{ $t->student }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $t->kelas }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $t->kategori }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($t->amount) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    Rp {{ number_format($t->paid) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                                        {{ \Carbon\Carbon::parse($t->due_date)->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Terlambat
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-check text-green-600 text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada tunggakan</h3>
                                        <p class="text-gray-500 max-w-md">
                                            Semua pembayaran sudah dilakukan tepat waktu. Pertahankan!
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($pagination['links']))
                <div class="bg-white px-6 py-4 border-t border-gray-200">
                    <nav class="flex items-center justify-between">
                        <div class="hidden sm:block">
                            <p class="text-sm text-gray-700">
                                Menampilkan 
                                <span class="font-medium">{{ ($pagination['current_page'] - 1) * 10 + 1 }}</span>
                                -
                                <span class="font-medium">{{ min($pagination['current_page'] * 10, $pagination['total']) }}</span>
                                dari
                                <span class="font-medium">{{ $pagination['total'] }}</span>
                                hasil
                            </p>
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            <ul class="flex space-x-1">
                                @foreach ($pagination['links'] as $link)
                                    <li>
                                        <a href="{{ $link['url'] ? url()->current() . '?page=' . $link['page'] : '#' }}"
                                           class="relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md
                                                  {{ $link['active'] 
                                                     ? 'bg-blue-50 border-blue-500 text-blue-600 z-10' 
                                                     : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' }}
                                                  {{ !$link['url'] ? 'opacity-50 cursor-not-allowed' : '' }}">
                                            {!! $link['label'] !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>
            @endif
        </div>

        <!-- Summary Cards -->
        @if(count($tunggakan) > 0)
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-red-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Tunggakan</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            Rp {{ number_format($tunggakan->sum('amount') - $tunggakan->sum('paid')) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-orange-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Jumlah Siswa</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $tunggakan->unique('student')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-invoice text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Tagihan</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            Rp {{ number_format($tunggakan->sum('amount')) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection