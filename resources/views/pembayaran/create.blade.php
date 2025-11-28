@extends('layouts.app')

@section('content')
<div class="container mx-auto">

    <div class="bg-blue-600 text-white p-4 rounded-lg shadow mb-6">
        <h1 class="text-xl font-semibold">Input Manual Pembayaran</h1>
    </div>

    <form action="{{ route('pembayaran.store') }}" method="POST">
        @csrf

        {{-- Pilih Tagihan --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tagihan</label>
            <select name="bill_id" class="w-full p-2 border rounded-md" required>
                <option value="">-- Pilih Tagihan --</option>
                @foreach($bills as $b)
                <option value="{{ $b['id'] }}">
                    {{ $b['student_name'] }} - {{ $b['month_year'] }} (Rp {{ number_format($b['amount'],0,',','.') }})
                </option>
                @endforeach
            </select>
        </div>

        {{-- Jumlah --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Jumlah Dibayar</label>
            <input type="number" name="amount" class="w-full p-2 border rounded-md" required>
        </div>

        {{-- Tanggal --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tanggal Pembayaran</label>
            <input type="date" name="payment_date" class="w-full p-2 border rounded-md" required>
        </div>

        {{-- Metode --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Metode Pembayaran</label>
            <select name="method" class="w-full p-2 border rounded-md" required>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
            </select>
        </div>

        {{-- Catatan --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Catatan (Opsional)</label>
            <textarea name="notes" class="w-full p-2 border rounded-md"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md font-semibold">
            Simpan
        </button>

        <a href="{{ route('pembayaran.index') }}" class="ml-3 text-gray-600">Kembali</a>

    </form>

</div>
@endsection