<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // hanya user aktif boleh login
        $credentials['is_active'] = 'active';

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        /**
         * URUTAN PENTING:
         * role "pimpinan" / "kasubag" biasanya level atas
         * taruh lebih dulu
         */
        if ($user->hasRole('pimpinan')) {
            return redirect()->intended(route('pimpinan.dashboard'));
        }

        if ($user->hasRole('kasubag')) {
            return redirect()->intended(route('kasubag.dashboard'));
        }

        if ($user->hasRole('sarpras')) {
            return redirect()->intended(route('sarpras.dashboard'));
        }

        if ($user->hasRole('ormawa')) {
            return redirect()->intended(route('ormawa.dashboard'));
        }

        if ($user->hasRole('dosen')) {
            return redirect()->intended(route('dosen.dashboard'));
        }

        if ($user->hasRole('karyawan')) {
            return redirect()->intended(route('karyawan.dashboard'));
        }

        if ($user->hasRole('mahasiswa')) {
            return redirect()->intended(route('mahasiswa.dashboard'));
        }

        // kalau user tidak punya role
        Auth::logout();

        return back()->withErrors([
            'email' => 'Akun belum memiliki role. Hubungi admin.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

