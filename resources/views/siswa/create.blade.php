@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#4A3AFF] to-[#6A5BFF] text-white rounded-xl p-6 shadow-lg">
        <h1 class="text-2xl md:text-3xl font-bold">Tambah Data Siswa Baru</h1>
    </div>

    {{-- Card Form --}}
    <div class="bg-white p-8 rounded-xl shadow-md">
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Input Data Diri Siswa</h2>

        <form action="{{ route('siswa.store') }}" method="POST">
            @csrf 

            {{-- Input NISN --}}
            <div class="mb-4">
                <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN Siswa <span class="text-red-500">*</span></label>
                <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}" 
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 
                       @error('nisn') border-red-500 ring-red-500 @enderror" required>
                @error('nisn')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Nama Siswa --}}
            <div class="mb-4">
                <label for="nama_siswa" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" 
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 
                       @error('nama_siswa') border-red-500 ring-red-500 @enderror" required>
                @error('nama_siswa')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Kelas (Menggunakan data API: list_kelas) --}}
            <div class="mb-6">
                <label for="id_kelas" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas <span class="text-red-500">*</span></label>
                <select id="id_kelas" name="id_kelas" 
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 
                        @error('id_kelas') border-red-500 ring-red-500 @enderror" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($list_kelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ old('id_kelas') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama ?? $kelas->name }}
                        </option>
                    @endforeach
                    @if(empty($list_kelas))
                        <option value="" disabled>Gagal memuat data kelas dari API</option>
                    @endif
                </select>
                @error('id_kelas')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Alamat --}}
            <div class="mb-6">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea id="alamat" name="alamat" rows="3"
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 
                          @error('alamat') border-red-500 ring-red-500 @enderror" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('siswa.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition duration-150">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-[#4A3AFF] hover:bg-[#3A2AFF] transition duration-150">
                    Simpan Data Siswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection