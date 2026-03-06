<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        // scope default sudah cukup untuk email + basic profile
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // Jika kamu pakai HTTPS/proxy/cookie issue, kadang perlu ->stateless()
        // $googleUser = Socialite::driver('google')->stateless()->user();

        // $googleUser = Socialite::driver('google')->user();
        $googleUser = Socialite::driver('google')->stateless()->user();


        $email = $googleUser->getEmail();

        // 1) Jika sebelumnya user sudah pernah login google (google_id cocok)
        $user = User::where('google_id', $googleUser->getId())->first();

        // 2) Kalau belum, coba cocokkan dari email (biar akun email yang sama nyambung)
        if (!$user && $email) {
            $user = User::where('email', $email)->first();
        }

        // 3) Kalau tetap belum ada, buat user baru
        if (!$user) {
            $user = User::create([
                'nama_lengkap' => $googleUser->getName() ?? 'User Google',
                'email'        => $email,
                // password random (tidak dipakai login manual)
                'password'     => Str::random(32),
                // karena tabel kamu wajib nomor_induk unique:
                // bikin default unik biar tidak gagal insert
                'nomor_induk'  => 'GG-' . Str::upper(Str::random(4)),
                'is_active'    => 'active',
                'google_id'    => $googleUser->getId(),
                'avatar'       => $googleUser->getAvatar(),
            ]);

            // Optional: kasih role default (misal mahasiswa)
            // Pastikan roles sudah ada di table role
            $user->syncRoles(['mahasiswa']);
        } else {
            // Update google_id/avatar jika belum tersimpan
            $user->update([
                'google_id' => $user->google_id ?? $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);
        }

        // Login-kan user
        Auth::login($user, true);

        // Redirect sesuai role kamu (pimpinan/kasubag/sarpras/ormawa/dosen/karyawan/mahasiswa)
        if ($user->hasRole('pimpinan'))   return redirect()->route('pimpinan.dashboard');
        if ($user->hasRole('kasubag'))    return redirect()->route('kasubag.dashboard');
        if ($user->hasRole('sarpras'))    return redirect()->route('sarpras.dashboard');
        if ($user->hasRole('ormawa'))     return redirect()->route('ormawa.dashboard');
        if ($user->hasRole('dosen'))      return redirect()->route('dosen.dashboard');
        if ($user->hasRole('karyawan'))   return redirect()->route('karyawan.dashboard');
        if ($user->hasRole('mahasiswa'))  return redirect()->route('mahasiswa.dashboard');

        return redirect()->route('home');
    }
}
