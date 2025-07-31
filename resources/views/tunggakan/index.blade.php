@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center bg-blue-600 text-white p-4 rounded-lg shadow-md mb-6">
        <h1 class="text-xl font-semibold">Management Tunggakan</h1>
        <button class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m-3 3V4m-3 14h6a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Export Tunggakan
        </button>
    </div>

    <div class="bg-red-500 text-white p-4 rounded-lg flex items-center mb-6 shadow-md">
        <svg class="w-6 h-6 mr-3 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <p><span class="font-bold">Perhatian: Tunggakan Kritis</span> <br> 89 Siswa memiliki tunggakan lebih dari 2 bulan</p>
    </div>

    <div class="flex bg-white rounded-lg shadow-md mb-6 p-1">
        <button class="tab-button {{ request()->get('tab', 'overview') == 'overview' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} px-6 py-2 rounded-md font-semibold flex items-center mr-2"
                data-tab="overview"> {{-- Add data-tab attribute --}}
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001 1h3v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m-6-3h12"></path></svg>
            Overview
        </button>
        <button class="tab-button {{ request()->get('tab') == 'aktif' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} px-6 py-2 rounded-md font-semibold flex items-center mr-2"
                data-tab="aktif"> {{-- Add data-tab attribute --}}
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            Tunggakan Aktif
        </button>
        <button class="tab-button {{ request()->get('tab') == 'kritis' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} px-6 py-2 rounded-md font-semibold flex items-center"
                data-tab="kritis"> {{-- Add data-tab attribute --}}
            <svg class="w-5 h-5 mr-2 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Kritis
        </button>
    </div>

    <div id="tabContent">
        @if(request()->get('tab', 'overview') == 'overview')
            @include('tunggakan.partials.overview')
        @elseif(request()->get('tab') == 'aktif')
            @include('tunggakan.partials.aktif')
        @elseif(request()->get('tab') == 'kritis')
            @include('tunggakan.partials.kritis')
        @endif
    </div>
</div>

{{-- Add your JavaScript at the end of the body or in a dedicated script section --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tab = this.dataset.tab;
                // Construct the URL and navigate
                const url = new URL(window.location.href);
                url.searchParams.set('tab', tab);
                window.location.href = url.toString();
            });
        });
    });
</script>
@endpush
@endsection