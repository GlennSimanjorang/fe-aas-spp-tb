@extends('layouts.app')

@section('content')
<div class="container">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

    <h3 class="mb-4">Buat Tagihan Baru</h3>

    <form action="{{ route('pembayaran.store') }}" method="POST">
        @csrf

        {{-- PILIH SISWA --}}
        <div class="mb-3">
            <label for="student_id" class="form-label">Siswa</label>
            <select name="student_id" class="form-control" required>
                <option value="">-- pilih siswa --</option>
                @foreach($students as $s)
                    <option value="{{ $s['id'] }}">{{ $s['name'] }}</option>
                @endforeach
            </select>
        </div>

        {{-- PILIH KATEGORI PEMBAYARAN --}}
        <div class="mb-3">
            <label for="payment_categories_id" class="form-label">Kategori</label>
            <select name="payment_categories_id" class="form-control" required>
                <option value="">-- pilih kategori pembayaran --</option>
                @foreach($categories as $c)
                    <option value="{{ $c['id'] }}">{{ $c['name'] }} (Rp {{ $c['amount'] }})</option>
                @endforeach
            </select>
        </div>

        {{-- TAHUN AJARAN --}}
        <div class="mb-3">
            <label class="form-label">Tahun Ajaran</label>
            <select name="academic_years_id" class="form-control" required>
                <option value="1">2024 / 2025</option>
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>

    </form>

</div>
@endsection
