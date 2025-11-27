<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = Session::get('token');
        $userRole = Session::get('user_role'); // <--- Ambil role dari session

        // 1. Cek Token
        if (!$token || !$userRole) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek Role (tanpa API call)
        if ($userRole !== 'admin') {
            Session::forget(['token', 'user_role']);
            return redirect()->route('login')->with('error', 'Akses ditolak. Hanya Admin yang diizinkan.');
        }

        // Jika token dan role admin ada, lanjutkan request
        return $next($request);
    }
}