<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create()
    {
        return view('login'); 
    }

    /**
     * Menangani percobaan login (proses "Sign In").
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'], 
            'password' => ['required'],
        ]);

        // 2. Coba lakukan autentikasi (login)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika berhasil:
            $request->session()->regenerate(); // Regenerate session untuk keamanan

            // 3. Redirect ke dashboard DENGAN PESAN SUKSES (BARU)
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Login berhasil! Selamat datang kembali.'); // <-- BARIS INI DITAMBAHKAN
        }

        // 4. Jika gagal:
        // Kembalikan ke halaman login dengan pesan error
        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->redirectTo(route('login')); 
    }

    /**
     * Menangani proses logout.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login setelah logout
        return redirect(route('login')); 
    }
}