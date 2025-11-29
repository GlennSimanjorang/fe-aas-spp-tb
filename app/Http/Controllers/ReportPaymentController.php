<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ReportPaymentController extends Controller
{
    protected $apiBase;

    public function __construct()
    {
        $this->apiBase = 'https://web-app-spp-tb-production.up.railway.app/api';
    }

    /**
     * Tampilkan laporan pembayaran (GET /payment-history)
     */
    public function index(Request $request)
    {
        $token = Session::get('token');

        $response = Http::withToken($token)->get($this->apiBase . '/payment-history', [
            'page' => $request->get('page', 1)
        ]);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data payment history');
        }

        $content = $response->json()['content'] ?? [];

        return view('laporan.laporan_payments', [
            'payments' => $content['data'] ?? [],
            'pagination' => $content
        ]);
    }
}
