@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Daftar Tunggakan</h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Kategori</th>
                <th>Tagihan</th>
                <th>Sudah Bayar</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        @forelse($tunggakan as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->student }}</td>
                <td>{{ $t->kelas }}</td>
                <td>{{ $t->kategori }}</td>
                <td>Rp {{ number_format($t->amount) }}</td>
                <td>Rp {{ number_format($t->paid) }}</td>
                <td>{{ \Carbon\Carbon::parse($t->due_date)->format('d/m/Y') }}</td>
                <td>
                    <span class="badge bg-danger">Terlambat</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada tunggakan</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @if(isset($pagination['links']))
    <div class="mt-3">
        <nav>
            <ul class="pagination">
                @foreach ($pagination['links'] as $link)
                    <li class="page-item {{ $link['active'] ? 'active' : '' }}">
                        <a class="page-link" 
                           href="{{ $link['url'] ? url()->current() . '?page=' . $link['page'] : '#' }}">
                            {!! $link['label'] !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
@endif


</div>
@endsection
