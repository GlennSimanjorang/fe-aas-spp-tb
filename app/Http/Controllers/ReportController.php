<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman dashboard daftar laporan.
     */
    public function index()
    {
        // =========================================================
        // DUMMY DATA: Daftar Jenis Laporan yang akan ditampilkan
        // =========================================================
        $report_types = [
            (object)['title' => 'Laporan Harian', 'route_name' => 'report.export', 'type' => 'daily'],
            (object)['title' => 'Laporan Bulanan', 'route_name' => 'report.export', 'type' => 'monthly'],
            (object)['title' => 'Laporan Tunggakan', 'route_name' => 'report.export', 'type' => 'due_date'],
            (object)['title' => 'Laporan Tahunan', 'route_name' => 'report.export', 'type' => 'yearly'],
            (object)['title' => 'Rekap Bank', 'route_name' => 'report.export', 'type' => 'bank_recap'],
            (object)['title' => 'Laporan per Kelas', 'route_name' => 'report.export', 'type' => 'per_class'],
        ];

        // Kirim data jenis laporan ke view
        return view('laporan.index', [
            'report_types' => $report_types,
        ]);
    }

    /**
     * Menangani permintaan export laporan.
     * Nanti di sini logic untuk generate file Excel/PDF.
     */
    public function export(Request $request, $type)
    {
        // Di sini nanti lu taruh logic untuk generate file laporan.
        // Contoh: return Excel::download(new ReportExport($type), "Laporan_{$type}_" . now() . ".xlsx");
        
        // Untuk sekarang, kita kembalikan pesan sederhana.
        return back()->with('success', "Proses Export Laporan Jenis '{$type}' sedang berjalan.");
    }
}