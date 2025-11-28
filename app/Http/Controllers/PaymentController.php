<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon; // Import Carbon untuk formatting tanggal

class PaymentController extends Controller
{
    protected $apiBase;
    protected $token;

    public function __construct()
    {
        $this->apiBase = 'https://web-app-spp-tb-production.up.railway.app/api';
        $this->token = Session::get('token');
    }



    /**
     * Menampilkan halaman utama manajemen pembayaran dengan tab.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');

        $payment_data = [];
        $cards = [];

        try {

            // AMBIL SEMUA DATA DARI HISTORY
            $response = Http::withToken($this->token)->get($this->apiBase . '/payments/history');

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                $all = collect($response->json()['content']);
            } else {
                $all = collect();
            }

            // ========== FILTER BERDASARKAN TAB ==========
            if ($tab === 'pending') {
                $filtered = $all->where('status', 'pending');
            } elseif ($tab === 'bukti') {
                $filtered = $all->filter(function ($p) {
                    return isset($p['proof_id']) || isset($p['ref_id']);
                });
            } else { // riwayat
                $filtered = $all->where('status', 'success');
            }

            // ========== MAP KE FORMAT VIEW ==========
            $payment_data = $filtered->map(function ($p) {

                return (object)[
                    'id_transaksi' => $p['id'],
                    'waktu'        => $p['transaction_date']
                        ? Carbon::parse($p['transaction_date'])->format('d/m/Y H:i')
                        : 'N/A',
                    'nis'          => $p['student_nisn'] ?? '-',
                    'nama'         => $p['student_name'] ?? '-',
                    'kelas'        => $p['class_name'] ?? '-',
                    'periode'      => $p['payment_period'] ?? '-',
                    'jumlah'       => 'Rp ' . number_format($p['amount'] ?? 0, 0, ',', '.'),
                    'metode'       => $p['payment_method'] ?? '-',
                    'bukti'        => $p['proof_id'] ?? $p['ref_id'] ?? '-',
                    'status'       => $p['status'],
                ];
            })->values()->all();

            // ========== GENERATE CARD UNTUK TAB PENDING ==========
            if ($tab === 'pending') {

                $cards = [
                    (object)[
                        'title' => 'Menunggu Konfirmasi',
                        'value' => $all->where('status', 'pending')->count()
                    ],
                    (object)[
                        'title' => 'Total Nilai Pending',
                        'value' => 'Rp ' . number_format($all->where('status', 'pending')->sum('amount'))
                    ],
                    (object)[
                        'title' => 'Total Transaksi',
                        'value' => $all->count()
                    ],
                ];
            }
        } catch (\Exception $e) {
            Session::flash('error', 'API Error: ' . $e->getMessage());
        }

        return view('pembayaran.index', compact('tab', 'payment_data', 'cards'));
    }

    // ... create dan store methods di bawahnya tetap sama ...

    /**
     * Menampilkan formulir Input Manual Pembayaran. (Fitur 'Input Manual')
     */
    public function create()
    {
        $response = Http::withToken($this->token)
            ->get($this->apiBase . '/bills');

        $data = $response->json();

        // Pastikan $data['data'] adalah LIST
        $bills = $data['data'] ?? [];

        $bills = [
            [
                'id' => 1,
                'student_name' => 'Budi Setiawan',
                'month_year' => '01-2025',
                'amount' => 150000
            ],
            [
                'id' => 2,
                'student_name' => 'Siti Aminah',
                'month_year' => '02-2025',
                'amount' => 150000
            ],
        ];

        return view('pembayaran.create', compact('bills'));
    }


    /**
     * Menyimpan data Pembayaran yang diinput manual ke API (POST).
     */
    public function store(Request $request)
{
    $payload = [
        'payment_method' => $request->method,
        'amount_paid' => $request->amount,
        'payment_date' => $request->payment_date,
        'notes' => $request->notes,
    ];

    $response = Http::withToken($this->token)
        ->post($this->apiBase . '/payments/' . $request->bill_id, $payload);


    if ($response->successful()) {
        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil!');
    }

    return back()->with('error', 'Gagal menyimpan pembayaran');
}


    /**
     * Menampilkan detail konfirmasi pembayaran.
     */
    public function show($id)
    {
        // Method ini akan kita kerjakan di tahap selanjutnya.
        // Endpoint: /payments/{id}
        // return view('pembayaran.show');
    }
}
