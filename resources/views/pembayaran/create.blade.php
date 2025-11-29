@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Notifications -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
                <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Terjadi Kesalahan</h3>
                    <ul class="list-disc ml-4 text-red-700 text-sm mt-1">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
                <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus text-blue-600"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Buat Tagihan Baru</h1>
                        <p class="text-gray-600 mt-1">Isi data berikut untuk membuat tagihan baru</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('pembayaran.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Student Selection -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-user text-gray-400 text-sm"></i>
                            Siswa
                        </div>
                    </label>
                    <select name="student_id" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                            required>
                        <option value="">-- Pilih siswa --</option>
                        @foreach($students as $s)
                            <option value="{{ $s['id'] }}">{{ $s['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Selection -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-tags text-gray-400 text-sm"></i>
                            Kategori Pembayaran
                        </div>
                    </label>
                    <select name="payment_categories_id" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                            required>
                        <option value="">-- Pilih kategori pembayaran --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c['id'] }}">
                                {{ $c['name'] }} (Rp {{ number_format($c['amount'],0,',','.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Academic Year -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                            Tahun Ajaran
                        </div>
                    </label>
                    <select name="academic_years_id" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                            required>
                        <option value="1">2024 / 2025</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-md transition-all duration-200 hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Tagihan
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
                        Tagihan akan otomatis dibuat dengan jumlah sesuai kategori pembayaran yang dipilih.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection