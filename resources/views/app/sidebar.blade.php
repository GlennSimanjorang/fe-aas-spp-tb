@php
    $active = request()->segment(1);
@endphp

<aside class="w-64 h-screen bg-gray-800 text-white fixed">
    <div class="p-4 text-2xl font-bold border-b border-gray-700">
        SISFO SPP
    </div>
    <nav class="mt-4 px-4 space-y-2">
        <a href="/dashboard"
           class="block py-2 px-3 rounded {{ $active === 'dashboard' ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
            Dashboard
        </a>
        <a href="/siswa"
           class="block py-2 px-3 rounded {{ $active === 'siswa' ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
            Data Siswa
        </a>
        <a href="/pembayaran"
           class="block py-2 px-3 rounded {{ $active === 'pembayaran' ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
            Pembayaran
        </a>
        <a href="/tunggakan"
           class="block py-2 px-3 rounded {{ $active === 'tunggakan' ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
            Tunggakan
        </a>
        <a href="/laporan"
           class="block py-2 px-3 rounded {{ $active === 'laporan' ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
            Laporan
        </a>
        <a href="/notifikasi"
           class="block py-2 px-3 rounded {{ $active === 'notifikasi' ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
            Notifikasi
        </a>
    </nav>
</aside>
