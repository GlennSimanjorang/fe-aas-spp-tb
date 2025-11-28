@extends('layouts.app')

@section('content')
<div class="p-6 bg-white shadow rounded">

    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">Academic Years</h2>
        <a href="{{ route('academic-years.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah</a>
    </div>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">School Years</th>
                <th class="p-2 border">Start</th>
                <th class="p-2 border">End</th>
                <th class="p-2 border">Active</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($years as $y)
            <tr>
                <td class="p-2 border">{{ $y->school_years }}</td>
                <td class="p-2 border">{{ $y->start_date }}</td>
                <td class="p-2 border">{{ $y->end_date }}</td>
                <td class="p-2 border">{{ $y->is_active ? 'Yes' : 'No' }}</td>
                <td class="p-2 border">
                    <a href="{{ route('academic-years.edit', $y->id) }}" class="text-blue-600">Edit</a>

                    <form action="{{ route('academic-years.destroy', $y->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Yakin hapus?')" class="text-red-600 ml-2">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="p-3 text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
