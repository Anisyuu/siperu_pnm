<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Alert;

class GoogleController extends Controller
{
    public function redirect()
    {
        // Scope default sudah cukup untuk email + basic profile
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // Jika pakai HTTPS/proxy/cookie issue, stateless biasanya lebih aman
        $googleUser = Socialite::driver('google')->stateless()->user();

        $email = $googleUser->getEmail();

        /*
        |--------------------------------------------------------------------------
        | Validasi email dari Google
        |--------------------------------------------------------------------------
        | Kalau email tidak terbaca dari akun Google, jangan lanjut login.
        */
        if (!$email) {
            Alert::error('Email Google tidak ditemukan. Silakan gunakan akun Google yang valid.');
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Cari user berdasarkan google_id
        |--------------------------------------------------------------------------
        | Ini untuk user yang sebelumnya sudah pernah login pakai Google.
        */
        $user = User::where('google_id', $googleUser->getId())->first();

        /*
        |--------------------------------------------------------------------------
        | Jika google_id belum cocok, cari berdasarkan email
        |--------------------------------------------------------------------------
        | Ini untuk akun lama yang sudah ada di tabel users,
        | tapi belum pernah login pakai Google.
        */
        if (!$user) {
            $user = User::where('email', $email)->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Jika email belum terdaftar di tabel users
        |--------------------------------------------------------------------------
        | Jangan create user baru.
        | Kembalikan ke halaman login dengan pesan error.
        */
        if (!$user) {
            Alert::error('Gagal' , 'Akun Anda belum terdaftar. Silakan hubungi admin kasubag.');
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Cek status akun
        |--------------------------------------------------------------------------
        | Kalau sistemmu pakai is_active = active/inactive,
        | user inactive tidak boleh login.
        */
        if ($user->is_active !== 'active') {
            Alert::error('Gagal' , 'Akun Anda tidak aktif. Silakan hubungi admin kasubag.');
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Update google_id dan avatar
        |--------------------------------------------------------------------------
        | Hanya update data pendukung.
        | Tidak membuat user baru.
        */
        $user->update([
            'google_id' => $user->google_id ?? $googleUser->getId(),
            'avatar'    => $googleUser->getAvatar(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Login user
        |--------------------------------------------------------------------------
        */
        Auth::login($user, true);

        /*
        |--------------------------------------------------------------------------
        | Redirect sesuai role
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('pimpinan')) {
            return redirect()->route('pimpinan.dashboard');
        }

        if ($user->hasRole('kasubag')) {
            return redirect()->route('kasubag.dashboard');
        }

        if ($user->hasRole('sarpras')) {
            return redirect()->route('sarpras.dashboard');
        }

        if ($user->hasRole('ormawa')) {
            return redirect()->route('ormawa.dashboard');
        }

        if ($user->hasRole('dosen')) {
            return redirect()->route('dosen.dashboard');
        }

        if ($user->hasRole('karyawan')) {
            return redirect()->route('karyawan.dashboard');
        }

        if ($user->hasRole('mahasiswa')) {
            return redirect()->route('mahasiswa.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Kalau user ada tapi belum punya role
        |--------------------------------------------------------------------------
        | Jangan dibiarkan masuk home sembarangan.
        */
        Auth::logout();

        Alert::error('Gagal' , 'Akun Anda belum memiliki role. Silakan hubungi admin kasubag.');
        return redirect()->route('login');
    }
}
