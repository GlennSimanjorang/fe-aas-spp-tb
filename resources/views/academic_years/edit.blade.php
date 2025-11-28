@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

    <h2 class="text-2xl font-bold mb-4">Edit Tahun Ajaran</h2>

    <form method="POST" action="{{ route('academic-years.update', $year->id) }}">
        @csrf
        @method('PUT')

        <label>School Years</label>
        <input type="text" name="school_years" value="{{ $year->school_years }}" class="w-full border p-2 mb-3">

        <label>Start Date</label>
        <input type="date" name="start_date" value="{{ $year->start_date }}" class="w-full border p-2 mb-3">

        <label>End Date</label>
        <input type="date" name="end_date" value="{{ $year->end_date }}" class="w-full border p-2 mb-3">

        <label>Active?</label>
        <input type="checkbox" name="is_active" value="1" {{ $year->is_active ? 'checked' : '' }}>

        <button class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Update</button>
    </form>

</div>
@endsection
