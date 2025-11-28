<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $token = session('token');
            $page  = $request->query('page', 1); // default page 1

            // Ambil data bills + page dari API backend
            $response = Http::withToken($token)
                ->get("https://web-app-spp-tb-production.up.railway.app/api/bills?page={$page}");

            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengambil data dari API');
            }

            $json = $response->json();

            // Ambil pagination object
            $pagination = $json['content'] ?? [];

            // Ambil data tagihan per halaman
            $rawBills = $pagination['data'] ?? [];

            // Mapping ke object agar enak dipakai di blade
            $bills = collect($rawBills)
                ->sortByDesc('id')
                ->values()
                ->map(function ($bill) {
                    return (object) [
                        'id'      => $bill['id'],
                        'student' => $bill['student_name'] ?? '-',
                        'kategori' => $bill['category_name'] ?? $bill['month_year'] ?? '-',
                        'amount'  => $bill['amount'],
                        'paid'    => $bill['total_paid'],
                        'status'  => $bill['status'],
                        'due'     => $bill['due_date'],
                    ];
                });

            // kirim pagination ke blade juga
            return view('pembayaran.index', [
                'bills'        => $bills,
                'pagination'   => $pagination
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
