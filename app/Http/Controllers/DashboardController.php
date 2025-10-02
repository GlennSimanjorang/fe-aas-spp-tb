<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // --- DATA DUMMY DASHBOARD ---
        $data = [
            'total_siswa' => '1,432',
            'persentase_naik' => '12%',
            'pembayaran_baru' => [
            ],
            // Data dummy untuk 3 kartu yang sama
            'cards' => [
                (object)['title' => 'Total Siswa', 'value' => '1,432', 'trend' => '12%'],
                (object)['title' => 'Total Tunggakan', 'value' => 'Rp 55.8M', 'trend' => '2%'],
                (object)['title' => 'Pemasukan Bulan Ini', 'value' => 'Rp 10.5M', 'trend' => '20%'],
            ]
        ];

        return view('dashboard.index', [
            'data' => $data,
        ]);
    }
}