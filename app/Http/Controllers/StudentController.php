<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // 1. Cards (kamu bisa update logikanya nanti)
        $cards = [
            (object)['title' => 'Total Siswa Aktif', 'value' => '...', 'trend' => '...'],
            (object)['title' => 'Siswa Lulus', 'value' => '...', 'trend' => '...'],
        ];

        // 2. Ambil data siswa dari backend API
        $response = Http::withToken(session('token'))
            ->get('http://127.0.0.1:8001/api/students');

        $data = $response->json();

        $list_siswa = isset($data['success']) && $data['success']
            ? collect($data['content'])
            : collect();

        // 3. Kirim data ke view
        return view('siswa.index', [
            'list_siswa' => $list_siswa,
            'cards' => $cards
        ]);
    }

    public function show($nis)
    {
        
        $response = Http::withToken(session('token'))
            ->get("http://127.0.0.1:8001/api/students/{$nis}");

        $data = $response->json();

        $siswa = isset($data['success']) && $data['success']
            ? (object)$data['content']
            : null;

        if(!$siswa){
            abort(404, 'Siswa tidak ditemukan');
        }

        return view('siswa.show', [
            'siswa' => $siswa
        ]);
    }
}
