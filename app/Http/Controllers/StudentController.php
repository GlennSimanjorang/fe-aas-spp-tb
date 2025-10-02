<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // 1. DATA DUMMY UNTUK KARTU (cards)
        $cards = [
            (object)['title' => 'Total Siswa Aktif', 'value' => '1,024', 'trend' => '5%'],
            (object)['title' => 'Siswa Lulus', 'value' => '286', 'trend' => '15%'],
        ];

        // 2. DATA DUMMY UNTUK TABEL (list_siswa)
        $list_siswa = [
            (object)['nis' => '2024001', 'nama' => 'Ahmad Fauzi', 'kelas' => 'XII RPL 2', 'status' => 'Aktif'],
            (object)['nis' => '2024002', 'nama' => 'Budi Santoso', 'kelas' => 'XI TKJ 1', 'status' => 'Aktif'],
            (object)['nis' => '2024003', 'nama' => 'Citra Dewi', 'kelas' => 'X AKL 3', 'status' => 'Non-Aktif'],
        ];

        // 3. MENGIRIM DUA VARIABEL KE VIEW
        return view('siswa.index', [
            'list_siswa' => $list_siswa,
            'cards' => $cards // <-- INI YANG PALING PENTING!
        ]);
    }

    public function show($nis)
    {
        // Dummy data untuk detail satu siswa
        $siswa = (object)[
            'nis' => $nis,
            'nama' => 'Ahmad Fauzi',
            'kelas' => 'XII RPL 2',
            'wali_murid' => 'Bapak Joko',
            'no_hp' => '0812xxxxxx',
            'alamat' => 'Jl. Mawar No. 5',
        ];

        return view('siswa.show', [
            'siswa' => $siswa,
        ]);
    }
}
