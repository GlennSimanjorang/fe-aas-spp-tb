@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-edit text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Edit Tahun Ajaran</h1>
                        <p class="text-gray-600 mt-1">Perbarui data tahun ajaran</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form method="POST" action="{{ route('academic-years.update', $year->id) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- School Years -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                            Tahun Ajaran
                        </div>
                    </label>
                    <input type="text" 
                           name="school_years" 
                           value="{{ $year->school_years }}"
                           placeholder="Contoh: 2024/2025"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           required>
                </div>

                <!-- Start Date -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-play-circle text-gray-400 text-sm"></i>
                            Tanggal Mulai
                        </div>
                    </label>
                    <input type="date" 
                           name="start_date" 
                           value="{{ $year->start_date }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           required>
                </div>

                <!-- End Date -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-stop-circle text-gray-400 text-sm"></i>
                            Tanggal Selesai
                        </div>
                    </label>
                    <input type="date" 
                           name="end_date" 
                           value="{{ $year->end_date }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           required>
                </div>

                <!-- Active Status -->
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           id="is_active"
                           {{ $year->is_active ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_active" class="flex items-center gap-2 text-sm font-medium text-gray-700 cursor-pointer">
                        <i class="fas fa-power-off text-gray-400"></i>
                        Jadikan tahun ajaran aktif
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4">
                    <a href="{{ route('academic-years.index') }}"
                       class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded-xl shadow-md transition-all duration-200 hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-md transition-all duration-200 hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Update Tahun Ajaran
                    </button>
                </div>

            </form>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
            </div>
        </div>

    </div>
</div>
@endsection