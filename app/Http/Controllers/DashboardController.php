<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil token login admin dari session
        $token = Session::get('token');
        $apiBase = 'http://127.0.0.1:8001/api';

        try {
            // -----------------------------
            // 1️⃣ Total Siswa
            // -----------------------------
            $studentsResponse = Http::withToken($token)->get("$apiBase/students")->json();
            $totalSiswa = ($studentsResponse['success'] ?? false) 
                ? count($studentsResponse['content']) 
                : 0;

            // -----------------------------
            // 2️⃣ Total Tunggakan
            // -----------------------------
            $billsResponse = Http::withToken($token)->get("$apiBase/bills?status=unpaid")->json();
            $totalTunggakan = ($billsResponse['success'] ?? false) 
                ? array_sum(array_column($billsResponse['content'], 'amount')) 
                : 0;

            // -----------------------------
            // 3️⃣ Pemasukan Bulan Ini
            // -----------------------------
            $paymentsResponse = Http::withToken($token)->get("$apiBase/payments?month=current")->json();
            $pemasukanBulanIni = ($paymentsResponse['success'] ?? false) 
                ? array_sum(array_column($paymentsResponse['content'], 'amount')) 
                : 0;

            // -----------------------------
            // 4️⃣ Pembayaran Terbaru
            // -----------------------------
            $recentPaymentsResponse = Http::withToken($token)->get("$apiBase/payments?recent=5")->json();
            $pembayaranTerbaru = ($recentPaymentsResponse['success'] ?? false) 
                ? $recentPaymentsResponse['content'] 
                : [];

        } catch (\Exception $e) {
            // Kalau API error/fail
            $totalSiswa = 0;
            $totalTunggakan = 0;
            $pemasukanBulanIni = 0;
            $pembayaranTerbaru = [];
        }

        // -----------------------------
        // Siapkan data untuk Blade
        // -----------------------------
        $data = [
            'cards' => [
                (object)['title' => 'Total Siswa', 'value' => $totalSiswa, 'trend' => '0%'],
                (object)['title' => 'Total Tunggakan', 'value' => 'Rp '.number_format($totalTunggakan,0,',','.'), 'trend' => '0%'],
                (object)['title' => 'Pemasukan Bulan Ini', 'value' => 'Rp '.number_format($pemasukanBulanIni,0,',','.'), 'trend' => '0%'],
            ],
            'pembayaran_baru' => $pembayaranTerbaru,
        ];

        return view('dashboard.index', ['data' => $data]);
    }
}
