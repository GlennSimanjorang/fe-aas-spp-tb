<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    protected $api = 'https://web-app-spp-tb-production.up.railway.app/api';

    private function token()
    {
        return session('token');
    }

    public function index()
    {
        $response = Http::withToken($this->token())
            ->get($this->api . '/notifications');

        if ($response->failed()) {
            return back()->with('error', 'Gagal mengambil data notifikasi dari API');
        }

        $json = $response->json();

        $notifikasi = $json['content']['data'] ?? [];
        $page = $json['content']['current_page'] ?? 1;

        return view('notifikasi.index', [
            'notifikasi' => $notifikasi,
            'page' => $page,
        ]);
    }
}
