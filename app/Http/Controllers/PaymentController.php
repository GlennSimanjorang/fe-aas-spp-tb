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

    public function create(Request $request)
    {
        try {
            $token = session('token');

            // Ambil semua siswa
            $students = Http::withToken($token)
                ->get('https://web-app-spp-tb-production.up.railway.app/api/students')
                ->json()['content'] ?? [];

            // Ambil semua kategori pembayaran
            $categories = Http::withToken($token)
                ->get('https://web-app-spp-tb-production.up.railway.app/api/payment-categories')
                ->json()['content'] ?? [];

            // Ambil academic years
            $years = Http::withToken($token)
                ->get('https://web-app-spp-tb-production.up.railway.app/api/academic-years')
                ->json()['content'] ?? [];

            return view('pembayaran.create', compact('students', 'categories', 'years'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
{
    try {
        $token = session('token');

        $validated = $request->validate([
            'student_id'            => 'required|integer',
            'payment_categories_id' => 'required|integer',
            'academic_years_id'     => 'required|integer',
        ]);

        // Kirim ke API
        $response = Http::withToken($token)
            ->withoutRedirecting()
            ->post('https://web-app-spp-tb-production.up.railway.app/api/bills', $validated);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal membuat tagihan.')->withInput();
        }

        $json = $response->json();

        if (!($json['success'] ?? false)) {
            return back()->with('error', $json['message'] ?? 'Gagal membuat tagihan.')->withInput();
        }

        // SUCCESS → redirect ke index
        if ($response->status() === 302 || ($response->json()['success'] ?? false)) {
    return redirect()->route('pembayaran.index')
                     ->with('success', 'Tagihan berhasil dibuat');
}
    } catch (\Exception $e) {
        return back()->with('error', 'Error: '.$e->getMessage());
    }
}
}
