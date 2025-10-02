<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Wajib import ini

class AuthController extends Controller
{
    public function showLogin() // <--- PASTIIN NAMA METHOD INI BENAR
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        // Cek 1: Logic Dummy (Hanya untuk keperluan frontend)
        if ($email == 'admin@test.com' && $password == 'password') {
            

            $user = \App\Models\User::firstOrCreate([
                'email' => $email
            ], [
                // Set password hash dummy
                'password' => bcrypt('password'),
                'name' => 'Admin Dummy' 
            ]);

            // 2. Lakukan proses login (membuat sesi)
            Auth::login($user); 

            return redirect()->route('dashboard'); 
        }

        // Logic Gagal
        return redirect()->back()->withErrors(['email' => 'Kredensial tidak valid.']);
    }
}