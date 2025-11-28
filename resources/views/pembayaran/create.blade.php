@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl p-6 shadow-lg">
        <h1 class="text-2xl md:text-3xl font-bold">Input Pembayaran Manual</h1>
        <p class="text-sm opacity-90">Mencatat pembayaran yang diterima secara tunai atau transfer untuk tagihan yang belum lunas.</p>
    </div>

    {{-- Card Form --}}
    <div class="bg-white p-8 rounded-xl shadow-md">

        @if(session('error'))
            {{-- Tambahkan div error jika dibutuhkan --}}
        @endif

        {{-- START: Cek ketersediaan data --}}
        @if(empty($list_bills)) 
            <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                <p class="text-lg font-semibold text-gray-700">Tidak ada Tagihan Outstanding yang tersedia.</p>
                <p class="text-sm text-gray-500 mt-2">Pastikan tagihan sudah dibuat atau belum lunas.</p>
            </div>
        @else
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Formulir Transaksi Manual</h2>

            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Input Tagihan (Bill) --}}
                    <div>
                        <label for="bill_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tagihan Siswa (Outstanding) <span class="text-red-500">*</span></label>
                        <select id="bill_id" name="bill_id"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 @error('bill_id') border-red-500 ring-red-500 @enderror" required>
                            <option value="">-- Cari atau Pilih Tagihan --</option>

                            {{-- Looping Tagihan --}}
                            @foreach($list_bills as $bill)
                                @php
                                    $outstanding_amount = ($bill['amount'] ?? 0) - ($bill['total_paid'] ?? 0);
                                    $student_nisn = $bill['student']['nisn'] ?? 'N/A';
                                    $student_name = $bill['student']['name'] ?? 'N/A';
                                    $category_name = $bill['payment_category']['name'] ?? 'Tagihan';
                                @endphp
                                <option value="{{ $bill['id'] }}" {{ old('bill_id') == $bill['id'] ? 'selected' : '' }}>
                                    ({{ $student_nisn }}) {{ $student_name }} - Sisa: Rp{{ number_format($outstanding_amount, 0, ',', '.') }} ({{ $category_name }})
                                </option>
                            @endforeach
                            {{-- END Looping Tagihan --}}

                        </select>
                        @error('bill_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Tanggal Pembayaran --}}
                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran <span class="text-red-500">*</span></label>
                        <input type="date" id="payment_date" name="payment_date" value="{{ old('payment_date', $default_date ?? now()->toDateString()) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 @error('payment_date') border-red-500 ring-red-500 @enderror" required>
                        @error('payment_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Jumlah Pembayaran --}}
                    <div>
                        <label for="amount_paid" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pembayaran (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="amount_paid" name="amount_paid" value="{{ old('amount_paid') }}" min="1000" placeholder="Cth: 500000"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 @error('amount_paid') border-red-500 ring-red-500 @enderror" required>
                        @error('amount_paid')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Metode Bayar --}}
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran <span class="text-red-500">*</span></label>
                        <select id="payment_method" name="payment_method"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 @error('payment_method') border-red-500 ring-red-500 @enderror" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai / CASH</option>
                            <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank (Input Manual)</option>
                        </select>
                        @error('payment_method')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div> {{-- End Grid --}}

                {{-- Tombol Aksi --}}
                <div class="flex justify-end space-x-4 pt-6 mt-6 border-t">
                    <a href="{{ route('pembayaran.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition duration-150">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition duration-150">
                        Catat & Konfirmasi Pembayaran
                    </button>
                </div>
            </form>
        @endif
        {{-- END: Cek ketersediaan data --}}
    </div>
</div>
@endsection