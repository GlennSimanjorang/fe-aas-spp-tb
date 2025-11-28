<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

class StudentController extends Controller
{
    protected $apiBase;
    protected $token;

    public function __construct()
    {
        // Tetapkan Base URL API
        $this->apiBase = 'http://127.0.0.1:8001/api';

        // Ambil token dari Session
        $this->token = Session::get('token');
    }

    /**
     * Menampilkan daftar siswa.
     */
    public function index()
    {
        try {
            // Ambil data siswa dari API
            $response = Http::withToken($this->token)->get("{$this->apiBase}/students");

            if ($response->failed()) {
                if ($response->status() === 401) {
                    Session::forget('token');
                    return redirect('/login')->with('warning', 'Token tidak valid. Silakan login ulang.');
                }
                $errorMessage = 'Gagal mengambil data dari API (' . $response->status() . ').';
                return view('siswa.index', ['list_siswa' => [], 'cards' => []])
                    ->with('error', $errorMessage);
            }

            $data = $response->json();
            // Data list_siswa dibiarkan array of array sesuai kebutuhan view
            $list_siswa = ($data['success'] ?? false) ? $data['content'] : [];
        } catch (\Exception $e) {
            $list_siswa = [];
            Session::flash('error', 'Koneksi ke server API gagal atau timeout.');
        }

        // Buat cards (gunakan total dari data real)
        $totalAktif = count($list_siswa);
        $totalLulus = 0; // Placeholder

        $cards = [
            (object)['title' => 'Total Siswa Aktif', 'value' => number_format($totalAktif), 'trend' => '0%'],
            (object)['title' => 'Siswa Lulus', 'value' => number_format($totalLulus), 'trend' => '0%'],
        ];

        return view('siswa.index', [
            'list_siswa' => $list_siswa,
            'cards' => $cards,
        ]);
    }

    /**
     * Menampilkan formulir untuk menambah Siswa baru. (FE)
     */
    public function create()
    {
        // Ambil data pendukung (misalnya, daftar kelas) dari API
        try {
            $response = Http::withToken($this->token)->get("{$this->apiBase}/classes");

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                $data = $response->json();
                $list_kelas = $data['content'] ?? [];
                // Ubah menjadi list of objects untuk kemudahan akses di view
                $list_kelas = collect($list_kelas)->map(fn($k) => (object)$k)->all();
            } else {
                $list_kelas = [];
                Session::flash('warning', 'Gagal mengambil data kelas dari API.');
            }
        } catch (\Exception $e) {
            $list_kelas = [];
            Session::flash('error', 'Koneksi API gagal saat mengambil data kelas.');
        }

        return view('siswa.create', [
            'list_kelas' => $list_kelas
        ]);
    }

    /**
     * Mengirim data Siswa baru ke API untuk disimpan (POST). (BE)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:20',
            'nama_siswa' => 'required|string|max:100',
            'kelas' => 'required|string|max:20',
            'user_id' => 'required|string',
        ]);

        $payload = [
            'name' => $request->nama_siswa,
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'user_id' => $request->user_id,
        ];

        try {
            $response = Http::withToken($this->token)->post("{$this->apiBase}/students", $payload);

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
            }

            $error = $response->json();
            if ($response->status() === 422 && isset($error['content'])) {
                return back()->withErrors($error['content'])->withInput();
            }

            return back()->with('error', $error['message'] ?? 'Gagal menyimpan data siswa.')->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi ke server API gagal.')->withInput();
        }
    }

    /**
     * Menampilkan detail siswa.
     */
    public function show($nis)
    {
        try {
            $response = Http::withToken($this->token)->get("{$this->apiBase}/students/{$nis}");

            if ($response->failed()) {
                if ($response->status() === 404) {
                    abort(404, 'Data Siswa dengan NIS ' . $nis . ' tidak ditemukan di API.');
                }
                abort($response->status(), 'Gagal mengambil data detail siswa dari API.');
            }

            $data = $response->json();
            $siswa = ($data['success'] ?? false) ? (object)$data['content'] : null;
        } catch (\Exception $e) {
            abort(500, 'Koneksi ke server API gagal saat mengambil detail siswa.');
        }

        if (!$siswa) {
            abort(404, 'Siswa tidak ditemukan.');
        }

        return view('siswa.show', ['siswa' => $siswa]);
    }

    public function edit($id)
    {
        try {
            $response = Http::withToken($this->token)
                ->get("{$this->apiBase}/students/{$id}");

            if ($response->failed()) {
                return back()->with('error', 'Gagal mengambil data siswa.');
            }

            $data = $response->json();
            $siswa = $data['content'] ?? null;
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi API gagal.');
        }

        return view('siswa.edit', ['siswa' => $siswa]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nisn' => 'required|string|max:20',
            'kelas' => 'required|string|max:20',
            'user_id' => 'required|string',
        ]);

        try {
            $payload = [
                'name' => $request->name,
                'nisn' => $request->nisn,
                'kelas' => $request->kelas,
                'user_id' => $request->user_id,
            ];

            $response = Http::withToken($this->token)
                ->put("{$this->apiBase}/students/{$id}", $payload);

            if ($response->failed()) {
                return back()->with('error', 'Gagal mengupdate siswa.')->withInput();
            }

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi API gagal.')->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            $response = Http::withToken($this->token)
                ->delete("{$this->apiBase}/students/{$id}");

            if ($response->failed()) {
                return back()->with('error', 'Gagal menghapus siswa.');
            }

            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi API gagal.');
        }
    }
}
