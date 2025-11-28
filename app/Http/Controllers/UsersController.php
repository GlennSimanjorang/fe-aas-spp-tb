<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
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

    /**
     * ADMIN TOKEN — jika peran admin butuh token berbeda, set di sini.
     * Kalau tidak butuh, pakai session biasa.
     */
    private function getAdminToken()
    {
        return $this->token;
    }

    // =========================================================
    // INDEX
    // =========================================================
    public function index()
    {
        try {
            $response = Http::withToken($this->token)
                ->get($this->apiBase . 'users');

            if (!$response->successful()) {
                return view('daftar_user.index', ['users' => collect()])
                    ->with('error', $response->json('message') ?? 'Gagal memuat data user');
            }

            $users = collect($response->json('content.data') ?? [])
                ->map(fn($u) => (object) $u);

            return view('daftar_user.index', compact('users'));

        } catch (\Exception $e) {
            return view('daftar_user.index', ['users' => collect()])
                ->with('error', 'Koneksi ke API gagal');
        }
    }

    // =========================================================
    // CREATE
    // =========================================================
    public function create()
    {
        return view('daftar_user.create');
    }

    // =========================================================
    // STORE
    // =========================================================
    public function store(Request $request)
    {
        $token = $this->getAdminToken();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'role' => 'required|in:admin,parents',
            'number' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $response = Http::withToken($token)
                ->post($this->apiBase . 'users', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => $request->role,
                    'number' => $request->number,
                    'password' => $request->password,
                    'password_confirmation' => $request->password_confirmation,
                ]);

            if ($response->successful()) {
                return redirect()->route('users.index')
                    ->with('success', 'User berhasil dibuat!');
            }

            if ($response->status() === 422) {
                return back()
                    ->withInput()
                    ->withErrors($response->json('errors') ?? [])
                    ->with('error', $response->json('message'));
            }

            return back()->withInput()->with('error', $response->json('message'));

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'API tidak dapat dihubungi.');
        }
    }

    // =========================================================
    // EDIT
    // =========================================================
    public function edit($id)
    {
        $response = Http::withToken($this->token)
            ->get($this->apiBase . "users/$id");

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data user.');
        }

        $user = (object) $response->json('content');

        return view('daftar_user.edit', compact('user'));
    }

    // =========================================================
    // UPDATE
    // =========================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|in:admin,parents',
            'number' => 'nullable|string',
        ]);

        $response = Http::withToken($this->token)
            ->put($this->apiBase . "users/$id", [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'number' => $request->number,
            ]);

        if ($response->successful()) {
            return redirect()->route('users.index')
                ->with('success', 'User berhasil diperbarui!');
        }

        return back()->with('error', $response->json('message') ?? 'Gagal update user.');
    }

    // =========================================================
    // DELETE
    // =========================================================
    public function destroy($id)
    {
        $token = $this->getAdminToken();

        try {
            $response = Http::withToken($token)
                ->delete($this->apiBase . "users/$id");

            if ($response->successful()) {
                return redirect()->route('users.index')
                    ->with('success', 'User berhasil dihapus.');
            }

            return back()->with('error', $response->json('message'));

        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi ke API gagal.');
        }
    }
}
