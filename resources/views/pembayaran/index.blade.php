{{-- resources/views/pembayaran/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    {{-- Header dan Tombol Aksi --}}
    <div class="flex justify-between items-center bg-blue-600 text-white p-4 rounded-lg shadow-md mb-6">
        <h1 class="text-xl font-semibold">Management Pembayaran</h1>
        <div class="flex space-x-4">
            
            {{-- PERBAIKAN: Tombol Input Manual diubah menjadi <a> yang menunjuk ke route create --}}
            <a href="{{ route('pembayaran.create') }}" class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold flex items-center hover:bg-gray-100 transition duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Input Manual
            </a>
            
            {{-- PERBAIKAN: Tombol Konfirmasi Massal diubah menjadi <a> dengan link placeholder (atau route jika sudah ada) --}}
            {{-- Catatan: Untuk saat ini, kita beri link placeholder, karena route-nya belum kita buat --}}
            <a href="#" class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold flex items-center hover:bg-gray-100 transition duration-150 opacity-50 cursor-not-allowed">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Konfirmasi Massal
            </a>
            
            {{-- Tag </a> yang salah (berlebih) sudah dihapus --}}
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="flex bg-white rounded-lg shadow-md mb-6 p-1">
        {{-- Tab Pending Konfirmasi --}}
        <a href="{{ route('pembayaran.index', ['tab' => 'pending']) }}" 
           class="{{ $tab == 'pending' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} px-6 py-2 rounded-md font-semibold flex items-center mr-2 transition duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Pending Konfirmasi
        </a>
        
        {{-- Tab Riwayat Pembayaran --}}
        <a href="{{ route('pembayaran.index', ['tab' => 'riwayat']) }}" 
           class="{{ $tab == 'riwayat' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} px-6 py-2 rounded-md font-semibold flex items-center mr-2 transition duration-150">
            {{-- SVG telah diperbaiki (tidak ada di kode sebelumnya, hanya path data) --}}
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-6v6"></path></svg> 
            Riwayat Pembayaran
        </a>
        
        {{-- Tab Bukti Transfer --}}
        <a href="{{ route('pembayaran.index', ['tab' => 'bukti']) }}" 
           class="{{ $tab == 'bukti' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} px-6 py-2 rounded-md font-semibold flex items-center transition duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Bukti Transfer
        </a>
    </div>

    {{-- Tab Content --}}
    <div id="tabContent">
        @if($tab == 'pending')
            {{-- Passing cards dan data ke partial pending --}}
            @include('pembayaran.partials.pending', ['cards' => $cards, 'payment_data' => $payment_data])
        @elseif($tab == 'riwayat')
            {{-- Riwayat hanya butuh data tabel --}}
            @include('pembayaran.partials.riwayat', ['payment_data' => $payment_data])
        @elseif($tab == 'bukti')
            {{-- Bukti transfer juga hanya butuh data tabel --}}
            @include('pembayaran.partials.bukti', ['payment_data' => $payment_data])
        @endif
    </div>
</div>
@endsection