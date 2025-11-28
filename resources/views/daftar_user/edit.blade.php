@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow border">

    <h2 class="text-2xl font-bold mb-6">Edit User</h2>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full border rounded-lg p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full border rounded-lg p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Role</label>
            <select name="role" class="w-full border rounded-lg p-2">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="parents" {{ $user->role == 'parents' ? 'selected' : '' }}>Parent</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Nomor (opsional)</label>
            <input type="text" name="number" value="{{ old('number', $user->number) }}"
                class="w-full border rounded-lg p-2">
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Update
        </button>

    </form>

</div>
@endsection
