@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md">

    <h1 class="text-2xl font-bold mb-6">Edit Data Siswa</h1>

    <form action="{{ route('siswa.update', $siswa['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="font-medium">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $siswa['name'] }}"
                class="w-full p-3 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="font-medium">NISN</label>
            <input type="text" name="nisn" value="{{ $siswa['nisn'] }}"
                class="w-full p-3 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="font-medium">Kelas</label>
            <input type="text" name="kelas" value="{{ $siswa['kelas'] }}"
                class="w-full p-3 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="font-medium">User ID</label>
            <input type="text" name="user_id" value="{{ $siswa['user_id'] }}"
                class="w-full p-3 border rounded-lg" required>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('siswa.index') }}" class="px-4 py-2 rounded-lg bg-gray-200">
                Batal
            </a>

            <button class="px-4 py-2 rounded-lg bg-blue-600 text-white">
                Update
            </button>
        </div>
    </form>

</div>
@endsection