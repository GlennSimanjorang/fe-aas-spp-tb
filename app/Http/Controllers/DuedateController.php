<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class DuedateController extends Controller
{
    protected $apiBase;

    public function __construct()
    {
        $this->apiBase = 'https://web-app-spp-tb-production.up.railway.app/api';
    }

    /**
     * Tampilkan daftar tunggakan (due date alerts) dengan pagination.
     * Mengambil data bills (paginated) dari API, lalu memfilter yang overdue.
     */
    public function index(Request $request)
    {
        try {
            $token = session('token');
            $page  = $request->query('page', 1);

            // Panggil API bills dengan page
            $response = Http::withToken($token)
                ->get($this->apiBase . "/bills?page={$page}");

            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengambil data tunggakan dari API');
            }

            $json = $response->json();

            // Ambil pagination object (content) dan data array
            $pagination = $json['content'] ?? [];
            $rawBills   = $pagination['data'] ?? [];

            // Filter: hanya tagihan yang belum lunas (unpaid / partial) dan due_date sudah lewat
            $today = Carbon::today();

            $tunggakan = collect($rawBills)
                ->filter(function ($b) use ($today) {
                    // Pastikan field due_date & status ada
                    if (empty($b['due_date'])) return false;
                    $status = $b['status'] ?? null;
                    if ($status === 'paid') return false;

                    try {
                        $due = Carbon::parse($b['due_date']);
                    } catch (\Throwable $e) {
                        return false;
                    }

                    return $due->lt($today);
                })
                ->map(function ($b) {
                    return (object) [
                        'id'        => $b['id'] ?? null,
                        'student'   => $b['student']['name'] ?? ($b['student_name'] ?? '-'),
                        'nisn'      => $b['student']['nisn'] ?? '-',
                        'kelas'     => $b['student']['kelas'] ?? '-',
                        'kategori'  => $b['payment_category']['name'] ?? ($b['month_year'] ?? '-'),
                        'amount'    => $b['amount'] ?? 0,
                        'paid'      => $b['total_paid'] ?? 0,
                        'status'    => $b['status'] ?? '-',
                        'due_date'  => $b['due_date'] ?? null,
                    ];
                })
                ->values(); // reindex

            // Kirim ke view: tunggakan + pagination meta (agar view bisa render pagination links)
            return view('tunggakan.index', [
                'tunggakan'  => $tunggakan,
                'pagination' => $pagination
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
