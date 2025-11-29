@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-plus text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Tambah Data Siswa Baru</h1>
                        <p class="text-gray-600 mt-1">Tambahkan data siswa baru ke sistem</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Error Notification -->
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-xl m-6 p-4 flex items-start gap-3">
                    <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('siswa.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Form Header -->
                <div class="border-b border-gray-200 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-user-circle text-gray-400"></i>
                        Input Data Diri Siswa
                    </h2>
                </div>

                <!-- NISN -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-id-card text-gray-400 text-sm"></i>
                            NISN Siswa
                            <span class="text-red-500">*</span>
                        </div>
                    </label>
                    <input type="text" 
                           id="nisn" 
                           name="nisn" 
                           value="{{ old('nisn') }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  @error('nisn') border-red-500 ring-red-500 @enderror"
                           required>
                    @error('nisn')
                        <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nama Siswa -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-user text-gray-400 text-sm"></i>
                            Nama Lengkap
                            <span class="text-red-500">*</span>
                        </div>
                    </label>
                    <input type="text" 
                           id="nama_siswa" 
                           name="nama_siswa" 
                           value="{{ old('nama_siswa') }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  @error('nama_siswa') border-red-500 ring-red-500 @enderror"
                           required>
                    @error('nama_siswa')
                        <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Kelas -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-graduation-cap text-gray-400 text-sm"></i>
                            Kelas
                            <span class="text-red-500">*</span>
                        </div>
                    </label>
                    <input type="text" 
                           id="kelas" 
                           name="kelas" 
                           value="{{ old('kelas') }}"
                           placeholder="Contoh: X IPA 1"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           required>
                </div>

                <!-- User ID -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-key text-gray-400 text-sm"></i>
                            User ID
                            <span class="text-red-500">*</span>
                        </div>
                    </label>
                    <input type="number" 
                           id="user_id" 
                           name="user_id" 
                           value="{{ old('user_id') }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  @error('user_id') border-red-500 ring-red-500 @enderror"
                           required>
                    @error('user_id')
                        <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('siswa.index') }}" 
                       class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded-xl shadow-md transition-all duration-200 hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-md transition-all duration-200 hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Data Siswa
                    </button>
                </div>

            </form>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                <div>
                    <h4 class="text-sm font-semibold text-blue-800">Informasi</h4>
                    <p class="text-blue-700 text-sm mt-1">
                        Pastikan data yang dimasukkan sudah benar.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection