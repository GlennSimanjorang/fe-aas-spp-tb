@extends('layouts.app')

@section('content')
    <div class="bg-blue-600 text-white rounded-xl p-6 mb-6">
        <h2 class="text-2xl font-bold">Hi, Admin!</h2>
        <p>Sistem Pembayaran SPP - SMK Taruna Bhakti</p>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-6">
        @for($i = 0; $i < 3; $i++)
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <p class="font-semibold">Total Siswa</p>
                <div class="w-6 h-6 bg-blue-600 rounded-full mx-auto mt-2"></div>
            </div>
        @endfor
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-bold mb-4">Pembayaran Baru</h3>
        <div class="flex items-center mb-4">
            <input type="text" placeholder="Cari Data Siswa"
                   class="w-full border border-gray-300 rounded-full px-4 py-2 focus:outline-none">
        </div>
        <div class="bg-gray-200 h-32 rounded"></div>
        <div class="text-right mt-2">
            <small>&lt;12345&gt;</small>
        </div>
    </div>
@endsection
