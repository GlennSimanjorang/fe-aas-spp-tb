<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Menentukan tab aktif, default ke 'pending'
        $tab = $request->query('tab', 'pending');

        // Data statistik di bagian atas (sama untuk semua tab)
        $cards = [
            (object)['title' => 'Menunggu Konfirmasi', 'value' => '3'], // Dari screenshot 'tunggakan.png'
            (object)['title' => 'Total Nilai Pending', 'value' => 'Rp 1.2M'], 
            (object)['title' => 'Hari Ini', 'value' => '12'],
        ];

        // Data Tabel berdasarkan Tab
        $payment_data = [];
        
        // Data detail pembayaran yang konsisten
        $sample_data = (object)[
            'waktu' => '24/07/2025 14:32',
            'nis' => '2024001',
            'nama' => 'Satriya Nur Najmuddin',
            'kelas' => 'XII RPL 2',
            'periode' => 'Juli 2025',
            'jumlah' => 'Rp 5000.000',
            'metode' => 'Transfer Bank',
            'bukti' => 'TF240724001',
        ];

        if ($tab == 'pending') {
            $sample_data->status = 'Pending';
            $sample_data->aksi = 'Lihat Bukti';
            $payment_data[] = $sample_data;
        } elseif ($tab == 'riwayat') {
            $sample_data->status = 'Lunas';
            $sample_data->aksi = 'Lihat Bukti';
            $payment_data[] = $sample_data;
        } elseif ($tab == 'bukti') {
            // Kita bisa pakai data riwayat juga untuk tab Bukti Transfer
            $sample_data->status = 'Lunas';
            $sample_data->aksi = 'Lihat Bukti';
            $payment_data[] = $sample_data;
        }

        return view('pembayaran.index', [
            'tab' => $tab,
            'cards' => $cards,
            'payment_data' => $payment_data, // Data yang akan di-looping di tabel
        ]);
    }
}