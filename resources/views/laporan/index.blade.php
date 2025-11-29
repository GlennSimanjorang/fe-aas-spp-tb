@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-bar text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Daftar Laporan</h1>
                        <p class="text-gray-600 mt-1">Akses berbagai laporan keuangan dan pembayaran</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Laporan Pembayaran -->
            <a href="{{ route('laporan.payment') }}" 
               class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200 group hover:border-blue-300">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                            Laporan Pembayaran
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">Lihat riwayat semua pembayaran yang telah dilakukan</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>

            <!-- Laporan Tunggakan -->
            <a href="{{ route('laporan.due') }}" 
               class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200 group hover:border-orange-300">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-orange-600 transition-colors">
                            Laporan Tunggakan
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">Monitor pembayaran yang belum lunas atau terlambat</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-orange-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection