<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session; // Pastikan ini di-use
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $response = Http::post('http://127.0.0.1:8001/api/signin', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $data = $response->json();

        if (isset($data['success']) && $data['success']) {
            $token = $data['content']['token'] ?? null;
            
            // --- DEBUGGING ROLE ---
            // ASUMSI: Role ada di 'content' atau 'content' -> 'user'
            
            // Coba ambil dari berbagai tempat yang mungkin:
            $userRole = null;
            if (isset($data['content']['user']['role'])) {
                $userRole = $data['content']['user']['role']; // Skenario A
            } elseif (isset($data['content']['role'])) {
                $userRole = $data['content']['role']; // Skenario B
            }
            
            // Jika tetap tidak ditemukan, set ke 'user'
            $userRole = $userRole ?? 'user'; 
            
            // 🛑 DEBUGGING ALERT: Tampilkan apa yang sebenarnya tersimpan
            // Jika ini di-run di browser, Anda akan melihat pop-up yang memberitahu role
            // dd("Role yang diterima: " . $userRole, $data); 
            // Coba debug ini di local:
            
            if ($token) {
                Session::put('token', $token);
                Session::put('user_role', $userRole);

                if ($userRole === 'admin') {
                    // Jika ini yang benar, kita berhasil!
                    return redirect()->route('dashboard');
                } else {
                    Session::forget(['token', 'user_role']);
                    // Pesan error ini yang muncul, memastikan $userRole bukan 'admin'
                    return redirect()->back()->withErrors([
                        'email' => "Akses ditolak. Hanya Admin yang diizinkan. Role yang diterima: " . $userRole
                    ])->withInput();
                }
            }
        }

        // Jika login gagal
        return redirect()->back()->withErrors([
            'email' => $data['message'] ?? 'Login gagal. Silakan coba lagi.'
        ])->withInput();
    }

    public function logout()
    {
        $token = session('token');
        if ($token) {
            Http::withToken($token)->post('http://127.0.0.1:8001/api/signout');
        }

        session()->forget('token');

        return redirect()->route('login');
    }
}
