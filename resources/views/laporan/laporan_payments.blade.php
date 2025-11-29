@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Laporan Pembayaran</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Siswa</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Tanggal Bayar</th>
                    <th>Metode</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $p)
                    <tr>
                        <td>{{ $p['id'] }}</td>
                        <td>{{ $p['bill']['student']['name'] ?? '-' }}</td>
                        <td>{{ $p['bill']['payment_category']['name'] ?? '-' }}</td>
                        <td>Rp {{ number_format($p['amount_paid'], 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($p['payment_date'])->format('d-m-Y') }}</td>
                        <td>{{ ucfirst($p['payment_method']) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data pembayaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if (isset($pagination['links']))
            <div class="mt-3">
                <nav>
                    <ul class="pagination">
                        @foreach ($pagination['links'] as $link)
                            <li class="page-item {{ $link['active'] ? 'active' : '' }}">
                                <a class="page-link" href="{{ $link['url'] }}">{{ strip_tags($link['label']) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        @endif

    </div>
</div>
@endsection
