<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended('/admin/dasbor');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // cek apakah email ada terlebih dahulu
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => '*Email tidak ditemukan.',
            ])->onlyInput('email');
        }

        // Pengecekan STATUS PENGGUNA
        if ($user->status_pengguna === 'tidak aktif') {
            // Akun tidak aktif, kirim pesan error
            return back()->withErrors([
                'username' => 'Akun Anda tidak aktif. Silakan hubungi Administrator.',
            ])->onlyInput('username');
        }

        // cek password benar/tidak
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            return back()->withErrors([
                'password' => '*Kata sandi salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // batas hak akses role
        if ($user->role !== 'admin' && $user->role !== 'editor ub') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => ['Anda tidak memiliki akses ke area admin.'],
            ]);
        }

        return redirect()->intended('/admin/dasbor');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
