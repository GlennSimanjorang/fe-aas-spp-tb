@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Laporan Tunggakan</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Siswa</th>
                <th>Kategori</th>
                <th>Total Tagihan</th>
                <th>Sudah Bayar</th>
                <th>Sisa</th>
                <th>Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bills as $b)
            <tr>
                <td>{{ $b['id'] }}</td>
                <td>{{ $b['student']['student_name'] ?? '-' }}</td>
                <td>{{ $b['payment_category']['payment_name'] ?? '-' }}</td>
                <td>Rp {{ number_format($b['bill_amount']) }}</td>
                <td>Rp {{ number_format($b['paid_amount']) }}</td>
                <td>Rp {{ number_format($b['bill_amount'] - $b['paid_amount']) }}</td>
                <td>{{ $b['due_date'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
