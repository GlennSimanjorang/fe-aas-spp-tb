<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    public function index()
    {
        // Ambil token login admin dari session
        $token = Session::get('token');
        $apiBase = 'http://127.0.0.1:8001/api';

        try {
            // Ambil data siswa dari API
            $response = Http::withToken($token)->get("$apiBase/students")->json();
            $list_siswa = ($response['success'] ?? false) ? $response['content'] : [];
        } catch (\Exception $e) {
            $list_siswa = [];
        }

        // Buat cards (gunakan total dari data real)
        $totalAktif = count($list_siswa);
        $totalLulus = 0; // placeholder, ganti kalau ada endpoint khusus

        $cards = [
            (object)['title' => 'Total Siswa Aktif', 'value' => number_format($totalAktif), 'trend' => '0%'],
            (object)['title' => 'Siswa Lulus', 'value' => number_format($totalLulus), 'trend' => '0%'],
        ];

        // Pastikan nama view sesuai (lu pake 'siswa.index' sebelumnya)
        return view('siswa.index', [
            'list_siswa' => $list_siswa,
            'cards' => $cards,
        ]);
    }

    public function show($nis)
    {
        $token = Session::get('token');
        $apiBase = 'http://127.0.0.1:8001/api';

        try {
            $response = Http::withToken($token)->get("$apiBase/students/{$nis}")->json();
            $siswa = ($response['success'] ?? false) ? (object)$response['content'] : null;
        } catch (\Exception $e) {
            $siswa = null;
        }

        if (!$siswa) {
            abort(404, 'Siswa tidak ditemukan');
        }

        return view('siswa.show', ['siswa' => $siswa]);
    }
}
