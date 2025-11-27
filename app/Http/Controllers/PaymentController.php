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
        // Sesuaikan dengan konfigurasi API Anda
        $this->apiBase = 'http://127.0.0.1:8001/api'; 
        $this->token = Session::get('token');
    }

    /**
     * Menampilkan halaman utama manajemen pembayaran dengan tab.
     * Mengambil data dari /payment-reports API dengan filter status.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');
        $payment_data = [];
        $cards = [];
        
        // Tentukan filter query untuk endpoint API Payment Reports
        $filter_status = '';
        switch ($tab) {
            case 'riwayat':
                $filter_status = 'success'; // Status success untuk riwayat lunas (sesuai backend)
                break;
            case 'bukti':
                $filter_status = 'success'; // Bukti transfer biasanya yang sudah sukses/lunas
                break;
            case 'pending':
            default:
                $filter_status = 'pending'; // Status pending untuk menunggu konfirmasi (dari Midtrans/VA)
                break;
        }

        try {
            // Panggil endpoint Payment Reports dengan filter status
            $response = Http::withToken($this->token)
                            ->get($this->apiBase . '/payment-reports', ['status' => $filter_status]);
            
            $raw_data = [];

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                $raw_data = $response->json()['data'] ?? []; // Asumsi API Resource menggunakan key 'data'
            } else {
                Session::flash('error', 'Gagal memuat data pembayaran dari API Payment Reports (' . $response->status() . ').');
            }
            
            // Mapping Data ke format yang dibutuhkan View
            $payment_data = collect($raw_data)->map(function($data) {
                $data = (object)$data;
                // Sesuaikan key di bawah ini dengan key yang ada di response Payment Report API Anda
                return (object)[
                    'id_transaksi' => $data->id, 
                    'waktu' => isset($data->created_at) ? Carbon::parse($data->created_at)->format('d/m/Y H:i') : 'N/A',
                    'nis' => $data->student_nisn ?? 'N/A',
                    'nama' => $data->student_name ?? 'N/A',
                    'kelas' => $data->class_name ?? 'N/A',
                    'periode' => $data->payment_period ?? 'N/A',
                    'jumlah' => 'Rp ' . number_format($data->amount_paid ?? 0, 0, ',', '.'), // Menggunakan amount_paid
                    'metode' => $data->payment_method ?? 'N/A',
                    'bukti' => $data->midtrans_transaction_id ?? $data->proof_ref ?? 'N/A', 
                    'status' => ucfirst($data->status ?? 'pending'), 
                ];
            })->all();

            // Ambil data CARD/STATISTIK (jika ada endpoint terpisah, atau gunakan dummy)
            // Anda bisa tambahkan logika pengambilan statistik dari API di sini jika tersedia.
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
     * Mengambil daftar Tagihan yang Outstanding (Bills) dari API.
     */
    public function create()
    {
        try {
            // Ambil daftar Bills (asumsi API mengembalikan status bill)
            $bills_response = Http::withToken($this->token)->get("{$this->apiBase}/bills");

            $list_bills = $bills_response->successful() 
                            ? $bills_response->json()['data'] ?? [] 
                            : [];
            
            // Filter hanya yang statusnya 'outstanding' atau 'partial'
            $outstanding_bills = collect($list_bills)->filter(function($bill) {
                $status = $bill['status'] ?? 'outstanding';
                return in_array($status, ['outstanding', 'partial']);
            })->all();
            
        } catch (\Exception $e) {
            $outstanding_bills = [];
            Session::flash('error', 'Gagal terhubung ke API untuk mengambil daftar Tagihan Outstanding.');
        }

        // Kirim list tagihan dan tanggal hari ini sebagai default
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
        // Validasi disesuaikan 100% dengan kebutuhan backend: amount_paid, payment_method, payment_date
        $request->validate([
            'bill_id' => 'required|integer', 
            'amount_paid' => 'required|numeric|min:1000', 
            'payment_method' => 'required|string|in:cash,transfer', 
            'payment_date' => 'required|date', 
        ]);

        $bill_id = $request->bill_id;

        // Siapkan Payload (SESUAIKAN KEY)
        $payload = [
            'amount_paid' => $request->amount_paid, 
            'payment_method' => $request->payment_method, 
            'payment_date' => $request->payment_date, 
        ];

        try {
            // Kirim data ke API: POST payments/{bill_id}
            $response = Http::withToken($this->token)->post("{$this->apiBase}/payments/{$bill_id}", $payload);

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                // Backend otomatis menjadi 'success' untuk cash/transfer, redirect ke riwayat
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
     * Mengambil data dari /payment-reports/{id}
     */
    public function show($id)
    {
        // Di sistem backend ini, tidak ada aksi Konfirmasi/Tolak manual, 
        // sehingga halaman ini hanya untuk melihat detail.

        try {
            // Asumsi: API Payment Report Resource memiliki endpoint show: /payment-reports/{id}
            $response = Http::withToken($this->token)->get("{$this->apiBase}/payment-reports/{$id}");

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
            $transaksi = ($data['success'] ?? false) ? (object)$data['data'] : null; // Asumsi key 'data'

        } catch (\Exception $e) {
            abort(500, 'Koneksi ke server API gagal saat mengambil detail transaksi.');
        }

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak valid atau kosong.');
        }
        
        // Kita hanya menampilkan detail, tanpa tombol konfirmasi/tolak
        return view('pembayaran.show', ['transaksi' => $transaksi]);
    }
    
    // Method confirm dan reject DIHAPUS karena tidak ada endpoint di backend.
}