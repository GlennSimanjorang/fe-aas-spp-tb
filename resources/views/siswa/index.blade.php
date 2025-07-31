@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-[#4A3AFF] text-white rounded-xl p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Data Siswa</h1>
            <p class="text-sm">Data Siswa/i SMK Taruna Bhakti</p>
        </div>
        <div class="space-x-2">
            <button class="bg-white text-[#4A3AFF] font-medium px-4 py-2 rounded-full text-sm">Tambah Siswa</button>
            <button class="bg-white text-[#4A3AFF] font-medium px-4 py-2 rounded-full text-sm">Export Excel</button>
            <button class="bg-white text-[#4A3AFF] font-medium px-4 py-2 rounded-full text-sm">Export Data</button>
        </div>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-lg font-semibold">Total Siswa Aktif</p>
            <div class="w-6 h-6 bg-[#4A3AFF] mt-2 rounded"></div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-lg font-semibold">Siswa Lulus</p>
            <div class="w-6 h-6 bg-[#4A3AFF] mt-2 rounded"></div>
        </div>
    </div>

    {{-- Daftar Siswa --}}
    <div class="bg-white p-6 rounded-xl shadow space-y-4">
        <div>
            <label class="font-bold block mb-2">Daftar Siswa</label>
            <div class="relative">
                <input type="text" placeholder="Cari Data Siswa" class="w-full border rounded-full py-2 px-4 pl-10 outline-none" />
                <svg class="w-5 h-5 absolute top-2.5 left-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                     <path stroke-linecap="round" stroke-linejoin="round"
                     d="M21 21l-4.35-4.35M11 18a7 7 0 1 1 0-14 7 7 0 0 1 0 14z"></path>
                </svg>
            </div>
        </div>

        {{-- Tabel (dummy dulu) --}}
        <div class="h-32 bg-gray-200 rounded-lg"></div>

        {{-- Pagination --}}
        <div class="text-right text-sm space-x-2">
            <span class="text-gray-500">&lt;</span>
            <span class="font-bold">1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
            <span class="text-gray-500">&gt;</span>
        </div>
    </div>

</div>
@endsection
