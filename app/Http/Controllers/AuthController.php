<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        $response = Http::post('http://127.0.0.1:8001/api/signin', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $data = $response->json();

        if (isset($data['success']) && $data['success']) {

            // SIMPAN TOKEN ADMIN
            session(['admin_token' => $data['content']['token']]);

            return redirect()->route('dashboard');
        }

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
