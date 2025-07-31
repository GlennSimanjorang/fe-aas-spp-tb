@extends('layouts.app')

@section('content')
<div class="p-4">
    <!-- Header -->
    <div class="flex justify-between items-center bg-[#7e57c2] text-white rounded-xl p-6 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Data Siswa</h1>
            <p class="text-sm">Data Siswa/i SMK Taruna Bhakti</p>
        </div>
        <div class="space-x-2">
            <button class="bg-white text-[#7e57c2] px-4 py-2 rounded-md font-semibold">Tambah Siswa</button>
            <button class="bg-white text-[#7e57c2] px-4 py-2 rounded-md font-semibold">Export Excel</button>
            <button class="bg-white text-[#7e57c2] px-4 py-2 rounded-md font-semibold">Export Data</button>
        </div>
    </div>

    
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white shadow-md p-4 rounded-xl text-center">
            <p class="text-sm font-semibold">Total Siswa Aktif</p>
            <div class="mt-2 w-5 h-5 mx-auto bg-[#7e57c2] rounded"></div>
        </div>
        <div class="bg-white shadow-md p-4 rounded-xl text-center">
            <p class="text-sm font-semibold">Siswa Lulus</p>
            <div class="mt-2 w-5 h-5 mx-auto bg-[#7e57c2] rounded"></div>
        </div>
    </div>

   
    <div class="bg-white rounded-xl p-6 shadow-md">
        <h2 class="text-lg font-semibold mb-4">Daftar Siswa</h2>
        <div class="flex items-center mb-4">
            <input type="text" placeholder="Cari Data Siswa" class="w-full border px-4 py-2 rounded-full shadow-inner focus:outline-none">
        </div>

        
        <div class="h-40 bg-gray-200 rounded-md mb-4"></div>

       
        <div class="text-right text-sm font-medium">
            &lt; 1 2 3 4 5 &gt;
        </div>
    </div>
</div>
@endsection
