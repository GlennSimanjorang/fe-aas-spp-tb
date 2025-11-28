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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        $loginResponse = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:8001/api/signin', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $loginData = $loginResponse->json();
    

        if (!($loginData['success'] ?? false)) {
            return redirect()->back()->withErrors([
                'email' => $loginData['message'] ?? 'Login gagal. Silakan coba lagi.'
            ])->withInput();
        }

        $token = $loginData['content']['token'] ?? null;
        if (!$token) {
            return redirect()->back()->withErrors([
                'email' => 'Token tidak diterima dari server.'
            ])->withInput();
        }
        Session::put('temp_token', $token);

        // Langkah 2: Ambil data user via /self menggunakan token
        $selfResponse = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->get('http://127.0.0.1:8001/api/self');

        $selfData = $selfResponse->json();

        if (!($selfData['success'] ?? false)) {
            // Opsional: logout otomatis di API jika /self gagal
            Http::withToken($token)->post('http://127.0.0.1:8001/api/signout');
            return redirect()->back()->withErrors([
                'email' => 'Gagal memuat data profil pengguna.'
            ]);
        }

        $userRole = $selfData['content']['role'] ?? 'user';
        $userEmail = $selfData['content']['email'] ?? $request->email;
        
        if ($userRole === 'admin') {
            Session::put('token', $token);
            Session::put('user_role', $userRole);
            Session::put('user_email', $userEmail);
            return redirect()->route('dashboard');
        } else {
            // Opsional: logout di API karena akses ditolak
            Http::withToken($token)->post('http://127.0.0.1:8001/api/signout');
            return redirect()->back()->withErrors([
                'email' => "Akses ditolak. Hanya Admin yang diizinkan. Role yang diterima: " . $userRole
            ])->withInput();
        }
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
