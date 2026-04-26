<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function verifikasiPeminjaman(Request $request)
    {
        $user = Auth::user();
        $userRoles = $user->roles->pluck('nama');

        $query = Peminjaman::with([
                'ruangan.gedung.kampus',
                'pemohon.roles',
                'verifikasiAktif'
            ])
            ->where('status', 'pending')

            // ❗ hanya ambil yang step verifikasinya cocok dengan user login
            ->where(function ($q) use ($userRoles) {
                $q->whereDoesntHave('verifikasi') // ⬅️ BELUM ADA VERIFIKASI (pengajuan baru)
                ->orWhereHas('verifikasiAktif', function ($q2) use ($userRoles) {
                    $q2->whereIn('role_verifikator', $userRoles);
                });
            })

            // ❗ pastikan jenis pemohon sesuai dengan alur
            ->whereHas('pemohon.roles', function ($q) use ($userRoles) {
                $q->whereIn('nama', function ($sub) use ($userRoles) {
                    $sub->select('jenis_pemohon')
                        ->from('alur_verifikasi')
                        ->whereIn('role_verifikator', $userRoles);
                });
            })

            // ❗ belum diverifikasi oleh user ini
            ->whereDoesntHave('verifikasi', function ($q) use ($user) {
                $q->where('id_verifikator', $user->nomor_induk);
            });


        // SEARCH
        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->oldest()->paginate(5);

    return view('layouts.pimpinan.peminjaman.verifikasi_peminjaman', compact('peminjaman'));
    }

    public function riwayatVerifikasi( Request $request)
    {
        $userId = Auth::user()->nomor_induk;
        $query = Peminjaman::with(['ruangan.gedung.kampus', 'pemohon', 'verifikasi' => fn($q) => $q->orderBy('urutan')])
            ->whereHas('verifikasi', function ($q) use ($userId) {
                $q->where('id_verifikator', $userId);
            });

            // SEARCH
        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(5);

        return view('layouts.pimpinan.peminjaman.riwayat_verifikasi', compact('peminjaman'));
    }


}
