@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

    <h2 class="text-2xl font-bold mb-4">Tambah Tahun Ajaran</h2>

    <form method="POST" action="{{ route('academic-years.store') }}">
        @csrf

        <label>School Years</label>
        <input type="text" name="school_years" class="w-full border p-2 mb-3">

        <label>Start Date</label>
        <input type="date" name="start_date" class="w-full border p-2 mb-3">

        <label>End Date</label>
        <input type="date" name="end_date" class="w-full border p-2 mb-3">

        <label>Active?</label>
        <input type="checkbox" name="is_active" value="1">

        <button class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Simpan</button>
    </form>

</div>
@endsection
