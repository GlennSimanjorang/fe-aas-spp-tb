@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    {{-- Header dan Tombol Aksi --}}
    <div class="flex justify-between items-center bg-blue-600 text-white p-4 rounded-lg shadow-md mb-6">
        <h1 class="text-xl font-semibold">Management Pembayaran</h1>
        <div class="flex space-x-4">
            <button class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Input Manual
            </button>
            <button class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Konfirmasi Massal
            </button>
            <a href="{{ route('laporan.export', ['type' => 'pembayaran']) }}" class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m-3 3V4m-3 14h6a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Export Data
            </a>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="flex bg-white rounded-lg shadow-md mb-6 p-1">
        {{-- Tab Pending Konfirmasi --}}
        <a href="{{ route('pembayaran.index', ['tab' => 'pending']) }}" 
           class="{{ $tab == 'pending' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} px-6 py-2 rounded-md font-semibold flex items-center mr-2">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Pending Konfirmasi
        </a>
        
        {{-- Tab Riwayat Pembayaran --}}
        <a href="{{ route('pembayaran.index', ['tab' => 'riwayat']) }}" 
           class="{{ $tab == 'riwayat' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} px-6 py-2 rounded-md font-semibold flex items-center mr-2">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v-2.25c0-.414-.336-.75-.75-.75S10.5 3.586 10.5 4v2.25m3-.75v-.75c0-.414-.336-.75-.75-.75s-.75.336-.75.75v.75m-6 3h1.5m3.75-3.75h-.75m-2.25 0h.75m-2.25 0h1.5M12 6.003h.01"></path></svg>
            Riwayat Pembayaran
        </a>
        
        {{-- Tab Bukti Transfer --}}
        <a href="{{ route('pembayaran.index', ['tab' => 'bukti']) }}" 
           class="{{ $tab == 'bukti' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} px-6 py-2 rounded-md font-semibold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
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