<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AcademicYearWebController extends Controller
{
    protected $apiBase;
    protected $token;

    public function __construct()
    {
        // Base URL API
        $this->apiBase = 'https://web-app-spp-tb-production.up.railway.app/api/';

        // Ambil token dari session
        $this->token = Session::get('token');
    }

    // ===============================
    // INDEX
    // ===============================
    public function index()
    {
        try {
            $response = Http::withToken($this->token)
                ->get($this->apiBase . 'academic-years');

            $years = collect($response->json('content.data') ?? [])
                ->map(fn($y) => (object) $y);

            return view('academic_years.index', compact('years'));

        } catch (\Exception $e) {
            return view('academic_years.index', ['years' => collect()])
                ->with('error', 'Gagal mengambil data.');
        }
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        return view('academic_years.create');
    }

    // ===============================
    // STORE
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'school_years' => 'required|max:9',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after:start_date',
            'is_active'    => 'nullable|boolean',
        ]);

        try {
            $response = Http::withToken($this->token)
                ->post($this->apiBase . 'academic-years', [
                    'school_years' => $request->school_years,
                    'start_date'   => $request->start_date,
                    'end_date'     => $request->end_date,
                    'is_active'    => $request->is_active ?? false,
                ]);

            if ($response->successful()) {
                return redirect()->route('academic-years.index')
                    ->with('success', 'Tahun ajaran berhasil dibuat.');
            }

            return back()->withInput()->with('error', 'Gagal membuat data.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Koneksi ke API gagal.');
        }
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $response = Http::withToken($this->token)
            ->get($this->apiBase . "academic-years/$id");

        if (!$response->successful()) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        $year = (object) $response->json('content');

        return view('academic_years.edit', compact('year'));
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'school_years' => 'required|max:9',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after:start_date',
            'is_active'    => 'nullable|boolean',
        ]);

        try {
            $response = Http::withToken($this->token)
                ->put($this->apiBase . "academic-years/$id", [
                    'school_years' => $request->school_years,
                    'start_date'   => $request->start_date,
                    'end_date'     => $request->end_date,
                    'is_active'    => $request->is_active ?? false,
                ]);

            if ($response->successful()) {
                return redirect()->route('academic-years.index')
                    ->with('success', 'Tahun ajaran berhasil diperbarui.');
            }

            return back()->with('error', 'Gagal update data.');

        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi ke API gagal.');
        }
    }

    // ===============================
    // DELETE
    // ===============================
    public function destroy($id)
    {
        try {
            $response = Http::withToken($this->token)
                ->delete($this->apiBase . "academic-years/$id");

            if ($response->successful()) {
                return redirect()->route('academic-years.index')
                    ->with('success', 'Tahun ajaran berhasil dihapus.');
            }

            return back()->with('error', 'Gagal menghapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi gagal.');
        }
    }
}
