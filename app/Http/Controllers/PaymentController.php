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
        $this->apiBase = 'http://127.0.0.1:8001/api';
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
        $apiEndpoint = '';

        switch ($tab) {
            case 'riwayat':
                $apiEndpoint = '/payments/history';
                break;
            case 'bukti':
                $apiEndpoint = '/payments/proofs';
                break;
            case 'pending':
            default:
                $apiEndpoint = '/payments/pending';
                break;
        }

        try {
            // 1. Ambil data pembayaran
            $response = Http::withToken($this->token)->get($this->apiBase . $apiEndpoint);
            $raw_data = [];

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                $raw_data = $response->json()['content'] ?? [];
            } else {
                Session::flash('error', 'Gagal memuat data pembayaran dari API (' . $response->status() . ').');
            }
            
            // 2. Mapping Data ke format yang dibutuhkan View ($payment_data)
            $payment_data = collect($raw_data)->map(function($data) {
                // Konversi data array ke object untuk konsistensi dengan view Anda
                $data = (object)$data;
                
                // Melakukan mapping dan formatting sesuai kebutuhan View Partial Anda
                return (object)[
                    'id_transaksi' => $data->id, // Tambahkan ID untuk aksi (show/konfirmasi)
                    'waktu' => isset($data->transaction_date) ? Carbon::parse($data->transaction_date)->format('d/m/Y H:i') : 'N/A',
                    'nis' => $data->student_nisn ?? 'N/A',
                    'nama' => $data->student_name ?? 'N/A',
                    'kelas' => $data->class_name ?? 'N/A',
                    'periode' => $data->payment_period ?? 'N/A',
                    'jumlah' => 'Rp ' . number_format($data->amount ?? 0, 0, ',', '.'),
                    'metode' => $data->payment_method ?? 'N/A',
                    'bukti' => $data->proof_id ?? $data->ref_id ?? 'N/A', // Cek bukti atau ref ID
                    'status' => $data->status ?? 'Pending', // Asumsi status API adalah 'Pending' atau 'Completed'
                ];
            })->all();
            
            // 3. Ambil data CARD/STATISTIK
            $card_response = Http::withToken($this->token)->get($this->apiBase . '/payments/stats');
            if ($card_response->successful()) {
                $card_data = $card_response->json()['content'] ?? [];
                // API harus mengembalikan data yang match dengan title di view pending
                $cards = collect($card_data)->map(fn($c) => (object)$c)->all();
            } else {
                // Fallback cards (menggunakan data dari $payment_data jika perlu, atau dummy)
                $cards = [
                     (object)['title' => 'Menunggu Konfirmasi', 'value' => count($payment_data)], 
                     (object)['title' => 'Total Nilai Pending', 'value' => 'Rp 0'], 
                     (object)['title' => 'Hari Ini', 'value' => '0'],
                ];
            }


        } catch (\Exception $e) {
            Session::flash('error', 'Koneksi ke server API gagal atau timeout.');
        }

        return view('pembayaran.index', compact('tab', 'payment_data', 'cards'));
    }

    // ... create dan store methods di bawahnya tetap sama ...

    /**
     * Menampilkan formulir Input Manual Pembayaran. (Fitur 'Input Manual')
     */
    public function create()
    {
        // ... kode create method yang sudah kita buat sebelumnya ...
    }

    /**
     * Menyimpan data Pembayaran yang diinput manual ke API (POST).
     */
    public function store(Request $request)
    {
        // ... kode store method yang sudah kita buat sebelumnya ...
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