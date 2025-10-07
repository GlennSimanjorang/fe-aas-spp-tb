<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Pilih Siswa Untuk Mengirim Pesan</h2>
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        @foreach($students as $student)
        <div class="bg-blue-600 text-white p-4 rounded-lg flex flex-col items-center cursor-pointer hover:bg-blue-700 transition">
            <svg class="w-8 h-8 mb-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
            <p class="font-semibold">{{ $student->name }}</p>
        </div>
        @endforeach
        
        {{-- PAGINATION --}}
        <div class="col-span-full mt-4 flex justify-end items-center">
            {{-- ... Kode Pagination tetap sama ... --}}
        </div>
    </div>

    <div class="mt-4">
        <textarea class="w-full h-32 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tulis pesan..."></textarea>
    </div>

    <div class="mt-4 flex justify-end">
        <button class="bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 transition">
            Kirim Pesan
        </button>
    </div>
</div>