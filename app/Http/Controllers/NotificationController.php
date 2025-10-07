<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil tab dari URL, default ke 'overview'
        $tab = $request->get('tab', 'overview');

        // =========================================================
        // DUMMY DATA: Nanti ganti dengan data dinamis dari database
        // =========================================================

        // Data untuk Tab Overview
        $overview_data = [
            'cards' => [
                (object)['title' => 'Pesan Terkirim Hari ini', 'value' => '2,847', 'icon_bg' => 'bg-blue-600', 'icon_color' => 'text-white', 'svg_path' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                (object)['title' => 'Sudah Di baca', 'value' => '89.2%', 'icon_bg' => 'bg-blue-100', 'icon_color' => 'text-blue-600', 'svg_path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                (object)['title' => 'Yang Sudah Di respon', 'value' => '67.3%', 'icon_bg' => 'bg-blue-100', 'icon_color' => 'text-blue-600', 'svg_path' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
            ],
            'quick_send' => [
                (object)['title' => 'Tunggakan 1+ bulan', 'count' => '86 siswa', 'icon_bg' => 'bg-yellow-100', 'icon_color' => 'text-yellow-500', 'svg_path' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z'],
                (object)['title' => 'Jatuh Tempo Hari ini', 'count' => '86 siswa', 'icon_bg' => 'bg-blue-100', 'icon_color' => 'text-blue-600', 'svg_path' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
                (object)['title' => 'Jatuh Tempo 3 Hari', 'count' => '86 siswa', 'icon_bg' => 'bg-blue-100', 'icon_color' => 'text-blue-600', 'svg_path' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
            ]
        ];

        // Data untuk Tab Pesan & Riwayat
        $students = [
            (object)['id' => 1, 'name' => 'Ahmad Fauzi', 'selected' => true],
            (object)['id' => 2, 'name' => 'Budi Santoso', 'selected' => false],
            (object)['id' => 3, 'name' => 'Cindy Melati', 'selected' => false],
            (object)['id' => 4, 'name' => 'Dewi Lestari', 'selected' => true],
            (object)['id' => 5, 'name' => 'Eko Prasetyo', 'selected' => false],
            (object)['id' => 6, 'name' => 'Faisal Rahman', 'selected' => false],
        ];


        // 2. Kirim semua data ke View
        return view('notifikasi.index', [
            'tab' => $tab,
            'overview_data' => $overview_data, // Data untuk overview
            'students' => $students, // Data daftar siswa
        ]);
    }
}