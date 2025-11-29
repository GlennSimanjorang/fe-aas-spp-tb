@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Daftar Tagihan</h1>
                        <p class="text-gray-600 mt-2">Semua tagihan pembayaran siswa</p>
                    </div>

                    <a href="{{ route('pembayaran.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md transition-all duration-200 hover:shadow-lg">
                        <i class="fas fa-plus"></i>
                        Tambah Tagihan
                    </a>
                </div>
            </div>

            <!-- Notification -->
            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
            @endif

            <!-- Table Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">List Tagihan</h2>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Siswa
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Tagihan
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Sudah Bayar
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Jatuh Tempo
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bills as $b)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $b->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600 text-xs"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $b->student }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $b->kategori }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($b->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    Rp {{ number_format($b->paid, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($b->status === 'paid')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle"></i>
                                        Lunas
                                    </span>
                                    @elseif($b->status === 'partial')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock"></i>
                                        Sebagian
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle"></i>
                                        Belum Bayar
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="far fa-calendar text-gray-400"></i>
                                        {{ \Carbon\Carbon::parse($b->due)->format('d/m/Y') }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-receipt text-gray-400 text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada tagihan ditemukan</h3>
                                        <p>Belum ada tagihan yang dibuat</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(isset($pagination))
                <div class="px-6 py-4 border-t border-gray-200 bg-white">
                    <div class="flex justify-center">
                        <nav>
                            <ul class="flex items-center gap-1">
                                {{-- Prev --}}
                                @if($pagination['prev_page_url'])
                                <li>
                                    <a href="?page={{ $pagination['current_page'] - 1 }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-chevron-left text-xs"></i>
                                        Prev
                                    </a>
                                </li>
                                @else
                                <li>
                                    <span class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-chevron-left text-xs"></i>
                                        Prev
                                    </span>
                                </li>
                                @endif

                                {{-- Number pages --}}
                                @for($i = 1; $i <= $pagination['last_page']; $i++)
                                    <li>
                                    <a href="?page={{ $i }}"
                                        class="px-4 py-2 text-sm border rounded-lg transition-colors
                                            {{ $i == $pagination['current_page'] 
                                                ? 'bg-blue-600 border-blue-600 text-white' 
                                                : 'bg-white border-gray-300 text-gray-600 hover:bg-gray-50' }}">
                                        {{ $i }}
                                    </a>
                                    </li>
                                    @endfor

                                    {{-- Next --}}
                                    @if($pagination['next_page_url'])
                                    <li>
                                        <a href="?page={{ $pagination['current_page'] + 1 }}"
                                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                            Next
                                            <i class="fas fa-chevron-right text-xs"></i>
                                        </a>
                                    </li>
                                    @else
                                    <li>
                                        <span class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                                            Next
                                            <i class="fas fa-chevron-right text-xs"></i>
                                        </span>
                                    </li>
                                    @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
    @endsection