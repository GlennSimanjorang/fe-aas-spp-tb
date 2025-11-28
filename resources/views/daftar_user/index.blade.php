@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Header --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">Daftar User</h1>
                <p class="text-sm text-gray-500 mt-1">Semua pengguna sistem SMK Taruna Bhakti</p>
            </div>

            <a href="{{ route('users.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition">
                + Tambah User
            </a>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    {{-- Tabel User --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">List User</h2>
        </div>

        @if(count($users) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 text-left font-semibold">Nama</th>
                        <th class="px-6 py-3 text-left font-semibold">Email</th>
                        <th class="px-6 py-3 text-left font-semibold">Role</th>
                        <th class="px-6 py-3 text-left font-semibold">Status</th>
                        <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">

                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            {{ $user->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $user->email ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                                {{ ucfirst($user->role ?? 'user') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @php
                            $status = $user->status ?? 'active';
                            @endphp

                            @if($status === 'active')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Nonaktif</span>
                            @endif
                        </td>

                        @php
                        $uid = $user->id ?? null;
                        @endphp

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-3">

                            @if($uid)

                            <a href="{{ route('users.edit', $uid) }}"
                                class="text-yellow-600 hover:text-yellow-800">
                                Edit
                            </a>


                            <form method="POST" action="{{ route('users.destroy', $uid) }}"
                                onsubmit="return confirm('Yakin hapus user?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                            @else
                            <span class="text-red-500 text-xs">ID tidak tersedia</span>
                            @endif

                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        @else
        <div class="bg-gray-50 rounded-lg p-8 flex flex-col items-center justify-center border-2 border-dashed border-gray-300">
            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <p class="text-gray-500 mt-2">Belum ada user yang terdaftar.</p>
            <a href="{{ route('users.create') }}" class="mt-3 text-sm font-medium text-blue-600 hover:underline">
                Tambah User Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection