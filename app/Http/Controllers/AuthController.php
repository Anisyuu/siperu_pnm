<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

        if ($user->hasRole('kalab')) {
            return redirect()->intended(route('kalab.dashboard'));
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

    /**
     * Tampilkan halaman profile pengguna
     */
    public function profile()
    {
        $user = Auth::user()->load('roles');

        return view('auth.profile', compact('user'));
    }

    /**
     * Update data profile pengguna
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'no_telp'      => ['nullable', 'string', 'max:20'],
            'email'        => [
                'required',
                'email',
                'max:255',
                Rule::unique('user', 'email')->ignore($user->nomor_induk, 'nomor_induk'),
            ],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah digunakan oleh pengguna lain.',
        ]);

        $user->update($validated);

        return back()->with('success_profile', 'Profile berhasil diperbarui.');
    }

    /**
     * Update password pengguna
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'password_lama' => ['required'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password.required'      => 'Password baru wajib diisi.',
            'password.min'           => 'Password baru minimal 8 karakter.',
            'password.confirmed'     => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($validated['password_lama'], $user->password)) {
            return back()
                ->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                ->withInput();
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        return back()->with('success_password', 'Password berhasil diperbarui.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
 * Tampilkan halaman lupa password
 */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim link reset password ke email
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email belum terdaftar di sistem. Silakan hubungi admin atau kasubag.'])
                ->withInput();
        }

        if ($user->is_active !== 'active') {
            return back()
                ->withErrors(['email' => 'Akun Anda tidak aktif. Silakan hubungi admin atau kasubag.'])
                ->withInput();
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::ResetLinkSent) {
            return back()->with('success', 'Link reset password berhasil dikirim ke email Anda.');
        }

        return back()
            ->withErrors(['email' => 'Gagal mengirim link reset password. Coba lagi nanti.'])
            ->withInput();
    }

    /**
     * Tampilkan halaman reset password
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Simpan password baru
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'token.required'      => 'Token reset password tidak valid.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'password.required'   => 'Password baru wajib diisi.',
            'password.min'        => 'Password baru minimal 8 karakter.',
            'password.confirmed'  => 'Konfirmasi password baru tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PasswordReset) {
            return redirect()
                ->route('login')
                ->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
        }

        return back()
            ->withErrors(['email' => 'Token reset password tidak valid atau sudah kedaluwarsa.'])
            ->withInput();
    }
}
