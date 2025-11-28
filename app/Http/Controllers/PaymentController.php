<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PaymentController extends Controller
{
    protected $apiBase;
    // Hapus: protected $token; // Tidak perlu property token lagi

    public function __construct()
    {
        // Sesuaikan dengan konfigurasi API Anda
        $this->apiBase = 'http://127.0.0.1:8001/api/'; 
        // 🛑 [FIXED] HAPUS: $this->token = Session::get('token');
        // Token akan diambil langsung di dalam setiap method
    }

    /**
     * Menampilkan halaman utama manajemen pembayaran dengan tab.
     */
    public function index(Request $request)
    {
        // 🛑 [FIXED] AMBIL TOKEN LANGSUNG DI DALAM METHOD
        $token = Session::get('token'); 
        if (!$token) {
            // Jika token hilang, paksa login ulang
            return redirect()->route('login')->with('warning', 'Sesi login telah berakhir.');
        }

        $tab = $request->query('tab', 'pending');
        $payment_data = [];
        $cards = [];
        
        // ... (Logika penentuan $filter_status sama) ...
        $filter_status = '';
        switch ($tab) {
             case 'riwayat':
                 $filter_status = 'success';
                 break;
             case 'bukti':
                 $filter_status = 'success';
                 break;
             case 'pending':
             default:
                 $filter_status = 'pending';
                 break;
        }

        try {
            // 🛑 [FIXED] Panggil endpoint Payment Reports menggunakan variabel $token
            $response = Http::withToken($token) 
                            ->withoutCookie()
                             ->get($this->apiBase . '/payment-reports', ['status' => $filter_status]);
            
            $raw_data = [];

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                $raw_data = $response->json()['data'] ?? [];
            } else {
                Session::flash('error', 'Gagal memuat data pembayaran dari API Payment Reports (' . $response->status() . ').');
            }
            
            // ... (Mapping Data sama) ...
            $payment_data = collect($raw_data)->map(function($data) {
                 $data = (object)$data;
                 return (object)[
                     'id_transaksi' => $data->id, 
                     'waktu' => isset($data->created_at) ? Carbon::parse($data->created_at)->format('d/m/Y H:i') : 'N/A',
                     'nis' => $data->student_nisn ?? 'N/A',
                     'nama' => $data->student_name ?? 'N/A',
                     'kelas' => $data->class_name ?? 'N/A',
                     'periode' => $data->payment_period ?? 'N/A',
                     'jumlah' => 'Rp ' . number_format($data->amount_paid ?? 0, 0, ',', '.'),
                     'metode' => $data->payment_method ?? 'N/A',
                     'bukti' => $data->midtrans_transaction_id ?? $data->proof_ref ?? 'N/A', 
                     'status' => ucfirst($data->status ?? 'pending'), 
                 ];
            })->all();
            
            $cards = [
                 (object)['title' => 'Menunggu Konfirmasi', 'value' => 'N/A'], 
                 (object)['title' => 'Total Nilai Pending', 'value' => 'Rp N/A'], 
                 (object)['title' => 'Hari Ini', 'value' => 'N/A'],
            ];

        } catch (\Exception $e) {
            Session::flash('error', 'Koneksi ke server API gagal atau timeout.');
        }

        return view('pembayaran.index', compact('tab', 'payment_data', 'cards'));
    }

    /**
     * Menampilkan formulir Input Manual Pembayaran.
     */
    public function create()
    {
        // 🛑 [FIXED] AMBIL TOKEN LANGSUNG DI DALAM METHOD
        $token = Session::get('token'); 
        if (!$token) {
            return redirect()->route('login')->with('warning', 'Sesi login telah berakhir.');
        }

        try {
            // 🛑 [FIXED] Gunakan variabel $token lokal
            $bills_response = Http::withToken($token)
            ->withoutCookie()
            ->get("{$this->apiBase}/bills");

            $list_bills = $bills_response->successful() 
                                 ? $bills_response->json()['data'] ?? [] 
                                 : [];
            
            // ... (Filter bills sama) ...
            $outstanding_bills = collect($list_bills)->filter(function($bill) {
                 $status = $bill['status'] ?? 'outstanding';
                 return in_array($status, ['outstanding', 'partial']);
            })->all();
            
        } catch (\Exception $e) {
            $outstanding_bills = [];
            Session::flash('error', 'Gagal terhubung ke API untuk mengambil daftar Tagihan Outstanding.');
        }

        return view('pembayaran.create', [
            'list_bills' => $outstanding_bills,
            'default_date' => now()->toDateString() 
        ]);
    }

    /**
     * Menyimpan data Pembayaran yang diinput manual ke API (POST payments/{bill}).
     */
    public function store(Request $request)
    {
        // 🛑 [FIXED] AMBIL TOKEN DI DALAM METHOD
        $token = Session::get('token'); 
        if (!$token) {
            return redirect()->route('login')->with('warning', 'Sesi login telah berakhir.');
        }

        // ... (Validasi dan Payload sama) ...
        $request->validate([
            'bill_id' => 'required|integer', 
            'amount_paid' => 'required|numeric|min:1000', 
            'payment_method' => 'required|string|in:cash,transfer', 
            'payment_date' => 'required|date', 
        ]);

        $bill_id = $request->bill_id;
        $payload = [
            'amount_paid' => $request->amount_paid, 
            'payment_method' => $request->payment_method, 
            'payment_date' => $request->payment_date, 
        ];


        try {
            // 🛑 [FIXED] Gunakan variabel $token lokal
            $response = Http::withToken($token)
            ->withoutCookie()
            ->post("{$this->apiBase}/payments/{$bill_id}", $payload);

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                return redirect()->route('pembayaran.index', ['tab' => 'riwayat'])->with('success', 'Pembayaran manual berhasil disimpan dan dikonfirmasi!');
            }
            
            $error_message = $response->json()['message'] ?? 'Gagal menyimpan pembayaran manual.';
            return back()->withInput()->with('error', $error_message);
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Koneksi ke server API gagal saat menyimpan pembayaran.');
        }
    }

    /**
     * Menampilkan detail transaksi pembayaran.
     */
    public function show($id)
    {
        // 🛑 [FIXED] AMBIL TOKEN DI DALAM METHOD
        $token = Session::get('token'); 
        if (!$token) {
            return redirect('/login')->with('warning', 'Sesi login telah berakhir.');
        }

        try {
            // 🛑 [FIXED] Gunakan variabel $token lokal
            $response = Http::
            withToken($token)
            ->withoutCookie()
            ->get("{$this->apiBase}/payment-reports/{$id}");

            if ($response->failed()) {
                if ($response->status() === 404) {
                    abort(404, 'Data Transaksi dengan ID ' . $id . ' tidak ditemukan.');
                }
                if ($response->status() === 401) {
                    Session::forget('token');
                    return redirect('/login')->with('warning', 'Token tidak valid. Silakan login ulang.');
                }
                abort($response->status(), 'Gagal mengambil data detail transaksi dari API.');
            }

            $data = $response->json();
            $transaksi = ($data['success'] ?? false) ? (object)$data['data'] : null;

        } catch (\Exception $e) {
            abort(500, 'Koneksi ke server API gagal saat mengambil detail transaksi.');
        }

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak valid atau kosong.');
        }
        
        return view('pembayaran.show', ['transaksi' => $transaksi]);
    }
}