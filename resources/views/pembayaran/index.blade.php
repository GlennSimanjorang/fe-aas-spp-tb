@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Daftar Tagihan</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <a href="{{ route('pembayaran.create') }}" class="btn btn-primary mb-3">
    + Tambah Tagihan
</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Siswa</th>
                <th>Kategori</th>
                <th>Tagihan</th>
                <th>Sudah Bayar</th>
                <th>Status</th>
                <th>Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>

        @forelse($bills as $b)
            <tr>
                <td>{{ $b->id }}</td>
                <td>{{ $b->student }}</td>
                <td>{{ $b->kategori }}</td>
                <td>Rp {{ number_format($b->amount,0,',','.') }}</td>
                <td>Rp {{ number_format($b->paid,0,',','.') }}</td>
                <td>
                    @if($b->status === 'paid')
                        <span class="badge bg-success">Lunas</span>
                    @elseif($b->status === 'partial')
                        <span class="badge bg-warning">Sebagian</span>
                    @else
                        <span class="badge bg-danger">Belum Bayar</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($b->due)->format('d/m/Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada tagihan ditemukan</td>
            </tr>
        @endforelse

        </tbody>
    </table>

    {{-- Pagination --}}
    @if(isset($pagination))
        <div class="d-flex justify-content-center mt-3">
            <nav>
                <ul class="pagination">

                    {{-- Prev --}}
                    @if($pagination['prev_page_url'])
                        <li class="page-item">
                            <a class="page-link" href="?page={{ $pagination['current_page'] - 1 }}">« Prev</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">« Prev</span></li>
                    @endif

                    {{-- Number pages --}}
                    @for($i = 1; $i <= $pagination['last_page']; $i++)
                        <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Next --}}
                    @if($pagination['next_page_url'])
                        <li class="page-item">
                            <a class="page-link" href="?page={{ $pagination['current_page'] + 1 }}">Next »</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next »</span></li>
                    @endif

                </ul>
            </nav>
        </div>
    @endif

</div>
@endsection
