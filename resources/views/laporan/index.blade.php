@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Laporan</h3>

    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ route('laporan.payment') }}">Laporan Pembayaran</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('laporan.due') }}">Laporan Tunggakan</a>
        </li>
    </ul>
</div>
@endsection
