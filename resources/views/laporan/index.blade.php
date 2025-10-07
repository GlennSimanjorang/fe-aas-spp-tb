@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center bg-blue-600 text-white p-4 rounded-lg shadow-md mb-8">
        <h1 class="text-xl font-semibold">Laporan</h1>
        {{-- Tombol Export utama (mungkin nanti mengarah ke Modal Filter Global) --}}
        <button class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m-3 3V4m-3 14h6a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Export Laporan
        </button>
    </div>

    {{-- Looping Jenis Laporan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($report_types as $report)
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between transition duration-200 hover:shadow-lg">
            <p class="text-lg font-semibold text-gray-800">{{ $report->title }}</p>
            {{-- Tombol Export yang mengarah ke route/laporan/export/{type} --}}
            <a href="{{ route($report->route_name, ['type' => $report->type]) }}" 
               class="bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition" 
               title="Export {{ $report->title }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection