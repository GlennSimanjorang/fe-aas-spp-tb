<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DuedateController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'overview');

        // Data Dummy untuk semua Cards (Active & Critical)
        $cards = [
            'aktif' => [
                (object)['title' => 'Total Tunggakan Aktif', 'value' => 'Rp 8.750.000', 'icon_bg' => 'bg-green-100', 'icon_color' => 'text-green-600', 'icon_path' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                (object)['title' => 'Tunggakan 1 bulan', 'value' => '15', 'icon_bg' => 'bg-orange-100', 'icon_color' => 'text-orange-600', 'icon_path' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z'],
                (object)['title' => 'Tunggakan 2 bulan', 'value' => '8', 'icon_bg' => 'bg-red-100', 'icon_color' => 'text-red-600', 'icon_path' => 'M18.364 18.364A9 9 0 0012 3.25V7.5L8.5 4l3.5-3.5V0a9 9 0 00-6.364 15.364L3.27 16.73A11.002 11.001 0 011 12C1 5.477 6.477 0 13 0s12 5.477 12 12-5.477 12-12 12a11.002 11.001 0 01-4.73-1.27l1.414-1.414z'],
            ],
            'kritis' => [
                (object)['title' => 'Total Tunggakan Kritis', 'value' => 'Rp 3.500.000', 'icon_bg' => 'bg-red-100', 'icon_color' => 'text-red-600', 'icon_path' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                (object)['title' => 'Tunggakan > 2 bulan', 'value' => '7', 'icon_bg' => 'bg-orange-100', 'icon_color' => 'text-orange-600', 'icon_path' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z'],
                (object)['title' => 'Tunggakan > 3 bulan', 'value' => '4', 'icon_bg' => 'bg-red-100', 'icon_color' => 'text-red-600', 'icon_path' => 'M18.364 18.364A9 9 0 0012 3.25V7.5L8.5 4l3.5-3.5V0a9 9 0 00-6.364 15.364L3.27 16.73A11.002 11.001 0 011 12C1 5.477 6.477 0 13 0s12 5.477 12 12-5.477 12-12 12a11.002 11.001 0 01-4.73-1.27l1.414-1.414z'],
            ],
            'overview' => [
                (object)['title' => 'Total Tunggakan', 'value' => 'Rp 12.250.000', 'icon_bg' => 'bg-blue-100', 'icon_color' => 'text-blue-600', 'icon_path' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                (object)['title' => 'Tunggakan Aktif (1-2 Bulan)', 'value' => '23 Siswa', 'icon_bg' => 'bg-orange-100', 'icon_color' => 'text-orange-600', 'icon_path' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z'],
                (object)['title' => 'Tunggakan Kritis (> 2 Bulan)', 'value' => '7 Siswa', 'icon_bg' => 'bg-red-100', 'icon_color' => 'text-red-600', 'icon_path' => 'M18.364 18.364A9 9 0 0012 3.25V7.5L8.5 4l3.5-3.5V0a9 9 0 00-6.364 15.364L3.27 16.73A11.002 11.001 0 011 12C1 5.477 6.477 0 13 0s12 5.477 12 12-5.477 12-12 12a11.002 11.001 0 01-4.73-1.27l1.414-1.414z'],
            ],
        ];

        // Data Dummy Tabel
        $duedate_data = [
            (object)['no' => 1, 'nama' => 'Ahmad Fauzi', 'kelas' => 'XII RPL 1', 'jumlah' => 'Rp 1.200.000', 'lama' => '2 bulan'],
            (object)['no' => 2, 'nama' => 'Satria Bintang', 'kelas' => 'XI AKL 2', 'jumlah' => 'Rp 600.000', 'lama' => '1 bulan'],
            (object)['no' => 3, 'nama' => 'Agung Pratama', 'kelas' => 'X TKJ 3', 'jumlah' => 'Rp 2.400.000', 'lama' => '4 bulan'],
            (object)['no' => 4, 'nama' => 'Cindy Melati', 'kelas' => 'XII BDP 1', 'jumlah' => 'Rp 3.000.000', 'lama' => '5 bulan'],
        ];

        // Logic Filter Data Tabel Berdasarkan Tab
        if ($tab == 'aktif') {
            // Contoh filter: Tunggakan 1-2 bulan (Index 0, 1)
            $filtered_data = array_filter($duedate_data, fn($d) => in_array($d->lama, ['1 bulan', '2 bulan']));
        } elseif ($tab == 'kritis' || $tab == 'overview') {
            // Contoh filter: Tunggakan > 2 bulan (Index 2, 3)
            $filtered_data = array_filter($duedate_data, fn($d) => !in_array($d->lama, ['1 bulan', '2 bulan']));
        } else {
             // Default ke overview
            $filtered_data = $duedate_data;
        }

        return view('tunggakan.index', [
            'tab' => $tab,
            'cards' => $cards[$tab] ?? $cards['overview'], // Kirim cards sesuai tab
            'duedate_data' => array_values($filtered_data), // Kirim data tabel yang sudah difilter
        ]);
    }
}